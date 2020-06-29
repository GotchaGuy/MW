<template>
    <div class="container">
        <div class="row">
            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit" id="campaign-form">
                <a-row :gutter="20">
                    <a-col :span="10">
                        <a-form-item label="Naziv kampanje">
                            <a-input
                                    v-decorator="['title',
                                 { rules: [{ required: true, message: 'Naziv kampanje je obavezan.' }] }]"
                                    placeholder="Naziv kampanje"
                                    v-model="campaign.title"
                            />
                        </a-form-item>
                    </a-col>

                    <a-col :span="14">
                        <a-form-item label="Kategorija kampanje">
                            <a-select
                                    v-decorator="['category',
          { rules: [{ required: true, message: 'Biranje kategorije kojoj kampanja pripada je obavezno.' }] },]"
                                    placeholder="Kategorija kampanje"
                                    v-model="campaign.category_id">
                                <a-select-option v-for="(category, index) in categories" :value="category.id"
                                                 v-bind:key="index">
                                    {{category.title}}
                                </a-select-option>
                            </a-select>
                        </a-form-item>
                    </a-col>
                </a-row>
                <a-row :gutter="24">
                    <a-col :span="16">
                        <a-form-item label="Trajanje kampanje">
                            <a-range-picker @change="onChange"
                                            v-decorator="['time',
                                 { rules: [{ required: true, message: 'Određivanje trajanja kampanje je obavezno.' }] }]"
                                            format="YYYY MMM Do"
                            />
                        </a-form-item>
                    </a-col>

                    <a-col :span="8">
                        <a-form-item label="Cilj">
                            <a-input-number
                                    :min="1000" :max="1000001"
                                    :default-value="1000"
                                    v-model="campaign.euro_goal"
                                    v-decorator="['goal',
                                 { rules: [{ required: true, message: 'Cilj kampanje je obavezan.' }] }]"
                            />
                            €
                            <!--                        :formatter="value => `${value}€`"-->
                            <!--                        :parser="value => value.replace('€', '')"-->
                        </a-form-item>
                    </a-col>
                </a-row>
                <a-form-item label="Overhead troškovi kampanje">
                    <a-input-number
                            :default-value="0"
                            :min="0"
                            :max="100"
                            v-model="campaign.overhead"
                            v-decorator="['overhead',
                                 { rules: [{ required: true, message: 'Vaši procenjeni troškovi su obavezni.' }] }]"
                    />
                    %
                </a-form-item>

                <a-form-item label="Opis kampanje">
                    <a-textarea placeholder="Opis kampanje" :rows="4" v-model="campaign.description"
                                v-decorator="['time',
                                 { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                </a-form-item>


                <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                    <a-button type="primary" html-type="submit">
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