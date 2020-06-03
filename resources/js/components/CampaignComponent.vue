<template>
    <div>
        <div class="row">
            <div class="col-8 camp-header">
                <img src="https://source.unsplash.com/random/" alt="">
            </div>
            <div class="col-4">
                <h2 class="card-title">Campaign Title | Campaign Category</h2>
                <h3 class="card-title">27 more days</h3>
                <div>
                    <h1 class="text-muted">Raised: e74.000 <strong></strong></h1>
                    <el-progress :text-inside="true" :stroke-width="24" :percentage="percentage"
                                 status="success"></el-progress>
                </div>
               <el-button type="info m-2" round>Doniraj</el-button>
            </div>
        </div>
        <!--        <header class="big-image">-->

        <!--            <div class="within">-->
        <!--                <h1>Category Title</h1>-->
        <!--            </div>-->
        <!--        </header>-->
        <!--        <main>-->
        <div class="row">
            <div class="col-8 p-5">
                <p class="card-text ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam corporis
                    dolorem enim explicabo
                    fuga harum id illo inventore labore non omnis pariatur quae, rem reprehenderit tempora tenetur ut
                    voluptate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam corporis dolorem
                    enim
                    explicabo fuga harum id illo inventore labore non omnis pariatur quae, rem reprehenderit tempora
                    tenetur
                    ut voluptate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam corporis
                    dolorem
                    enim explicabo fuga harum id illo inventore labore non omnis pariatur quae, rem reprehenderit
                    tempora
                    tenetur ut voluptate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam
                    corporis
                    dolorem enim explicabo fuga harum id illo inventore labore non omnis pariatur quae, rem
                    reprehenderit
                    tempora tenetur ut voluptate.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam
                    corporis dolorem enim explicabo fuga harum id illo inventore labore non omnis pariatur quae, rem
                    reprehenderit tempora tenetur ut voluptate.</p>
            </div>
        </div>


    </div>
</template>


<script>
    export default {
        data() {
            return {
                percentage: 89,
            }
        },
        mounted() {

        },
        methods: {}

    }
</script>