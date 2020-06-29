<template>
    <div class="container">
        <div class="row">
            <!--            the + button-->
            <div class="col-4 campaign">
                <div class="card mb-3">
                    <a href="/new-campaign">
                        <el-button type="success" icon="el-icon-plus"></el-button>
                    </a>
                </div>
            </div>

            <div class="col-4 campaign" v-for="campaign in campaigns">
                <div class="card mb-3">
                    <a :href="'/campaign/' + campaign.id">
                        <div class="row no-gutters">
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h6 class="çard-text">{{campaign.time_left}}</h6>
                                    <h6 class="card-title">{{campaign.category.title}}</h6>
                                    <h2 class="card-title">{{campaign.title}}</h2>
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
                                <img :src="campaign.image" class="card-img" alt="...">
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
        methods: {}

    }
</script>