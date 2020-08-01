<template>
    <div class="account">
    <div class="container">
        <div class="row">
            <!--            justify-content-center-->
            <div class="row mt-4">
                <h4 class="white">{{user.name}}'s donations: </h4>
            </div>
            <div class="row justify-content-center" v-for="donation in donations">
                <div class="col-3">
                    <h6 class="text-muted gray">Campaign Title:</h6>
                    <h4 class="card-title white">{{donation.campaign.title}}</h4>
                </div>
                <div class="col-7">
                    <h6 class="text-muted gray">Donation Amount:</h6>
                    <h4 class="card-title blue">€{{donation.euro_amount}}</h4>
                </div>
                <div class="col-2">
                    <h6 class="text-muted gray">Timestamp:</h6>
                    <h4 class="card-title white">{{donation.timestamp}}</h4>
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
                donations: "",
                 user: "",
            }
        },
        mounted() {
            axios.get('/api/acc-donations')
                .then((response) => {
                    this.donations = response.data;
                    console.log(this.donations);
                });
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    console.log(this.user);
                });
        },
        methods: {}

    }
</script>