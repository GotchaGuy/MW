<template>
    <div class="container">
        <div class="row">
            <a-form :form="form" @submit="handleSubmit" id="campaign-form" enctype="multipart/form-data">
                <!--                :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }"-->
                <!--                <a-row :gutter="24">-->
                <div class="row">
                    <!--                    <a-col :span="10">-->
                    <div class="col-3">
                        <!--                        <a-row :gutter="10">-->
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Campaign Name</h5>
                                <a-input
                                        v-decorator="['title',
                                 { rules: [{ required: true, message: 'The campaign name is mandatory.' }] }]"
                                        v-model="campaign.title"
                                />
                            </div>
                        </div>
                        <!--                        -->
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Campaign duration</h5>
                                <a-range-picker @change="onDateChange"
                                                v-decorator="['time',
                                 { rules: [{ required: true, message: 'Picking the campaign duration is mandatory.' }] }]"/>
                            </div>
                        </div>
                        <!--                    -->
                        <div class="row">
                            <div class="col">
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
                            <div class="col">
                                <h5 class="card-title">Overhead</h5>
                                <a-input-number
                                        aria-describedby="overhead"
                                        :default-value="0"
                                        :min="0"
                                        :max="100"
                                        placeholder="%"
                                        v-model="campaign.overhead"
                                        v-decorator="['overhead',
                                 { rules: [{ required: true, message: 'Choosing the overhead percent is mandatory.' }] }]"
                                />
                            </div>
                        </div>

                    </div>


                    <div class="col-5">
                        <!--                        <div class="col">-->
                        <h5 class="card-title">Campaign Description</h5>
                        <a-textarea placeholder="Opis kampanje" :rows="8" v-model="campaign.description"
                                    v-decorator="['desc',
                                 { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                        <!--                        </div>-->
                    </div>


                    <div class="col-3">
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

                <!--                <a-form-item :wrapper-col="{ span: 12, offset: 5 }">-->
                <div class="row">
                    <div class="col-1 offset-11">
                        <a-button type="success" html-type="submit" class="submit">
                           <i class="el-icon-check"></i>
                        </a-button>
                    </div>
                </div>

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
                    // image: "https://source.unsplash.com/random/400x400",
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
                headers: {'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content}
            }
        },
        mounted() {
            axios.get('/api/categories')
                .then((response) => {
                    this.categories = response.data;
                    console.log(this.categories);
                })
        }
        ,
        methods: {
            onDateChange(date, dateString) {
                this.campaign.start = dateString[0];
                this.campaign.end = dateString[1];
            },
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log('Received values of form: ', values);
                        console.log(this.campaign);
                        axios.post('/api/new-campaign', this.campaign)
                            .then((response) => {
                                document.getElementById("campaign-form").reset();
                                window.location.href = '/home';
                            })
                    }
                });
            },
            submitCampaign() {

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