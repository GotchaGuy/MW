<template>
    <div class="container">
        <div class="row justify-content-center">
            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    id="post-form" >
                <!--        class="justify-content-center"        -->

                <div class="col-md-6 mb-3 post mx-auto">
                        <div class="card hvr-underline-from-left md-4">
                            <div class="card-header row">
                                <div class="fave"></div>
                                <div class="col">
                                    <h5><strong>
                                        <a-form-item>
                                            <h5>Odabir kampanje</h5>
                                            <a-select
                                                    v-decorator="['campaign', { rules: [{ required: true, message: 'Biranje kampanje kojoj post pripada je obavezno.' }] },]"
                                                    placeholder="Vaše kampanje"
                                                    v-model="post.campaign_id"
                                                    @change="react()">
                                                <a-select-option v-for="(campaign, index) in organization.campaigns"
                                                                 :value="campaign.id"
                                                                 v-bind:key="index">
                                                    {{campaign.title}}
                                                </a-select-option>
                                            </a-select>
                                        </a-form-item>
                                    </strong></h5>
                                    <h6><strong>{{this.secondary.time_left}}</strong></h6>
                                </div>
                                <div class="col text-right">
                                    <a-progress type="circle" :percent="this.secondary.percent" :width="80"/>
                                </div>
                            </div>
                            <div class="box">
                                <img :src="post.image" alt="notesImage" class="card-img-top">
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a-form-item>
                                            <h5>Naziv posta</h5>
                                            <a-input placeholder="Dragi donatori.." v-model="post.title"/>
                                        </a-form-item>
                                    </div>
                                    <div class="col-6 text-right">{{post.timestamp}}</div>
                                </div>
                                <div class="card-text">
                                    <a-form-item>
                                        <h5>Opis kampanje</h5>
                                        <a-textarea placeholder="O čemu želite da obavestite donatore?" :rows="4"
                                                    v-model="post.body"
                                                    v-decorator="['time', { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                                    </a-form-item>
                                </div>
                            </div>
                        </div>
                </div>
                <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                    <a-button type="primary" html-type="submit">
                        Pošalji
                    </a-button>
                </a-form-item>

                <!--                -->
                <!--                <a-row :gutter="24">-->
                <!--                    <a-col :span="10">-->
                <!--                        <a-form-item label="Naziv posta">-->
                <!--                            <a-input placeholder="Dragi donatori.." v-model="post.title"/>-->
                <!--                        </a-form-item>-->
                <!--                    </a-col>-->

                <!--                    <a-col :span="14">-->
                <!--                        <a-form-item label="Odabir kampanje">-->
                <!--                            <a-select-->
                <!--                                    v-decorator="['campaign', { rules: [{ required: true, message: 'Biranje kampanje kojoj post pripada je obavezno.' }] },]"-->
                <!--                                    placeholder="Vaše kampanje"-->
                <!--                                    v-model="post.campaign_id">-->
                <!--                                <a-select-option v-for="(campaign, index) in organization.campaigns"-->
                <!--                                                 :value="campaign.id"-->
                <!--                                                 v-bind:key="index">-->
                <!--                                    {{campaign.title}}-->
                <!--                                </a-select-option>-->
                <!--                            </a-select>-->
                <!--                        </a-form-item>-->
                <!--                    </a-col>-->
                <!--                </a-row>-->

                <!--                <a-row :gutter="20">-->
                <!--                    <a-col :span="10">-->
                <!--                        <a-form-item label="Opis kampanje">-->
                <!--                            <a-textarea placeholder="O čemu želite da obavestite donatore?" :rows="4"-->
                <!--                                        v-model="post.body"-->
                <!--                                        v-decorator="['time', { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>-->
                <!--                        </a-form-item>-->
                <!--                    </a-col>-->
                <!--                </a-row>-->

                <!--                <a-row :gutter="20">-->
                <!--                    <a-col :span="10">-->
                <!--                        <a-form-item :wrapper-col="{ span: 12, offset: 5 }">-->
                <!--                            <a-button type="primary" html-type="submit">-->
                <!--                                Pošalji-->
                <!--                            </a-button>-->
                <!--                        </a-form-item>-->
                <!--                    </a-col>-->
                <!--                </a-row>-->
            </a-form>
        </div>
    </div>
</template>


<script>
    export default {
        // props: ["dataOrg"],
        data() {
            return {
                // organization: JSON.parse(this.dataOrg),
                organization: {},
                formLayout: 'horizontal',
                form: this.$form.createForm(this, {name: 'coordinated'}),
                post: {
                    title: "",
                    body: "",
                    image: "",
                    campaign_id: ""
                },
                secondary: {},
            }
        },
        mounted() {
            axios.get('/api/organization')
                .then((response) => {
                    this.organization = response.data;
                    console.log(this.organization);
                });
        },
        methods: {
            react() {
                for (let i = 0; i < this.organization.length; i++) {
                    if (this.organization.campaigns[i].id === this.post.campaign_id) {
                        this.secondary = this.organization.campaigns[i];
                    }
                }
            },
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log(values);
                        axios.post('/api/new-post', this.post)
                            .then((response) => {
                                document.getElementById("post-form").reset();
                                window.location.href = '/feed';
                            })
                    }
                });
            },
        }

    }
</script>