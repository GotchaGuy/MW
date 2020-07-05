<template>
    <div class="container">
        <div class="row">
            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    id="campaign-form">
                <a-row :gutter="24">
                    <a-col :span="10">
                        <a-form-item label="Naziv posta">
                            <a-input placeholder="Dragi donatori.." v-model="post.title"/>
                        </a-form-item>
                    </a-col>

                    <a-col :span="14">
                        <a-form-item label="Odabir kampanje">
                            <a-select
                                    v-decorator="['campaign', { rules: [{ required: true, message: 'Biranje kampanje kojoj post pripada je obavezno.' }] },]"
                                    placeholder="Vaše kampanje"
                                    v-model="post.campaign_id">
                                <a-select-option v-for="(campaign, index) in organization.campaigns" :value="campaign.id"
                                                 v-bind:key="index">
                                    {{campaign.title}}
                                </a-select-option>
                            </a-select>
                        </a-form-item>
                    </a-col>
                </a-row>

                <a-row :gutter="20">
                    <a-col :span="10">
                        <a-form-item label="Opis kampanje">
                            <a-textarea placeholder="O čemu želite da obavestite donatore?" :rows="4" v-model="post.body"
                                        v-decorator="['time', { rules: [{ required: true, message: 'Molimo Vas temeljno opišite Vašu kampanju.' }] }]"/>
                        </a-form-item>
                    </a-col>
                </a-row>

                <a-row :gutter="20">
                    <a-col :span="10">
                        <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                            <a-button type="primary" html-type="submit">
                                Pošalji
                            </a-button>
                        </a-form-item>
                    </a-col>
                </a-row>
            </a-form>
        </div>
    </div>
</template>


<script>
    export default {
         props: ["dataOrg"],
        data() {
            return {
                organization: JSON.parse(this.dataOrg),
                formLayout: 'horizontal',
                form: this.$form.createForm(this, {name: 'coordinated'}),
                post: {
                    title: "",
                    body: "",
                    image: "",
                    campaign_id: ""
                },
            }
        },
        mounted() {
            console.log(this.organization);
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log(values);
                        axios.post('/api/new-post', this.post)
                            .then((response) => {
                                document.getElementById("post-form").reset();
                                window.location.href = '/feed';
                            })
                    }
                });
            },
        }

    }
</script>