<template>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-7">
                            <div class="card-body">
                                <h6 class="çard-text">27 more days</h6>
                                <h6 class="card-title">Campaign Category</h6>
                                <h2 class="card-title">Campaign Title</h2>
                                <!--                                <p class="card-text">This is a wider card with supporting text below as a natural-->
                                <!--                                    lead-in to-->
                                <!--                                    additional content. This content is a little bit longer.</p>-->
                                <p class="card-text">
                                    <small class="text-muted">Raised: e74.000 | <strong>89%</strong></small>
                                </p>
                                <div class="meter-border">
                                    <div class="meter-inside"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="https://source.unsplash.com/random/600x950" class="card-img" alt="...">
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
                campaigns: {},

            }
        },
        mounted() {
            axios.get('/api/campaigns')
                .then((response) => {
                    this.campaigns = response.data;
                    console.log(this.campaigns);
                });

        }
        ,
        methods: {}

    }
</script>