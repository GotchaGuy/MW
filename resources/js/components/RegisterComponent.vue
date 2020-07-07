<template>
<!--    <div class="back">-->
        <div class="container register">
            <!--        <div class="row">-->
            <form method="POST" action="/register">
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
                <div class="row justify-content-around">
                    <div class="col-6">
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
                    <div class="col-6">
                        <div v-if="user.role_id === 2" class="if">
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
                            <div class="form-group">
                                <label for="field_of_work">Čime se organizacija bavi u jednoj rečenici:</label>
                                <textarea type="text" id="field_of_work" name="field_of_work" class="form-control"
                                          placeholder="Mi se bavimo time i time.."></textarea>
                            </div>
                            <!--                        <div class="form-group">-->
                            <!--                            <label for="description">Opis organizacije:</label>-->
                            <!--                            <textarea type="text" id="description" name="description" class="form-control"-->
                            <!--                                      placeholder="Postojimo od tad i tad.."></textarea>-->
                            <!--                        </div>-->
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Pošalji</button>
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
                },
                organization: {
                    title: "",
                    location: "",
                    field_of_work: "",
                    // description: "",
                    user_id: ""
                },
            }
        },
        mounted() {

        },
        methods: {
            chooseRole(num) {
                this.user.role_id = num;
            }
        }

    }
</script>