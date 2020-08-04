<template>
    <!--    <div>-->
    <div class="container">
        <div class="org-account" v-if="user.role_id === 2">
            <div class="row">
                <div class="col-4">
                    <div class="img mx-auto">
                        <!--                        <img :src="organization.org_logo" alt="">-->
                        <form enctype="multipart/form-data">
                            <el-upload
                                    class="avatar-uploader"
                                    ref="upload"
                                    action="/api/image/upload/logo"
                                    :auto-upload="false"
                                    :show-file-list="false"
                                    :on-change="handleAvatarChange"
                                    :headers="headers"
                                    :before-upload="beforeAvatarUpload">
                                <div v-loading="loading">
                                    <img :src="thumbnail" class="avatar">
<!--                                    v-if="thumbnail"-->
<!--                                    <i v-else class="el-icon-receiving avatar-uploader-icon"></i>-->
                                </div>
                            </el-upload>
                            <el-dialog :visible.sync="dialogVisible">
                                <Cropper
                                        classname="upload-example-cropper"
                                        :src="imageUrl"
                                        @change="onChange"
                                        :stencil-props="{ movable: true, scalable: true, aspectRatio: 1,}"
                                />
                                <el-button type="primary" @click="applyChanges">Apply</el-button>
                            </el-dialog>
                            <a-button type="primary" @click="updateImage(organization.id)" class="update">
                                <i class="el-icon-upload2"></i>
                            </a-button>
                        </form>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="text-muted">Charity organization:</h6>
                            <h2>{{organization.title}}</h2>
                            <h6 class="text-muted">Location:</h6>
                            <h4>{{organization.location}}</h4>
                            <h6 class="text-muted">Platform representative:</h6>
                            <h4>{{organization.user.name}}</h4>
                        </div>
                        <div class="col-5">
                            <h6 class="text-muted">What we do:</h6>
                            <h4>{{organization.field_of_work}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <h5>Our Campaigns</h5>
            <div class="row">
                <!--            the + button-->
                <div class="col-4 campaign">
                    <div class="card mb-3 new mx-auto">
                        <a href="/new-campaign">
                            <el-button type="success" icon="el-icon-plus" plain></el-button>
                        </a>
                    </div>
                </div>

                <div class="col-4 campaign" v-for="campaign in organization.campaigns">
                    <div class="card mb-3">
                        <a :href="'/campaign/' + campaign.id">
                            <div class="row no-gutters">
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h6 class="çard-text">{{campaign.time_left}}</h6>
                                        <h6 class="card-title">{{campaign.category.title}}</h6>
                                        <h3 class="card-title">{{campaign.title}}</h3>
                                        <div class="graph">
                                            <p class="card-text">
                                                <small class="text-muted">Raised: €{{campaign.raised}}</small>
                                            </p>
                                            <el-progress
                                                    :text-inside="true"
                                                    :stroke-width="20"
                                                    :percentage="campaign.percent"
                                                    status="success"></el-progress>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <img :src="campaign.image + '?w=140&h=235&fit=crop-center'" class="card-img"
                                         alt="...">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    </div>-->
</template>


<script>
    import ACol from "ant-design-vue/es/grid/Col";
    import {Cropper} from 'vue-advanced-cropper'

    export default {
        components: {ACol, Cropper},
        data() {
            return {
                organization: "",
                user: "",
                //
                dialogVisible: false,
                disabled: false,
                imageUrl: '',
                loading: false,
                thumbnail: "", // this is the one
                imageName: '',
                modifiedImageUrl: '',
                headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                //
                new: {
                    org_logo: "",
                }
            }
        },
        mounted() {
            axios.get('/api/my-organization')
                .then((response) => {
                    this.organization = response.data;
                    console.log(this.organization);
                    this.thumbnail = this.organization.org_logo;
                });
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    console.log(this.user);
                });

        },
        methods: {
            //
            // handleSubmit(e) {
            //     e.preventDefault();
            //     this.form.validateFields((err, values) => {
            //         if (!err) {
            //             console.log(values);
            //             axios.put('/api//image/upload/logo/' + $id, this.thumbnail, $id)
            //                 .then((response) => {
            //                     // document.getElementById("post-form").reset();
            //                     window.location.href = '/me';
            //                 })
            //         }
            //     });
            // },
            updateImage($id) {
                axios.put('/api/image/upload/logo/' + $id, this.new, $id)
                            .then((response) => {
                                // document.getElementById("post-form").reset();
                                window.location.href = '/me';
                            })
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
                    this.new.org_logo = this.thumbnail;
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