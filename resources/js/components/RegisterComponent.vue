<template>
    <!--    <div class="back">-->
    <div class="container register">
        <!--        <div class="row">-->
        <form id="register-form" enctype="multipart/form-data">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" @click="chooseRole(1)" name="options" id="option1"
                           autocomplete="off" checked> Donator
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" @click="chooseRole(2)" name="options" id="option2"
                           autocomplete="off"> Organizacija
                </label>
            </div>
            <div class="row justify-content-around register-main">
                <div class="col-6 sec">
                    <div class="form-group">
                        <label for="name">Ime</label>
                        <input type="text" id="name" name="name" class="form-control"
                               placeholder="Vaše puno ime i prezime">
                    </div>
                    <div class="form-group">
                        <label for="email">Email addresa</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               placeholder="Enter email">
                        <!--                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone-->
                        <!--                            else.-->
                        <!--                        </small>-->
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                </div>
                <div class="col-6 sec">
                    <div v-if="user.role_id === 2" class="if">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="title">Naziv Organizacije</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           placeholder="Pun naziv organizacije">
                                </div>
                                <div class="form-group">
                                    <label for="location">Lokacija</label>
                                    <input type="text" id="location" name="location" class="form-control"
                                           placeholder="Mesto rada">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="logo">Logo organizacije</label>
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
                            <label for="field_of_work">Čime se organizacija bavi u jednoj rečenici:</label>
                            <textarea type="text" id="field_of_work" name="field_of_work" class="form-control"
                                      placeholder="Mi se bavimo time i time.."></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="button" class="btn btn-success sharp-left" @click="submitForm()">Pošalji</button>
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
                    role_id: 1,
                    //
                    title: "",
                    location: "",
                    field_of_work: "",
                    org_logo: "",
                    user_id: ""
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
                axios.post('api/register', this.user)
                    .then((response)=> {
                        window.location.href = '/home';
                    })
            }
        }

    }
</script>