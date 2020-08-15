<template>
    <div class="container">
        <div class="row">
            <a-form :form="form" @submit="handleSubmit" id="campaign-form" enctype="multipart/form-data">
                <!--                :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }"-->
                <!--                <a-row :gutter="24">-->
                <div class="row">
                    <!--                    <a-col :span="10">-->
                    <div class="col-6">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Campaign Name</h5>
                                <a-input
                                        v-decorator="['title',
                                 { rules: [{ required: true, message: 'The campaign name is mandatory.' }] }]"
                                        v-model="campaign.title"
                                />
                            </div>
                            <!--                                        v-model="campaignTitle"-->
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Campaign Category</h5>
                                <a-select v-decorator="['category',
          { rules: [{ required: true, message: 'Picking a category the campaign belongs to is mandatory.' }] },]"
                                          v-model="campaign.category_id">
                                    <a-select-option v-for="(category, index) in categories" :value="category.id"
                                                     v-bind:key="index">
                                        {{category.title}}
                                    </a-select-option>
                                </a-select>
                                <!--                                          v-model="category_id">-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Campaign duration</h5>
                                <a-range-picker @change="onDateChange"
                                                v-decorator="['time',
                                 { rules: [{ required: true, message: 'Picking the campaign duration is mandatory.' }] }]"/>
                            </div>

                            <div class="col-3">
                                <h5 class="card-title">Goal</h5>
                                <a-input-number
                                        :min="1000" :max="1000001"
                                        prefix="€"
                                        placeholder="€"
                                        :default-value="1000"
                                        v-model="campaign.euro_goal"
                                        v-decorator="['goal',
                                 { rules: [{ required: true, message: 'The campaign goal is mandatory.' }] }]"
                                />
                            </div>
                            <!--                                        v-model="euro_goal"-->
                            <div class="col-3">
                                <h5 class="card-title">Overhead</h5>
                                <a-input-number
                                        :min="0" :max="100"
                                        placeholder="%"
                                        :default-value="0"
                                        v-model="campaign.overhead"
                                        v-decorator="['overhead',
                                 { rules: [{ required: true, message: 'Choosing the overhead percent is mandatory.' }] }]"
                                />
                            </div>
                            <!--                                        v-model="overhead"-->
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Thumbnail Upload</h5>
                                <el-upload
                                        class="avatar-uploader"
                                        ref="upload"
                                        action="/api/image/upload/camp"
                                        :auto-upload="false"
                                        :show-file-list="false"
                                        :on-change="handleAvatarChange"
                                        :headers="headers"
                                        :before-upload="beforeAvatarUpload">
                                    <div v-loading="loading">
                                        <img v-if="thumbnail" :src="thumbnail" class="avatar">
                                        <i v-else class="el-icon-receiving avatar-uploader-icon"></i>
                                    </div>
                                </el-upload>
                                <el-dialog :visible.sync="dialogVisible">
                                    <Cropper
                                            classname="upload-example-cropper"
                                            :src="imageUrl"
                                            @change="onChange"
                                            :stencil-props="{ movable: true, scalable: true, aspectRatio: 1.5,}"
                                    />
                                    <el-button type="primary" @click="applyChanges">Apply</el-button>
                                </el-dialog>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="card-title">Campaign Description</h5>
                        <a-textarea placeholder="Opis kampanje"
                                    :rows="8"
                                    v-model="campaign.description"
                                    v-decorator="['desc',
                                 { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1 offset-11">
                        <a-button type="success" html-type="submit" class="submit" @click="onCampaignSubmitBlk">
                            <i class="el-icon-check"></i>
                        </a-button>
                    </div>
                </div>
            </a-form>
        </div>
    </div>
</template>


<script>
    const Eth = require('ethjs');
    import ACol from "ant-design-vue/es/grid/Col";
    import {Cropper} from 'vue-advanced-cropper'

    export default {
        components: {ACol, Cropper},
        data() {
            return {
                user: "",
                formLayout: 'horizontal',
                form: this.$form.createForm(this, {name: 'coordinated'}),
                categories: {},
                campaign: {
                    title: "",
                    euro_goal: "",
                    start: "",
                    end: "",
                    overhead: "",
                    image: "",
                    description: "",
                    user_id: "",
                    category_id: ""
                },
                dialogVisible: false,
                disabled: false,
                imageUrl: '',
                loading: false,
                thumbnail: '',
                imageName: '',
                modifiedImageUrl: '',
                headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                //
                output: '',
                campaignCreator: '0x80ca7985360c43545C8E1e1a1a4dcEe9641Ecd7b',
                campaignCreatorId: '',
                campaignTitle: '',
                category_id: '',
                euro_goal: '',
                campaignStartTime: '',
                campaignDuration: '',
                overhead: '',
                // totalDonatedSum: '',
                //percent ?
                //
                myAccount: '0xdbC4D7B4Ac635845ca1D4C0E779150E4b494A413',
                Contract: '',
            }
        },
        mounted() {
            // const eth = new Eth(new Eth.HttpProvider('http://localhost:7545'));
             const eth = new Eth(new Eth.HttpProvider('https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e'));
            // if (typeof window.web3 !== 'undefined'
            // && typeof window.web3.currentProvider !== 'undefined') {
            //   eth.setProvider(window.web3.currentProvider);
            // } else {
            //   eth.setProvider(new Eth.HttpProvider('https://rinkeby.infura.io/v3/87502bcbdab4494289d7f0cc3d62329e')); // set to TestRPC if not available
            // }
            axios.get('/api/categories')
                .then((response) => {
                    this.categories = response.data;
                    console.log(this.categories);
                });
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    this.campaignCreatorId = this.user.id;
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
            // eth.accounts().then((accounts) => {
            //     // eslint-disable-next-line prefer-destructuring
            //     this.myAccount = accounts[0];
            // });
            this.Contract = eth.contract(abi).at('0xDFD5d5E1D674cE896d8e0d4B7F84246fCF0186C3');
        },
        methods: {
            onCampaignSubmitBlk() {
// uint256 _campaignId, _campaignCreatorId, string _campaignTitle, uint256 _campaignDuration, uint256 _campaignStartTime, uint8 _category_id, uint32 _euro_goal, uint8 _overhead
                this.Contract.createCampaign(
                    this.campaignId = Date.now(),
                    this.campaignCreatorId,
                    this.campaignTitle = this.campaign.title,
                    this.campaignDuration,
                    this.campaignStartTime = moment(this.campaignStartTime).valueOf(),
                    this.category_id = this.campaign.category_id,
                    this.euro_goal = this.campaign.euro_goal,
                    this.overhead = this.campaign.overhead,
                    {from: this.myAccount, gas: 3000000},
                ).then(() => {
                    console.log(this.campaignId);
                }).catch((err) => {
                    console.log(err);
                });
            },
            onDateChange(date, dateString) {
                this.campaign.start = dateString[0];
                this.campaign.end = dateString[1];
                //
                this.campaignStartTime = date[0];
                // console.log(this.campaignStartTime);
                this.campaignDuration = date[1] - date[0];
                // console.log(this.campaignDuration);
                // this.campaignStartTime = moment(this.campaignStartTime).valueOf();
                // console.log(this.campaignStartTime);
            },
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log('Received values of form: ', values);
                        console.log(this.campaign);
                        axios.post('/api/new-campaign', this.campaign)
                            .then((response) => {
                                console.log(this.campaign);
                                document.getElementById("campaign-form").reset();
                                // window.location.href = '/home';
                            })
                    }
                });
            },
            applyChanges() {
                this.loading = true;
                this.dialogVisible = false;
                this.imageUrl = this.modifiedImageUrl;
                // generate file from base64 string
                const file = this.dataURLtoFile(this.imageUrl);
                // put file into form data
                const data = new FormData();
                data.append('file', file, this.imageName);
                const config = {
                    headers: {'Content-Type': 'multipart/form-data'}
                };
                axios.post('/api/image/upload/camp', data, config).then(response => {
                    this.loading = false;
                    this.thumbnail = '/storage/' + response.data.name;
                    this.campaign.image = this.thumbnail;
                    this.$emit('input', response.data.name)
                })
            },
            onChange({coordinates, canvas}) {
                this.coordinates = coordinates;
                // You able to do different manipulations at a canvas
                // but there we just get a cropped image
                this.modifiedImageUrl = canvas.toDataURL();
            },
            handleAvatarChange(file) {
                this.imageUrl = URL.createObjectURL(file.raw);
                this.imageName = file.name;
                console.log(this.imageUrl);
                this.$nextTick(() => {
                    this.dialogVisible = true;
                })
            },
            handleAvatarSuccess(res, file) {
                //this.ruleForm.photo_url = URL.createObjectURL(file.raw);
                //this.ruleForm.photo_url = '/storage/' + res.name;
            },
            base64ToBlob(dataurl) {
                const arr = dataurl.split(',');
                const mime = arr[0].match(/:(.*?);/)[1]
                const sliceSize = 1024;
                const byteChars = window.atob(arr[1]);
                const byteArrays = [];
                for (let offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
                    let slice = byteChars.slice(offset, offset + sliceSize);
                    const byteNumbers = new Array(slice.length);
                    for (let i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    byteArrays.push(byteArray);
                }
                return new Blob(byteArrays, {type: mime});
            },
            getFilename(dataUrl) {
                const arr = dataUrl.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                return Math.round(+new Date() / 1000) + '.' + mime.split('/').pop();
            },
            dataURLtoFile(dataUrl) {
                const blob = this.base64ToBlob(dataUrl);
                blob.name = this.getFilename(dataUrl);
                // generate file from base64 string
                return blob;
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 8;
                // const isLt2M = file.size / 610 / 1024 < 8;
                if (!isJPG && !isPNG) {
                    this.$message.error(this.__('Picture must be JPG or PNG format!'));
                }
                if (!isLt2M) {
                    this.$message.error(this.__('Picture size can not exceed 8MB!'));
                }
                return isJPG && isLt2M;
            },
        }

    }
</script>