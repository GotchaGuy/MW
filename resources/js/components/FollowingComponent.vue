<template>
    <div class="row following">
        <div class="col-2">
            <div class="item">
                <img src="" alt="">
                <div class="meter-border">
                    <div class="meter-inside"></div>
                </div>
            </div>
            <h2>Title</h2>
        </div>

    </div>
</template>


<script>
    export default {
        data() {
            return {
                campaigns: []
            }
        },
        mounted() {
            axios.get('/api/campaigns')
                .then((response) => {
                    // for (let i = 0; i <= response.data.length; i++) {
                    //     if (response.data[i].following == true) {
                    //         this.campaigns.unshift(response.data[i]);
                    //     }
                    // }
                    this.campaigns = response.data;
                    console.log(this.campaigns);


                });
        },
        methods: {}

    }
</script>