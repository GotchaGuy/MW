<template>
    <div class="container">
        <div class="row justify-content-center" v-for="post in posts">
            <div class="col-md-6 mb-3 post">
                    <div class="card hvr-underline-from-left md-4">
                        <div class="card-header row">
                            <div class="fave"></div>
                            <div class="col">
                                <h5><strong>{{post.campaign.title}}</strong></h5>
                                <h6><strong>{{post.campaign.time_left}}</strong></h6>
                            </div>
                            <div class="col text-right">
<!--                                <a-progress type="circle" :percent="post.campaign.percent" :width="80"/>-->
<!--                                {{post.campaign.organization.title}}-->
                            </div>
                        </div>
                        <div class="box" v-if="post.image !== ''">
                            <img :src="post.image" alt="notesImage" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-left">{{post.title}}</div>
                                <div class="col-6 text-right">{{post.timestamp}}</div>
                            </div>
                            <div class="card-text">We have successfully raised $80.000 with a week to spare. Thank you
                                so much to everyone who contributed. {{post.body}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>
</template>


<script>
    export default {
        data() {
            return {
                posts: {},
            }
        },
        mounted() {
            axios.get('/api/posts')
                .then((response) => {
                    this.posts = response.data;
                    console.log(this.posts);
                });
        },
        methods: {
            organizePosts() {

            },
        }

    }
</script>