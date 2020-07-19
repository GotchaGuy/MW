<template>
    <div class="uno">
        <div class="row">
            <div class="col-8 camp-header">
                <div class="org-image">
                    <a :href="'/org/' + campaign.organization.id">
                        <img :src="campaign.organization.org_logo" alt="">
                    </a>
                </div>
                <img class="big" :src="campaign.image" alt="">
<!--                https://source.unsplash.com/random/-->
            </div>

            <div class="col camp-right">
                <h6 class="card-title">{{campaign.category.title}}</h6>
                <h1 class="card-title">{{campaign.title}}</h1>
                <div class="row">
                    <div class="col">
                <h6 class="text-muted">Up until:</h6>
                <h3 class="card-title">{{campaign.time_left}}</h3>
                    </div>
                    <div class="col">
                <h6 class="text-muted">Overhead:</h6>
                <h3 class="card-title">{{campaign.overhead}}%</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6 class="text-muted">Raised:</h6>
                        <h2>€{{campaign.raised}}</h2>
                    </div>
                    <div class="col">
                        <h6 class="text-muted">Goal:</h6>
                        <h2 class="blue">€{{campaign.euro_goal}}</h2>
                    </div>
                </div>
                <el-progress :text-inside="true" :stroke-width="35"
                             :percentage="campaign.percent"
                             status="success">
                </el-progress>
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
            // EventBus.$on('donation-submitted', (donation) => {
            //     if (moment.now() === moment(this.campaign.end)) {
            //         if (this.campaign.raised < this.campaign.euro_goal) {
            //             if (donation.plan_b === 3) {
            //                 // axios.delete('/api/donations/' + $id)
            //                 //         .then((response) => {
            //                 //     probably a notif
            //                 // })
            //             }
            //             if (donation.plan_b === 2) {
            //                 // axios.delete('/api/donations/' + $id)
            //                 axios.post('/api/donation_b', donation)
            //                     .then((response) => {
            //                         //probably a notif
            //                     });
            //             }
            //         }
            //
            //     }
            // });
        },
        methods: {}

    }
</script>