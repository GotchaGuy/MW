<template>
    <div class="container">
        <div class="row">
            <!--            <div class="col-9">-->

            <a-form :form="form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit"
                    class="campaign-form">
                <!--                <a-form-item label="Naziv kampanje">-->
                <div class="row">
                    <div class="col-4">
                        <a-input
                                v-decorator="['note', { rules: [{ required: true, message: 'Please input your note!' }] }]"
                        />
                        <!--                </a-form-item>-->
                        <!--                <a-form-item label="Kategorija kampanje">-->
                    </div>
                    <div class="col-3">
                        <a-select
                                v-decorator="['gender',
          { rules: [{ required: true, message: 'Please select your gender!' }] },]"
                                placeholder="Select a option and change input text above"
                                @change="handleSelectChange">
                            <a-select-option value="male">
                                male
                            </a-select-option>
                            <a-select-option value="female">
                                female
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
                            @change="onChange"
                    />
                </a-form-item>

                <a-form-item label="Overhead kampanje">
                    <a-input-number
                            :default-value="0"
                            :min="0"
                            :max="100"
                            :formatter="value => `${value}%`"
                            :parser="value => value.replace('%', '')"
                            @change="onChange"
                    />
                </a-form-item>

                <a-form-item label="Opis kampanje">
                    <a-textarea placeholder="Opis kampanje" :rows="4"/>
                </a-form-item>


                <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                    <a-button type="primary" html-type="submit">
                        Pošalji
                    </a-button>
                </a-form-item>
            </a-form>

            <!--            -->
            <!--                <el-form ref="form" :model="form" label-width="120px" label-position="top" class="mx-auto">-->
            <!--                    <el-form-item label="Naziv kampanje">-->
            <!--                        <el-input v-model="form.title"></el-input>-->
            <!--                    </el-form-item>-->
            <!--                    <el-form-item label="Kategorija kampanje">-->
            <!--                        <el-select v-model="form.region" placeholder="please select your zone">-->
            <!--                            <el-option label="Zone one" value="shanghai"></el-option>-->
            <!--                            <el-option label="Zone two" value="beijing"></el-option>-->
            <!--                        </el-select>-->
            <!--                    </el-form-item>-->
            <!--                    <el-form-item label="Trajanje kampanje">-->
            <!--                        <el-col :span="11">-->
            <!--                            <el-date-picker-->
            <!--                                    v-model="value1"-->
            <!--                                    type="daterange"-->
            <!--                                    range-separator="To"-->
            <!--                                    start-placeholder="Start date"-->
            <!--                                    end-placeholder="End date">-->
            <!--                            </el-date-picker>-->
            <!--                        </el-col>-->
            <!--                    </el-form-item>-->
            <!--                    <el-form-item label="Finansijski cilj kampanje">-->
            <!--                        <el-input-number v-model="num" controls-position="right" @change="handleChange" :min="1000"-->
            <!--                                         :max="1000001"></el-input-number>-->
            <!--                    </el-form-item>-->
            <!--                    <el-form-item label="Opis kampanje">-->
            <!--                        <el-input type="textarea" v-model="form.desc"></el-input>-->
            <!--                    </el-form-item>-->
            <!--                    <el-form-item>-->
            <!--                        <el-button type="primary" @click="onSubmit">Create</el-button>-->
            <!--                        <el-button>Cancel</el-button>-->
            <!--                    </el-form-item>-->
            <!--                </el-form>-->
            <!--            </div>-->
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                formLayout: 'horizontal',
                form: this.$form.createForm(this, {name: 'coordinated'}),
            }
        },
        mounted() {

        }
        ,
        methods: {
            onChange(date, dateString) {
                console.log(date, dateString);
            },
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log('Received values of form: ', values);
                    }
                });
            },
            handleSelectChange(value) {
                console.log(value);
                this.form.setFieldsValue({
                    note: `Hi, ${value === 'male' ? 'man' : 'lady'}!`,
                });
            },
        }

    }
</script>