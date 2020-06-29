<template>
    <div class="container org">
        <div class="row">
            <div class="col-4">
                <div class="img">
                    <img src="/images/logo.png" alt="">

                </div>
            </div>
            <div class="col-8">
                <h2>Charity organization: {{organization.title}}</h2>
                <h5>Platform representative: <strong>{{organization.user.name}}</strong></h5>
                <h5>What we do: <strong>{{organization.field_of_work}}</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="description">
                    <!--                insert drawer here-->
                    <h5>About Us</h5>
                    <p>{{organization.description}}</p>

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