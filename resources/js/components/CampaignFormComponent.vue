<template>
    <div class="container">
        <div class="row">
            <a-form :form="form" @submit="handleSubmit" id="campaign-form" enctype="multipart/form-data">
                <!--                :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }"-->
                <a-row :gutter="10">
                    <a-col :span="4">
                        <a-form-item>
                            <!--                            label="Naziv kampanje"-->
                            <h5>Naziv kampanje</h5>
                            <a-input
                                    v-decorator="['title',
                                 { rules: [{ required: true, message: 'Naziv kampanje je obavezan.' }] }]"
                                    placeholder="Naziv kampanje"
                                    v-model="campaign.title"
                            />
                        </a-form-item>
                    </a-col>

                    <a-col :span="5">
                        <a-form-item>
                            <!--                            label="Kategorija kampanje"-->
                            <h5>Kategorija kampanje</h5>
                            <a-select v-decorator="['category',
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
                <a-row :gutter="10">
                    <a-col :span="7">
                        <a-form-item>
                            <!--                            label="Trajanje kampanje"-->
                            <h5>Trajanje kampanje</h5>
                            <a-range-picker @change="onChange"
                                            v-decorator="['time',
                                 { rules: [{ required: true, message: 'Određivanje trajanja kampanje je obavezno.' }] }]"
                                            format="YYYY MMM Do"/>
                        </a-form-item>
                    </a-col>
                    <a-col :span="4">
                        <a-form-item>
                            <!--                            label="Cilj"-->
                            <h5>Cilj</h5>
                            <a-input-number
                                    :min="1000" :max="1000001"
                                    prefix="€"
                                    placeholder="€"
                                    :default-value="1000"
                                    v-model="campaign.euro_goal"
                                    v-decorator="['goal',
                                 { rules: [{ required: true, message: 'Cilj kampanje je obavezan.' }] }]"
                            />

                            <!--                        :formatter="value => `${value}€`"-->
                            <!--                        :parser="value => value.replace('€', '')"-->
                        </a-form-item>
                    </a-col>
                </a-row>
                <a-row :gutter="10">
                    <a-col :span="5">
                        <a-form-item>
                            <!--                    label="Overhead troškovi kampanje"-->
                            <h5>Troškovi organizacije</h5>
                            <a-input-number
                                    aria-describedby="overhead"
                                    :default-value="0"
                                    :min="0"
                                    :max="100"
                                    prefix="%"
                                    placeholder="%"
                                    v-model="campaign.overhead"
                                    v-decorator="['overhead',
                                 { rules: [{ required: true, message: 'Vaši procenjeni troškovi su obavezni.' }] }]"
                            />
                            <small id="overhead" class="form-text text-muted">Overhead</small>
                        </a-form-item>
                    </a-col>
                    <a-col :span="5">
                        <h5>Slika</h5>
                        <a-upload-dragger
                                name="file"
                                :multiple="false"
                                action="/api/image/upload/camp"
                                @change="handleChange">
                            <img v-if="campaign.image" :src="campaign.image" class="">
                            <div v-else>
                                <p class="ant-upload-drag-icon">
                                    <a-icon type="inbox"/>
                                </p>
                                <p class="ant-upload-text">
                                    Click or drag file to this area to upload
                                </p>
                            </div>
                        </a-upload-dragger>
                    </a-col>
                </a-row>
                <a-row :gutter="10">
                    <a-col :span="9">
                        <a-form-item>
                            <!--                    label="Opis kampanje"-->
                            <h5>Opis kampanje</h5>
                            <a-textarea placeholder="Opis kampanje" :rows="8" v-model="campaign.description"
                                        v-decorator="['desc',
                                 { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                        </a-form-item>
                    </a-col>
                </a-row>
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
    import ACol from "ant-design-vue/es/grid/Col";

    export default {
        components: {ACol},
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
                    image: "",
                    // image: "https://source.unsplash.com/random/400x400",
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
            handleChange(info) {
                const status = info.file.status;
                if (status !== 'uploading') {
                    console.log(info.file, info.fileList);
                }
                if (status === 'done') {
                    this.campaign.image = "/storage/" + info.file.name;
                    this.$message.success(`${info.file.name} file uploaded successfully.`);
                } else if (status === 'error') {
                    this.$message.error(`${info.file.name} file upload failed.`);
                }
            },
            submitCampaign() {

            }
        }

    }
</script>