<template>
    <div>
        <el-button type="success" icon="el-icon-share" size="large" plain/>
        <el-button type="success" @click="showDrawer" class="sharp-left">
            Doniraj
        </el-button>
        <a-drawer
                title="Koliko želite da donirate?"
                :width="720"
                :visible="visible"
                :body-style="{ paddingBottom: '80px' }"
                @close="onClose"
        >
            <a-form :form="form" layout="horizontal" hide-required-mark id="donation-form">
                <div class="row">
                    <div class="col-12">
                        <h6>Donacija</h6>
                        <!--                        <label for="donacija">Donacija</label>-->
                        <el-button type="success" id="donacija" plain @click="toPickAmount(10)">€10</el-button>
                        <el-button type="success" plain @click="toPickAmount(20)">€20</el-button>
                        <el-button type="success" plain @click="toPickAmount(30)">€30</el-button>
                        <el-button type="success" plain @click="toPickAmount(50)">€50</el-button>
                        <el-button type="success" plain @click="toPickAmount(100)">€100</el-button>
                        <el-button type="success" plain @click="toPickAmount(500)">€500</el-button>
                        <a-input-number size="large" :min="1" :max="100000" @change="toPickAmount"/>
                        <h6 class="error">{{this.error.euro_amount}}</h6>
                    </div>
                    <div class="col-12 donate-radio">
                        <h6>U slučaju nepostignutog cilja kampanje u dogovorenom roku,</h6>
                        <a-radio-group v-model="donation.plan_b" name="radio" id="radio" @change="onChange">
                            <a-radio :style="radioStyle" :value="1" selected>
                                <p>želim da organizacija zadrži moju donaciju.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="2">
                                <p>želim da moja donacija bude prosleđena drugoj kampanji po mom biranju.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="3">
                                <p>želim povraćaj novca.</p>
                            </a-radio>
                        </a-radio-group>
                        <h6 class="error">{{this.error.plan_b}}</h6>
                    </div>

                    <div v-if="donation.plan_b == 2" class="if">
                        <h6>Izaberite kampanju kojoj biste preusmerili donaciju:</h6>
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
                                    <small class="text-muted">{{campaign.category.title}}</small>
                                    <h6 class="card-title">Raised: €{{campaign.raised}} | {{campaign.percent}}%</h6>
                                    <template slot="actions" class="ant-card-actions">
                                        <button type="button" icon="plus" class="btn btn-outline-success"
                                                @click="toPickBackup(campaign.id)">Izaberi
                                        </button>
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
                    Otkaži
                </a-button>

                <a-button type="primary" @click="toDonate">
                    Doniraj {{this.button}}
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
            };
        },
        mounted() {
            this.donation.campaign_id = this.campaignid;
            axios.get('/api/campaigns')
                .then((response) => {
                    this.campaigns = response.data;
                    console.log(this.campaigns);
                });


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
                    // this.button = "€" + num;
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
                        this.error.euro_amount = "Neophodno je izabrati veličinu donacije."
                    } else {
                        this.error.euro_amount = "";
                    }

                    if (this.donation.plan_b === 2) {
                        if (this.donation.backup_campaign_id === "") {
                            this.error.plan_b = "Neophodno je izabrati rezervnu kampanju, ako ste izabrali opciju 2."
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