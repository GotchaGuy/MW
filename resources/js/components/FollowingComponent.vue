<template>
    <div class="row following">
        <!--                <img src="'https://source.unsplash.com/random/300x300'" alt="">-->
        <swiper class="swiper" :options="swiperOption">
<!--            <swiper-slide v-for="(campaign, index) in campaigns" v-if="campaign.id === follows." :key="index">-->
<!--            <div class="item">-->
<!--                <img :src="campaign.image" alt="">-->
<!--                <div class="meter-border">-->
<!--                    <div class="meter-inside"></div>-->
<!--                </div>-->
<!--                </div>-->
<!--            </swiper-slide>-->
            <swiper-slide>Slide 2</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>
            <swiper-slide>Slide 4</swiper-slide>
            <swiper-slide>Slide 5</swiper-slide>
            <swiper-slide>Slide 6</swiper-slide>
            <swiper-slide>Slide 7</swiper-slide>
            <swiper-slide>Slide 8</swiper-slide>
            <swiper-slide>Slide 9</swiper-slide>
            <swiper-slide>Slide 10</swiper-slide>
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
                campaigns: {},
                follows: {},
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
                    this.campaigns = response.data;
                    console.log(this.campaigns);
                });
            axios.get('/api/follows')
                .then((response) => {
                    this.follows = response.data;
                    console.log(this.follows);
                });
        },
        methods: {}

    }
</script>

<!--<style lang="scss" scoped>-->

<!--</style>-->