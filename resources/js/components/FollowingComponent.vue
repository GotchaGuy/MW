<template>
    <div class="row following">
        <!--        <div class="col-2">-->
        <!--            <div class="item">-->
        <!--                <img src="'https://source.unsplash.com/random/300x300'" alt="">-->
        <!--                <div class="meter-border">-->
        <!--                    <div class="meter-inside"></div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <h2>Title</h2>-->
        <!--        </div>-->
        <swiper class="swiper" :options="swiperOption">
            <swiper-slide v-for="campaign in campaigns" v-if="campaign.following === true">
                <img :src="campaign.image" alt="">
                <div class="meter-border">
                    <div class="meter-inside"></div>
                </div>
            </swiper-slide>
<!--            <swiper-slide>Slide 2</swiper-slide>-->
<!--            <swiper-slide>Slide 3</swiper-slide>-->
<!--            <swiper-slide>Slide 4</swiper-slide>-->
<!--            <swiper-slide>Slide 5</swiper-slide>-->
<!--            <swiper-slide>Slide 6</swiper-slide>-->
<!--            <swiper-slide>Slide 7</swiper-slide>-->
<!--            <swiper-slide>Slide 8</swiper-slide>-->
<!--            <swiper-slide>Slide 9</swiper-slide>-->
<!--            <swiper-slide>Slide 10</swiper-slide>-->
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
    </div>
</template>


<script>
    import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
    import 'swiper/css/swiper.css'

    export default {
        name: 'swiper-example-free-mode',
        title: 'Free mode / No fixed positions',
        components: {
            Swiper,
            SwiperSlide
        },
        data() {
            return {
                campaigns: [],
                swiperOption: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                },
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

<style lang="scss" scoped>
    /*@import './base.scss';*/
</style>