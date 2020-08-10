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
                                    <!--                                    style="width: 300px"-->
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

                <a-button type="primary" @click="toDonate">
                    Donate {{this.button}}
                </a-button>
            </div>
        </a-drawer>
    </div>
</template>


<script>
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
                donationCreator: '',
                campaignId: '',
                euro_amount: '',
                plan_b: 1,
                backup_campaign_id: '',
            };
        },
        mounted() {
            this.donation.campaign_id = this.campaignid;
            axios.get('/api/campaigns')
                .then((response) => {
                    this.campaigns = response.data;
                    console.log(this.campaigns);
                });
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
                        },
                        {
                            "name": "_totalDonatedSum",
                            "type": "uint32"
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

        },
        methods:
            {
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
                                document.getElementById("donation-form").reset();
                                window.location.reload();
                            })
                    }


                },
            },
    };
</script>