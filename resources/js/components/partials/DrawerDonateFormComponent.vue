<template>
    <div>
        <el-button type="success" icon="el-icon-share" size="large" plain/>
        <el-button type="success" @click="showDrawer" class="sharp-left">
            Donate
        </el-button>
        <a-drawer
                title="How much do you wish to donate?"
                :width="720"
                :visible="visible"
                :body-style="{ paddingBottom: '80px' }"
                @close="onClose"
        >
            <a-form :form="form" layout="horizontal" hide-required-mark id="donation-form">
                <div class="row">
                    <div class="col-12">
                        <h6>Your Donation</h6>
                        <!--                        <label for="donacija">Donacija</label>-->
                        <el-button type="success" id="donacija" plain @click="toPickAmount(10)">€10</el-button>
                        <el-button type="success" plain @click="toPickAmount(20)">€20</el-button>
                        <el-button type="success" plain @click="toPickAmount(30)">€30</el-button>
                        <el-button type="success" plain @click="toPickAmount(50)">€50</el-button>
                        <el-button type="success" plain @click="toPickAmount(100)">€100</el-button>
                        <el-button type="success" plain @click="toPickAmount(500)">€500</el-button>
                        <a-input-number size="large" :min="1" :max="100000" prefix="€" placeholder="€"
                                        @change="toPickAmount"/>
                        <h6 class="error">{{this.error.euro_amount}}</h6>
                    </div>
                    <div class="col-12 donate-radio">
                        <!--                        <h6>U slučaju nepostignutog cilja kampanje u dogovorenom roku,</h6>-->
                        <h6>In case the campaign goal is not reached by the end of the established deadline,</h6>
                        <a-radio-group v-model="donation.plan_b" name="radio" id="radio" @change="onChange">
                            <a-radio :style="radioStyle" :value="1" selected>
                                <!--                                <p>želim da organizacija zadrži moju donaciju.</p>-->
                                <p>I want to leave the donation with this campaign regardless.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="2">
                                <!--                                <p>želim da moja donacija bude prosleđena drugoj kampanji po mom biranju.</p>-->
                                <p>I want the donation to be forwarded to another campaign of my choosing.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="3">
                                <!--                                <p>želim povraćaj novca.</p>-->
                                <p>I want a full refund.</p>
                            </a-radio>
                        </a-radio-group>
                        <h6 class="error">{{this.error.plan_b}}</h6>
                    </div>
                    <div v-if="donation.plan_b == 2" class="if">
                        <!--                        <h6>Izaberite kampanju kojoj biste preusmerili donaciju:</h6>-->
                        <h6>Choose a campaign You would like to have the donation forwarded to:</h6>
                        <swiper class="swiper backup" :options="swiperOption">
                            <swiper-slide class="campaign" v-for="(campaign, index) in campaigns" :key="index"
                                          v-if="campaign.id != donation.campaign_id">
                                <a-card hoverable>
                                    <img
                                            slot="cover"
                                            alt="Card image cap"
                                            :src="campaign.image"
                                    />
                                    <small class="text-muted">{{campaign.time_left}}</small>
                                    <h3 class="card-title">{{campaign.title}}</h3>
                                    <div class="info">
                                        <small class="text-muted">{{campaign.category.title}}</small>
                                        <h6 class="card-title">Raised: €{{campaign.raised}} | {{campaign.percent}}%</h6>
                                    </div>
                                    <template slot="actions" class="ant-card-actions">
                                        <el-button type="success" icon="el-icon-check" size="large"
                                                   @click="toPickBackup(campaign.id)" plain/>
                                    </template>
                                    <a-card-meta>
                                    </a-card-meta>
                                </a-card>
                            </swiper-slide>
                            <div class="swiper-pagination" slot="pagination"></div>
                        </swiper>
                    </div>

                </div>

            </a-form>
            <div
                    :style="{
          position: 'absolute',
          right: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
          zIndex: 1,
        }"
            >
                <a-button :style="{ marginRight: '8px' }" @click="onClose">
                    Cancel
                </a-button>

                <a-button type="primary" @click="toDonate(); onDonationSubmitBlk();">
                    Donate {{this.button}}
                </a-button>
            </div>
        </a-drawer>
    </div>
</template>


<script>
    const Eth = require('ethjs');

    const Web3 = require('web3');
    let web3 = new Web3(Web3.givenProvider || "https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e");

    import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
    import 'swiper/css/swiper.css'

    export default {
        props: ['campaignid'],
        data() {
            return {
                form: this.$form.createForm(this),
                visible: false,
                donation: {
                    euro_amount: "",
                    plan_b: 1,
                    user_id: "",
                    campaign_id: "",
                    backup_campaign_id: "",
                },
                error: {
                    euro_amount: "",
                    plan_b: "",
                },
                button: "",
                radioStyle: {
                    display: 'block',
                    height: '30px',
                    lineHeight: '30px',
                },
                swiperOption: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                },
                campaigns: {},
                //
                donationId: '',
                donationCreator: '0xdbC4D7B4Ac635845ca1D4C0E779150E4b494A413',
                // donationCreator: '0x80ca7985360c43545C8E1e1a1a4dcEe9641Ecd7b',
                donationCreatorId: '',
                campaignId: '',
                euro_amount: '',
                plan_b: 1,
                backup_campaign_id: 0,
                totalDonatedSum: '',
                //
                // myAccount: '0xdbC4D7B4Ac635845ca1D4C0E779150E4b494A413',
                myAccount: '0x80ca7985360c43545C8E1e1a1a4dcEe9641Ecd7b',
                Contract: '',

            };
        },
        mounted() {
            this.donation.campaign_id = this.campaignid;
            axios.get('/api/campaigns')
                .then((response) => {
                    this.campaigns = response.data;
                    console.log(this.campaigns);
                });
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    this.donationCreatorId = this.user.id;
                    console.log(this.donationCreatorId);
                });


            if (typeof window.web3 !== 'undefined'
                && typeof window.web3.currentProvider !== 'undefined') {
                eth.setProvider(window.web3.currentProvider);
            } else {
                eth.setProvider(new Eth.HttpProvider('https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e')); // set to TestRPC if not available
            }


            // const eth = new Eth(new Eth.HttpProvider('https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e'));
            const abi = [
                {
                    "constant": false,
                    "inputs": [
                        {
                            "name": "_campaignId",
                            "type": "uint256"
                        },
                        {
                            "name": "_donationId",
                            "type": "uint256"
                        }
                    ],
                    "name": "closeCampaign",
                    "outputs": [],
                    "payable": false,
                    "stateMutability": "nonpayable",
                    "type": "function"
                },
                {
                    "constant": false,
                    "inputs": [
                        {
                            "name": "_campaignId",
                            "type": "uint256"
                        },
                        {
                            "name": "_campaignCreatorId",
                            "type": "uint256"
                        },
                        {
                            "name": "_campaignTitle",
                            "type": "string"
                        },
                        {
                            "name": "_campaignDuration",
                            "type": "uint256"
                        },
                        {
                            "name": "_campaignStartTime",
                            "type": "uint256"
                        },
                        {
                            "name": "_category_id",
                            "type": "uint8"
                        },
                        {
                            "name": "_euro_goal",
                            "type": "uint32"
                        },
                        {
                            "name": "_overhead",
                            "type": "uint8"
                        }
                    ],
                    "name": "createCampaign",
                    "outputs": [],
                    "payable": false,
                    "stateMutability": "nonpayable",
                    "type": "function"
                },
                {
                    "constant": false,
                    "inputs": [
                        {
                            "name": "_donationId",
                            "type": "uint256"
                        },
                        {
                            "name": "_donationCreatorId",
                            "type": "uint256"
                        },
                        {
                            "name": "_euro_amount",
                            "type": "uint32"
                        },
                        {
                            "name": "_campaignId",
                            "type": "uint256"
                        },
                        {
                            "name": "_plan_b",
                            "type": "uint8"
                        },
                        {
                            "name": "_backup_campaign_id",
                            "type": "uint256"
                        }
                    ],
                    "name": "donate",
                    "outputs": [],
                    "payable": false,
                    "stateMutability": "nonpayable",
                    "type": "function"
                },
                {
                    "anonymous": false,
                    "inputs": [
                        {
                            "indexed": false,
                            "name": "campaignId",
                            "type": "uint256"
                        },
                        {
                            "indexed": false,
                            "name": "campaignCreatorId",
                            "type": "uint256"
                        },
                        {
                            "indexed": false,
                            "name": "campaignTitle",
                            "type": "string"
                        },
                        {
                            "indexed": false,
                            "name": "overhead",
                            "type": "uint8"
                        },
                        {
                            "indexed": false,
                            "name": "euro_goal",
                            "type": "uint32"
                        },
                        {
                            "indexed": false,
                            "name": "totalDonatedSum",
                            "type": "uint32"
                        },
                        {
                            "indexed": false,
                            "name": "category_id",
                            "type": "uint8"
                        }
                    ],
                    "name": "CampaignResultEvent",
                    "type": "event"
                },
                {
                    "anonymous": false,
                    "inputs": [
                        {
                            "indexed": false,
                            "name": "donationId",
                            "type": "uint256"
                        },
                        {
                            "indexed": false,
                            "name": "donationCreatorId",
                            "type": "uint256"
                        },
                        {
                            "indexed": false,
                            "name": "euro_amount",
                            "type": "uint32"
                        },
                        {
                            "indexed": false,
                            "name": "campaign_id",
                            "type": "uint256"
                        },
                        {
                            "indexed": false,
                            "name": "plan_b",
                            "type": "uint8"
                        },
                        {
                            "indexed": false,
                            "name": "backup_campaign_id",
                            "type": "uint256"
                        }
                    ],
                    "name": "DonationnResultEvent",
                    "type": "event"
                },
                {
                    "constant": true,
                    "inputs": [
                        {
                            "name": "",
                            "type": "uint256"
                        }
                    ],
                    "name": "campaigns",
                    "outputs": [
                        {
                            "name": "campaignCreator",
                            "type": "address"
                        },
                        {
                            "name": "campaignCreatorId",
                            "type": "uint256"
                        },
                        {
                            "name": "campaignTitle",
                            "type": "string"
                        },
                        {
                            "name": "category_id",
                            "type": "uint8"
                        },
                        {
                            "name": "euro_goal",
                            "type": "uint32"
                        },
                        {
                            "name": "campaignStartTime",
                            "type": "uint256"
                        },
                        {
                            "name": "campaignDuration",
                            "type": "uint256"
                        },
                        {
                            "name": "overhead",
                            "type": "uint8"
                        },
                        {
                            "name": "totalDonatedSum",
                            "type": "uint32"
                        },
                        {
                            "name": "campaignEnded",
                            "type": "bool"
                        }
                    ],
                    "payable": false,
                    "stateMutability": "view",
                    "type": "function"
                },
                {
                    "constant": true,
                    "inputs": [
                        {
                            "name": "",
                            "type": "uint256"
                        }
                    ],
                    "name": "donations",
                    "outputs": [
                        {
                            "name": "donationCreator",
                            "type": "address"
                        },
                        {
                            "name": "donationCreatorId",
                            "type": "uint256"
                        },
                        {
                            "name": "euro_amount",
                            "type": "uint32"
                        },
                        {
                            "name": "campaign_id",
                            "type": "uint256"
                        },
                        {
                            "name": "plan_b",
                            "type": "uint8"
                        },
                        {
                            "name": "backup_campaign_id",
                            "type": "uint256"
                        }
                    ],
                    "payable": false,
                    "stateMutability": "view",
                    "type": "function"
                }
            ];
            this.Contract = eth.contract(abi).at('0xDFD5d5E1D674cE896d8e0d4B7F84246fCF0186C3');


        },
        methods:
            {
                // onDonationSubmitBlk() {
                //     this.Contract.donate(
                //         this.donationId = Date.now(),
                //         this.donationCreatorId,
                //         this.donation.euro_amount,
                //         this.donation.campaign_id,
                //         this.donation.plan_b,
                //         this.backup_campaign_id,
                //         {from: this.myAccount, gas: 3000000},
                //     ).then(() => {
                //         console.log(this.campaignId);
                //     }).catch((err) => {
                //         console.log(err);
                //         console.log(this.backup_campaign_id);
                //     });

                    //
                    // eth.getTransactionCount(this.myAccount).then((nonce) => {
                    //     eth.sendRawTransaction(sign({
                    //         to: '0xce31a19193d4b23f4e9d6163d7247243bAF801c3',
                    //         value: 300000,
                    //         gas: new BN('43092000'),
                    //         // when sending a raw transactions it's necessary to set the gas price, currently 0.00000002 ETH
                    //         gasPrice: new BN('20000000000'),
                    //         nonce: nonce,
                    //     }, privateKey)).then((txHash) => {
                    //         console.log('Transaction Hash', txHash);
                    //     });
                    // });
                    //
                    // var web3 = new Web3(new Web3.providers.HttpProvider(
                    //     "https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e"));
                    const eth = new Eth(new Eth.HttpProvider('https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e'));
                    this.Contract = eth.contract(abi).at('0xDFD5d5E1D674cE896d8e0d4B7F84246fCF0186C3');
                    const EthereumTx = require('ethereumjs-tx').Transaction;
                    const privateKey = Buffer.from(
                        'e77116facd6eb001b07655cb4cd2e6c13699788679faa4231a6b12da4724f741',
                        'hex',
                    );
                    const abi = [
                        {
                            "constant": false,
                            "inputs": [
                                {
                                    "name": "_campaignId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_donationId",
                                    "type": "uint256"
                                }
                            ],
                            "name": "closeCampaign",
                            "outputs": [],
                            "payable": false,
                            "stateMutability": "nonpayable",
                            "type": "function"
                        },
                        {
                            "constant": false,
                            "inputs": [
                                {
                                    "name": "_campaignId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_campaignCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_campaignTitle",
                                    "type": "string"
                                },
                                {
                                    "name": "_campaignDuration",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_campaignStartTime",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_category_id",
                                    "type": "uint8"
                                },
                                {
                                    "name": "_euro_goal",
                                    "type": "uint32"
                                },
                                {
                                    "name": "_overhead",
                                    "type": "uint8"
                                }
                            ],
                            "name": "createCampaign",
                            "outputs": [],
                            "payable": false,
                            "stateMutability": "nonpayable",
                            "type": "function"
                        },
                        {
                            "constant": false,
                            "inputs": [
                                {
                                    "name": "_donationId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_donationCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_euro_amount",
                                    "type": "uint32"
                                },
                                {
                                    "name": "_campaignId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "_plan_b",
                                    "type": "uint8"
                                },
                                {
                                    "name": "_backup_campaign_id",
                                    "type": "uint256"
                                }
                            ],
                            "name": "donate",
                            "outputs": [],
                            "payable": false,
                            "stateMutability": "nonpayable",
                            "type": "function"
                        },
                        {
                            "anonymous": false,
                            "inputs": [
                                {
                                    "indexed": false,
                                    "name": "campaignId",
                                    "type": "uint256"
                                },
                                {
                                    "indexed": false,
                                    "name": "campaignCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "indexed": false,
                                    "name": "campaignTitle",
                                    "type": "string"
                                },
                                {
                                    "indexed": false,
                                    "name": "overhead",
                                    "type": "uint8"
                                },
                                {
                                    "indexed": false,
                                    "name": "euro_goal",
                                    "type": "uint32"
                                },
                                {
                                    "indexed": false,
                                    "name": "totalDonatedSum",
                                    "type": "uint32"
                                },
                                {
                                    "indexed": false,
                                    "name": "category_id",
                                    "type": "uint8"
                                }
                            ],
                            "name": "CampaignResultEvent",
                            "type": "event"
                        },
                        {
                            "anonymous": false,
                            "inputs": [
                                {
                                    "indexed": false,
                                    "name": "donationId",
                                    "type": "uint256"
                                },
                                {
                                    "indexed": false,
                                    "name": "donationCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "indexed": false,
                                    "name": "euro_amount",
                                    "type": "uint32"
                                },
                                {
                                    "indexed": false,
                                    "name": "campaign_id",
                                    "type": "uint256"
                                },
                                {
                                    "indexed": false,
                                    "name": "plan_b",
                                    "type": "uint8"
                                },
                                {
                                    "indexed": false,
                                    "name": "backup_campaign_id",
                                    "type": "uint256"
                                }
                            ],
                            "name": "DonationnResultEvent",
                            "type": "event"
                        },
                        {
                            "constant": true,
                            "inputs": [
                                {
                                    "name": "",
                                    "type": "uint256"
                                }
                            ],
                            "name": "campaigns",
                            "outputs": [
                                {
                                    "name": "campaignCreator",
                                    "type": "address"
                                },
                                {
                                    "name": "campaignCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "campaignTitle",
                                    "type": "string"
                                },
                                {
                                    "name": "category_id",
                                    "type": "uint8"
                                },
                                {
                                    "name": "euro_goal",
                                    "type": "uint32"
                                },
                                {
                                    "name": "campaignStartTime",
                                    "type": "uint256"
                                },
                                {
                                    "name": "campaignDuration",
                                    "type": "uint256"
                                },
                                {
                                    "name": "overhead",
                                    "type": "uint8"
                                },
                                {
                                    "name": "totalDonatedSum",
                                    "type": "uint32"
                                },
                                {
                                    "name": "campaignEnded",
                                    "type": "bool"
                                }
                            ],
                            "payable": false,
                            "stateMutability": "view",
                            "type": "function"
                        },
                        {
                            "constant": true,
                            "inputs": [
                                {
                                    "name": "",
                                    "type": "uint256"
                                }
                            ],
                            "name": "donations",
                            "outputs": [
                                {
                                    "name": "donationCreator",
                                    "type": "address"
                                },
                                {
                                    "name": "donationCreatorId",
                                    "type": "uint256"
                                },
                                {
                                    "name": "euro_amount",
                                    "type": "uint32"
                                },
                                {
                                    "name": "campaign_id",
                                    "type": "uint256"
                                },
                                {
                                    "name": "plan_b",
                                    "type": "uint8"
                                },
                                {
                                    "name": "backup_campaign_id",
                                    "type": "uint256"
                                }
                            ],
                            "payable": false,
                            "stateMutability": "view",
                            "type": "function"
                        }
                    ];

                    web3.eth.getTransactionCount(this.myAccount, function (err, nonce) {
                        var data = this.Contract.donate.increment.getData(
                            this.donationId = Date.now(),
                            this.donationCreatorId,
                            this.donation.euro_amount,
                            this.donation.campaign_id,
                            this.donation.plan_b,
                            this.backup_campaign_id,
                            {from: this.myAccount, gas: 3000000},
                        ).then(() => {
                            console.log(this.campaignId);

                            var tx = new ethereumjs.Tx({
                                nonce: nonce,
                                gasPrice: web3.toHex(web3.toWei('20', 'gwei')),
                                gasLimit: 100000,
                                to: this.myAccount,
                                value: 0,
                                data: data,
                            });
                            tx.sign(ethereumjs.Buffer.Buffer.from(privateKey, 'hex'));

                            var raw = '0x' + tx.serialize().toString('hex');
                            web3.eth.sendRawTransaction(raw, function (err, transactionHash) {
                                console.log(transactionHash);
                            });
                        }).catch((err) => {
                            console.log(err);
                        });


                    });

                },
                showDrawer() {
                    this.visible = true;
                }
                ,
                onClose() {
                    this.visible = false;
                }
                ,
                toPickAmount(num) {
                    this.button = "€" + num;
                    this.donation.euro_amount = num;
                    this.error.euro_amount = "";
                }
                ,
                toPickBackup(id) {
                    this.donation.backup_campaign_id = id;
                    this.error.plan_b = "";
                    this.backup_campaign_id = id;
                }
                ,
                onChange(e) {
                    console.log('radio checked', e.target.value);
                }
                ,
                toDonate() {

                    if (this.donation.euro_amount === "") {
                        // this.error.euro_amount = "Neophodno je izabrati veličinu donacije."
                        this.error.euro_amount = "It is mandatory to choose a donation amount."
                    } else {
                        this.error.euro_amount = "";
                    }

                    if (this.donation.plan_b === 2) {
                        if (this.donation.backup_campaign_id === "") {
                            // this.error.plan_b = "Neophodno je izabrati rezervnu kampanju, ako ste izabrali opciju 2."
                            this.error.plan_b = "It is mandatory to choose another campaign, if You chose option 2."
                        } else {
                            this.error.plan_b = "";
                        }
                    } else {
                        this.error.plan_b = "";
                    }

                    if (this.error.euro_amount === "" && this.error.plan_b === "") {

                        this.visible = false;
                        axios.post('/api/donations', this.donation)
                            .then((response) => {
                                // document.getElementById("donation-form").reset();
                                // window.location.reload();
                            })
                    }


                },
            },
    };
</script>