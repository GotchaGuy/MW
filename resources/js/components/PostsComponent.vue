<template>
    <div class="container">
        <div class="row justify-content-center" v-for="post in posts">
            <div class="col-md-6 mb-3 post">
                <a href="'/posts/' + post.id">
                    <div class="card hvr-underline-from-left md-4">
                        <div class="card-header row">
                            <div class="fave"></div>
                            <div class="col">
                                <h5><strong>{{post.title}}</strong></h5>
                                <h6><strong>{{post.created_at}}</strong></h6>
                            </div>
                            <div class="col text-right">{{post.category_id}}</div>
                        </div>
                        <div class="box" v-if="post.image !== ''">
                            <img src="post.image" alt="notesImage" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <div class="card-text">We have successfully raised $80.000 with a week to spare. Thank you
                                so much to everyone who contributed. {{post.body}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</template>


<script>
    export default {
        data() {
            return {
                feed: {},
                posts: [],
            }
        },
        mounted() {
            axios.get('/api/feed')
                .then((response) => {
                    this.follows = response.data;
                    for (var i = 0; i <= this.feed.length; i++) {
                    console.log('feed: ' + this.feed[i]);
                    for (let j = 0; j <= this.feed[i].posts.length; j++) {
                        this.posts.add(this.feed[i].posts[j]);
                    }
                }
                console.log('posts: ' + this.posts);
                });
        },
        methods: {
            organizePosts() {

            },
        }

    }
</script>