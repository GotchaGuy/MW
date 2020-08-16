<template>
    <div class="account">
        <div class="container">
            <div class="row">
                <!--            justify-content-center-->
                <div class="row mt-4">
                    <div class="col-7">
                    <h4 class="white">{{user.name}}'s donations: </h4>
                    </div>
                    <div class="col-5 other">
                        <h5 class="white">Check out all smart contract transactions</h5>
                        <div class="here">
                            <a href="https://rinkeby.etherscan.io/address/0xDFD5d5E1D674cE896d8e0d4B7F84246fCF0186C3" target="_blank">
                        HERE
                            </a>
                        </div>
                    </div>
                </div>
                <div class="empty" v-if="donations.length === 0">
                    <p class="white">No submitted donations at this time.</p>
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
            axios.get('/api/my-acc')
                .then((response) => {
                    this.user = response.data;
                    console.log(this.user);
                });
            axios.get('/api/acc-donations')
                .then((response) => {
                    this.donations = response.data;
                    console.log(this.donations);
                });
        },
        methods: {}

    }
</script>