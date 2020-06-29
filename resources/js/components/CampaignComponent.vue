<template>
    <div class="uno">
        <div class="row">
            <div class="col-8 camp-header">
                <img src="https://source.unsplash.com/random/" alt="">
            </div>
            <div class="col-4 camp-right">
                <h1 class="card-title">{{campaign.title}}</h1>
                <h6 class="card-title">{{campaign.category.title}}</h6>
                <h3 class="card-title">{{campaign.time_left}}</h3>
                <div>
                    <h1 class="text-muted">Raised: €{{campaign.raised}}<strong></strong></h1>
                    <el-progress :text-inside="true" :stroke-width="24" :percentage="campaign.percent"
                                 status="success"></el-progress>
                </div>
                <div class="camp-button">
                    <donate :campaignid="campaign.id"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 p-5">
                <h5>By: <a :href="'/org/' + campaign.organization.id">{{campaign.organization.title}}</a></h5>
                <p class="card-text">
                    {{campaign.description}}
                </p>

            </div>
        </div>


    </div>
</template>


<script>

    export default {
        props: ["dataCampaign", "dataCategories", "dataDonations"],
        data() {
            return {
                percentage: 89,
                campaign: JSON.parse(this.dataCampaign),
                categories: {},
                category_title: "",
                donations: {},
            }
        },
        mounted() {
            console.log(this.campaign);
            console.log(moment.now());
            EventBus.$on('donation-submitted', (donation) => {
                if (moment.now() === moment(this.campaign.end)) {
                    if (this.campaign.raised !== this.campaign.euro_goal) {
                        if (donation.plan_b === 3) {
                            // axios.delete('/api/donations/' + $id)
                            //         .then((response) => {
                            //     probably a notif
                            // })
                        }
                        if (donation.plan_b === 2) {
                            // axios.delete('/api/donations/' + $id)
                            axios.post('/api/donation_b', donation)
                                .then((response) => {
                                    //probably a notif
                                });
                        }
                    }

                }
            });
        },
        methods: {}

    }
</script>