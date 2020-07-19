<template>
    <div class="container">
        <div class="row justify-content-center">
            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    enctype="multipart/form-data" id="post-form">
                <!--        class="justify-content-center"        -->
                <!--                <a-progress type="circle" :percent="this.secondary.percent" :width="80"/>-->
                <div class="row justify-content-center">
                    <h5>€{{this.secondary.raised}} / €{{this.secondary.euro_goal}}</h5>
                    <div class="col-12">
                    <a-progress :percent="this.secondary.percent"/>
                    </div>
                </div>
                <div class="col-md-6 mb-3 post mx-auto">
                    <div class="card hvr-underline-from-left md-4">
                        <div class="card-header row">
                            <div class="col">
                                <!--                                        <h5>Odabir kampanje</h5>-->
                                <a-select
                                        v-decorator="['campaign', { rules: [{ required: true, message: 'Biranje kampanje kojoj post pripada je obavezno.' }] },]"
                                        placeholder="Odabir kampanje"
                                        v-model="post.campaign_id"
                                        @change="react()">
                                    <a-select-option v-for="(campaign, index) in organization.campaigns"
                                                     :value="campaign.id" v-bind:key="index">
                                        {{campaign.title}}
                                    </a-select-option>
                                </a-select>
                                <h6><strong>{{this.secondary.time_left}}</strong></h6>
                            </div>

                            <div class="col text-right">

                            </div>
                        </div>
                        <div class="box">
                            <!--                                <img :src="post.image" alt="notesImage" class="card-img-top">-->
                            <a-upload-dragger
                                    name="file"
                                    :multiple="false"
                                    action="/api/image/upload/post"
                                    @change="handleChange">
                                <img v-if="post.image" :src="post.image" class="">
                                <div v-else>
                                    <p class="ant-upload-drag-icon">
                                        <a-icon type="inbox"/>
                                    </p>
                                    <p class="ant-upload-text">
                                        Click or drag file to this area to upload
                                    </p>
                                </div>
                            </a-upload-dragger>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <!--                                    <h5>Naziv posta</h5>-->
                                    <a-input placeholder="Dragi donatori.." v-model="post.title"/>
                                    <!--                                    </a-form-item>-->
                                </div>
                                <div class="col-6 text-right">{{post.timestamp}}</div>
                            </div>
                            <div class="card-text">
                                <!--                                <h5>Opis kampanje</h5>-->
                                <a-textarea placeholder="O čemu želite da obavestite donatore?" :rows="4"
                                            v-model="post.body"
                                            v-decorator="['time', { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>

                            </div>
                        </div>
                    </div>
                </div>
                <!--                <a-form-item :wrapper-col="{ span: 12, offset: 5 }" class="justify-content-center">-->
                <div class="row justify-content-end submit">
                    <a-button type="primary" html-type="submit">
                        Pošalji
                    </a-button>
                </div>
                <!--                </a-form-item>-->

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
                        console.log(this.secondary);
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
            handleChange(info) {
                const status = info.file.status;
                if (status !== 'uploading') {
                    console.log(info.file, info.fileList);
                }
                if (status === 'done') {
                    this.post.image = "/storage/" + info.file.name;
                    this.$message.success(`${info.file.name} file uploaded successfully.`);
                } else if (status === 'error') {
                    this.$message.error(`${info.file.name} file upload failed.`);
                }
            },
        }

    }
</script>