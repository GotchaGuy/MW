<template>
    <div class="row following">
        <swiper class="swiper" :options="swiperOption">
            <swiper-slide v-for="(follow, index) in follows" :key="index">
                <div class="item">
                    <img :src="follow.image" alt="">
                    <!--                <div class="meter-border">-->
                    <!--                    <div class="meter-inside"></div>-->
                    <!--                </div>-->
                </div>
                <h6 class="title">{{follow.title}}</h6>
                <h6 class="percent">{{follow.percent}}%</h6>
            </swiper-slide>
            <!--            <swiper-slide>-->
            <!--                <div class="item">-->
            <!--                    <img src="https://source.unsplash.com/random/300x300" alt="">-->
            <!--                </div>-->
            <!--            </swiper-slide>-->
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
                    slidesPerView: 7,
                    spaceBetween: 20,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                },
            }
        },
        mounted() {
            axios.get('/api/follows')
                .then((response) => {
                    this.follows = response.data;
                    console.log('follows: ' + this.follows);
                });
        },
        methods: {}

    }
</script>

<!--<style lang="scss" scoped>-->

<!--</style>-->