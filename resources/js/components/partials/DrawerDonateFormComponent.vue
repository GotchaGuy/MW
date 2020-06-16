<template>
    <div>
        <a-button type="primary" icon="share-alt" size="large"/>
        <a-button type="success outline" @click="showDrawer">
            Doniraj
        </a-button>
        <a-drawer
                title="Koliko želite da donirate?"
                :width="720"
                :visible="visible"
                :body-style="{ paddingBottom: '80px' }"
                @close="onClose"
        >
            <a-form :form="form" layout="horizontal" hide-required-mark>
                <div class="row">
                    <div class="col-12">
                        <label for="donacija">Donacija</label>
                        <el-button type="success" id="donacija" plain @click="toDonate(10)">€10</el-button>
                        <el-button type="success" plain @click="toDonate(20)">€20</el-button>
                        <el-button type="success" plain @click="toDonate(30)">€30</el-button>
                        <el-button type="success" plain @click="toDonate(50)">€50</el-button>
                        <el-button type="success" plain @click="toDonate(100)">€100</el-button>
                        <el-button type="success" plain @click="toDonate(500)">€500</el-button>
                        <a-input-number size="large" :min="1" :max="100000" default-value="" @change="toDonate"/>

                    </div>
                </div>
                <!--                <a-row :gutter="16">-->
                <!--                    <a-col :span="16">-->
                <!--                        <a-form-item label="Donacija">-->
                <!--                            <a-button class="p-2">€10</a-button>-->
                <!--                            <a-button>€20</a-button>-->

                <!--                            <a-button>€30</a-button>-->

                <!--                            <a-button>€50</a-button>-->

                <!--                            <a-button>€100</a-button>-->

                <!--                            <a-button>€500</a-button>-->

                <!--                            <a-input>€500</a-input>-->
                <!--                        </a-form-item>-->
                <!--                    </a-col>-->


                <!--                    <a-col :span="12">-->

                <!--                    </a-col>-->

                <!--                </a-row>-->
                <!--                <a-row :gutter="16">-->
                <!--                    <a-col :span="12">-->

                <!--                    </a-col>-->
                <!--                </a-row>-->

            </a-form>
            <div
                    :style="{
          position: 'absolute',
          right: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
          zIndex: 1,
        }"
            >
                <a-button :style="{ marginRight: '8px' }" @click="onClose">
                    Otkaži
                </a-button>

                <a-button type="primary" @click="onClose">
                    Doniraj {{this.donation}}
                </a-button>
            </div>
        </a-drawer>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                form: this.$form.createForm(this),
                visible: false,
                donation: "",
            };
        },
        methods: {
            showDrawer() {
                this.visible = true;
            },
            onClose() {
                this.visible = false;
            },
            toDonate(num) {
                this.donation = "€" + num;
            },
        },
    };
</script>