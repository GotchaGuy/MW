<template>
    <div class="container">
        <div class="row">
            <!--            <div class="col-9">-->

            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    id="campaign-form">
                <!--                <a-form-item label="Naziv kampanje">-->
                <div class="row">
                    <div class="col-4">
                        <a-input
                                v-decorator="['title',
                                 { rules: [{ required: true, message: 'Molimo Vas upišite naziv kampanje.' }] }]"
                                placeholder="Naslov kampanje"
                                v-model="campaign.title"
                        />
                        <!--                </a-form-item>-->
                        <!--                <a-form-item label="Kategorija kampanje">-->
                    </div>
                    <div class="col-4">
                        <a-select
                                v-decorator="['category',
          { rules: [{ required: true, message: 'Molimo Vas izaberite kategoriju kojoj kampanja pripada.' }] },]"
                                placeholder="Select a option and change input text above"
                                v-model="campaign.category_id">
                            <a-select-option v-for="(category, index) in categories" :value="category.id"
                                             v-bind:key="index">
                                {{category.title}}
                            </a-select-option>
                        </a-select>
                        <!--                </a-form-item>-->
                    </div>
                </div>
                <a-form-item label="Trajanje kampanje">
                    <a-range-picker @change="onChange"/>
                </a-form-item>

                <a-form-item label="Cilj">
                    <a-input-number
                            :min="1000" :max="1000001"
                            :default-value="1000"
                            :formatter="value => `${value}€`"
                            :parser="value => value.replace('€', '')"
                            v-model="campaign.euro_goal"
                    />
                </a-form-item>

                <a-form-item label="Overhead troškovi kampanje">
                    <a-input-number
                            :default-value="0"
                            :min="0"
                            :max="100"
                            :formatter="value => `${value}%`"
                            :parser="value => value.replace('%', '')"
                            v-model="campaign.overhead"
                    />
                </a-form-item>

                <a-form-item label="Opis kampanje">
                    <a-textarea placeholder="Opis kampanje" :rows="4" v-model="campaign.description"/>
                </a-form-item>


                <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                    <a-button type="primary" html-type="submit">
                        <!--                         @click="submitCampaign"-->
                        Pošalji
                    </a-button>
                </a-form-item>
            </a-form>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                formLayout: 'horizontal',
                form: this.$form.createForm(this, {name: 'coordinated'}),
                categories: {},
                campaign: {
                    title: "",
                    euro_goal: "",
                    start: "",
                    end: "",
                    overhead: "",
                    image: "https://source.unsplash.com/random/400x400",
                    description: "",
                    user_id: "",
                    category_id: ""
                },
            }
        },
        mounted() {
            axios.get('/api/categories')
                .then((response) => {
                    this.categories = response.data;
                    console.log(this.categories);
                })
        }
        ,
        methods: {
            onChange(date, dateString) {
                // console.log(date, dateString);
                // console.log(dateString[0]);
                this.campaign.start = dateString[0];
                this.campaign.end = dateString[1];
                // 'range-picker': [rangeValue[0].format('YYYY-MM-DD'), rangeValue[1].format('YYYY-MM-DD')],
            },
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log('Received values of form: ', values);
                        console.log(this.campaign);
                        axios.post('/api/new-campaign', this.campaign)
                            .then((response) => {
                                document.getElementById("campaign-form").reset();
                                window.location.href = '/home';
                            })
                    }
                });
            },
            submitCampaign() {

            }
        }

    }
</script>