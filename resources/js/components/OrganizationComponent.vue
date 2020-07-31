<template>
    <div class="container org">
        <div class="row">
            <div class="col-4">
                <div class="img mx-auto">
                    <img :src="organization.org_logo" alt="">

                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <h6 class="text-muted">Charity organization:</h6>
                        <h2>{{organization.title}}</h2>
                        <h6 class="text-muted">Location:</h6>
                        <h4>{{organization.location}}</h4>
                        <h6 class="text-muted">Platform representative:</h6>
                        <h4>{{organization.user.name}}</h4>
                    </div>
                    <div class="col-5">
                        <h6 class="text-muted">What we do:</h6>
                        <h4>{{organization.field_of_work}}</h4>
                    </div>
                </div>
            </div>
        </div>

        <h5>Our Campaigns</h5>
        <div class="row">
            <div class="col-4 campaign" v-for="campaign in organization.campaigns">
                <div class="card mb-3">
                    <a :href="'/campaign/' + campaign.id">
                        <div class="row no-gutters">
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h6 class="çard-text">{{campaign.time_left}}</h6>
                                    <h6 class="card-title">{{campaign.category.title}}</h6>
                                    <h3 class="card-title">{{campaign.title}}</h3>
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
                                <img :src="campaign.image + '?w=140&h=235&fit=crop-center'" class="card-img" alt="...">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ["dataOrg"],
        data() {
            return {
                organization: JSON.parse(this.dataOrg),

            }
        },
        mounted() {
            console.log(this.organization);
        },
        methods: {}

    }
</script>