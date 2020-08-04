<template>
    <div class="container">
        <div class="row justify-content-center">
            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    enctype="multipart/form-data" id="post-form">
                <!--        class="justify-content-center"        -->
                <!--                <a-progress type="circle" :percent="this.secondary.percent" :width="80"/>-->
                <div class="row justify-content-center">
                    <h5>€{{this.secondary.raised}} / €{{this.secondary.euro_goal}}</h5>
                    <div class="row">
                        <div class="col-6 offset-3">
                            <a-progress :percent="this.secondary.percent"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3 post mx-auto">
                    <div class="card hvr-underline-from-left md-4">
                        <div class="card-header row">
                            <div class="col-6">
                                <a-select
                                        v-decorator="['campaign', { rules: [{ required: true, message: 'Choosing the campaign the post belongs to is mandatory.' }] },]"
                                        v-model="post.campaign_id">
                                    <a-select-option v-for="(campaign, index) in organization.campaigns"
                                                     @click="react(campaign.raised, campaign.euro_goal, campaign.percent)"
                                                     :value="campaign.id" v-bind:key="index">
                                        {{campaign.title}}
                                    </a-select-option>
                                </a-select>
                                <h6><strong>{{this.secondary.time_left}}</strong></h6>
                            </div>
                        </div>
                        <div class="box justify-content-center">
                            <!--                                <img :src="post.image" alt="notesImage" class="card-img-top">-->
                            <el-upload
                                    class="avatar-uploader"
                                    ref="upload"
                                    action="/api/image/upload/post"
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <!--                                    <h5>Naziv posta</h5>-->
                                    <a-input placeholder="Dear donors.." v-model="post.title"/>
                                    <!--                                    </a-form-item>-->
                                </div>
                                <div class="col-6 text-right">{{post.timestamp}}</div>
                            </div>
                            <div class="card-text">
                                <!--                                <h5>Opis kampanje</h5>-->
                                <a-textarea placeholder="What do you want to update the donors about?" :rows="4"
                                            v-model="post.body"
                                            v-decorator="['time', { rules: [{ required: true, message: 'Writing a description is mandatory.' }] }]"/>

                            </div>
                        </div>
                    </div>
                </div>
                <!--                <a-form-item :wrapper-col="{ span: 12, offset: 5 }" class="justify-content-center">-->
                <div class="row  submit">
                    <div class="col-1 offset-11">
                        <a-button type="primary" html-type="submit">
                            <i class="el-icon-arrow-right"></i>
                        </a-button>
                    </div>
                </div>
                <!--                </a-form-item>-->

            </a-form>
        </div>
    </div>
</template>


<script>
    import ACol from "ant-design-vue/es/grid/Col";
    import {Cropper} from 'vue-advanced-cropper'

    export default {
        components: {ACol, Cropper},
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
                secondary: {
                    raised: "",
                     euro_goal: "",
                },
                //
                dialogVisible: false,
                disabled: false,
                imageUrl: '',
                loading: false,
                thumbnail: '',
                imageName: '',
                modifiedImageUrl: '',
                headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
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
            react(raised, euro_goal, percent) {
                this.secondary.raised = raised;
                this.secondary.euro_goal =  euro_goal;
                this.secondary.percent =  percent;
                    console.log(this.secondary);
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
            //
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
                    this.post.image = this.thumbnail;
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