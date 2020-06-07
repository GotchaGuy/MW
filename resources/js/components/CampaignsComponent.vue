<template>
    <div class="container">
        <div class="row">
            <div class="col-4 campaign" v-for="campaign in campaigns">
                <div class="card mb-3">
                    <!--                    style="max-width: 540px;"-->
                        <a :href="'/campaign/' + campaign.id">
                    <div class="row no-gutters">
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h6 class="çard-text" :value="timeLeft(campaign.end)"></h6>
                                    <h6 class="card-title">{{campaign.category.title}}</h6>
                                    <h2 class="card-title">{{campaign.title}}</h2>
                                    <div class="graph">
                                    <p class="card-text">
                                        <small class="text-muted">Raised: e74.000</small>
                                    </p>
                                    <el-progress :text-inside="true" :stroke-width="20" :percentage="89"
                                                 status="success"></el-progress>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img src="https://source.unsplash.com/random/600x950" class="card-img" alt="...">
                            </div>
                    </div>
                        </a>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import moment from "moment";

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

        },
        methods: {
            timeLeft(end) {
                return moment().endOf(end).fromNow();
            },
        }

    }
</script>