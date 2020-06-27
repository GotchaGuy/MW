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
            // this.campaign = JSON.parse(this.dataCampaign);
            console.log(this.campaign);

            // this.categories = JSON.parse(this.dataCategories);
            // this.donations = JSON.parse(this.dataDonations);

            // for (let i; i <= this.categories.length; i++) {
            //     if (this.campaign.category_id === this.categories[i].id) {
            //         this.category_title = this.categories[i].title;
            //     }
            // }

        },
        methods: {}

    }
</script>