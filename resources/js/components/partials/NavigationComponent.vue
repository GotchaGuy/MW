<template>
    <div>
        <ul class="d-flex justify-content-center">
            <li class="green">
                <a href="/home" class="nav-item nav-link text-center">Campaigns</a>
            </li>
            <!--                <a-icon type="home" />-->
            <!--                theme="filled"-->
            <li>
                <a href="/feed" class="nav-item nav-link text-center">Feed</a>
            </li>
            <!--                <a-icon type="database" />-->

            <li v-if="user.role_id === 2">
                <a href="/new-post" class="nav-item nav-link text-center">New Post</a>
            </li>
            <!--            <a-icon type="plus-square"  />-->
            <li>
                <a href="/me" class="nav-item nav-link text-center">My Account</a>
            </li>
            <!--                <a-icon type="smile"  />-->
        </ul>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                user: "",
            }
        },
        mounted() {
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    console.log(this.user);
                });
        },
    methods: {

    }

    }
</script>