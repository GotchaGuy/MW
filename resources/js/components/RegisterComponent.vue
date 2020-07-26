<template>
    <!--    <div class="back">-->
    <div class="container register">
        <!--        <div class="row">-->
        <form id="register-form" enctype="multipart/form-data">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" @click="chooseRole(1)" name="options" id="option1"
                           autocomplete="off" checked> Donor
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" @click="chooseRole(2)" name="options" id="option2"
                           autocomplete="off"> Organization
                </label>
            </div>
            <div class="row justify-content-around register-main">
                <div class="col-6 sec">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                               placeholder="Your full name and last name" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               placeholder="Enter email" v-model="user.email">
                        <!--                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone-->
                        <!--                            else.-->
                        <!--                        </small>-->
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter Password"
                                       v-model="user.password">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirm</label>
                                <input type="password_confirmation" class="form-control" id="password_confirmation"
                                       placeholder="Enter Password Again" v-model="user.password_confirmation">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-6 sec">
                    <div v-if="user.role_id === 2" class="if">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="title">Organization Title</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           placeholder="Enter Full Title" v-model="user.title">
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" id="location" name="location" class="form-control"
                                           placeholder="Enter place of work" v-model="user.location">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="logo">Org Logo</label>
                                <a-upload-dragger
                                        name="file"
                                        :multiple="false"
                                        action="/api/image/upload/logo"
                                        @change="handleChange"
                                        id="logo">
                                    <img v-if="user.org_logo" :src="user.org_logo" class="">
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
                        </div>
                        <div class="form-group">
                            <!--                            <label for="field_of_work">Čime se organizacija bavi u jednoj rečenici:</label>-->
                            <label for="field_of_work">What does the organization do in one sentence:</label>
                            <textarea type="text" id="field_of_work" name="field_of_work" class="form-control"
                                      v-model="user.field_of_work"
                                      placeholder="We do this n that.."></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="button" class="btn btn-success sharp-left" @click="submitForm()">Submit</button>
            </div>
        </form>
        <!--    </div>-->
    </div>
    <!--    </div>-->
</template>


<script>
    export default {
        data() {
            return {
                user: {
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    role_id: 1,
                    //
                    title: "",
                    location: "",
                    field_of_work: "",
                    org_logo: "",
                    // user_id: ""
                },
            }
        },
        mounted() {

        },
        methods: {
            chooseRole(num) {
                this.user.role_id = num;
            },
            handleChange(info) {
                const status = info.file.status;
                if (status !== 'uploading') {
                    console.log(info.file, info.fileList);
                }
                if (status === 'done') {
                    this.user.org_logo = "/storage/" + info.file.name;
                    this.$message.success(`${info.file.name} file uploaded successfully.`);
                } else if (status === 'error') {
                    this.$message.error(`${info.file.name} file upload failed.`);
                }
            },
            submitForm() {
                axios.post('/register', this.user)
                    .then((response) => {
                        window.location.href = '/home';
                    })
            }
        }

    }
</script>