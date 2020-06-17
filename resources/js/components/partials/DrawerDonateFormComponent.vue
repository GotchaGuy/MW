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
                        <h6>Donacija</h6>
<!--                        <label for="donacija">Donacija</label>-->
                        <el-button type="success" id="donacija" plain @click="toPickAmount(10)">€10</el-button>
                        <el-button type="success" plain @click="toPickAmount(20)">€20</el-button>
                        <el-button type="success" plain @click="toPickAmount(30)">€30</el-button>
                        <el-button type="success" plain @click="toPickAmount(50)">€50</el-button>
                        <el-button type="success" plain @click="toPickAmount(100)">€100</el-button>
                        <el-button type="success" plain @click="toPickAmount(500)">€500</el-button>
                        <a-input-number size="large" :min="1" :max="100000" default-value="" @change="toPickAmount"/>

                    </div>
                    <div class="col-12 donate-radio">
                        <h6>U slučaju nepostignutog cilja kampanje u dogovorenom roku,</h6>
                        <a-radio-group v-model="donation.plan_b" name="radio" id="radio" @change="onChange">
                            <a-radio :style="radioStyle" :value="1">
                               <p>želim da organizacija zadrži moju donaciju.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="2">
                                <p>želim da moja donacija bude prosleđena drugoj kampanji po mom biranju.</p>
                            </a-radio>
                            <a-radio :style="radioStyle" :value="3">
                                <p>želim povraćaj novca.</p>
                            </a-radio>
                        </a-radio-group>
                    </div>

                    <div v-if="donation.plan_b == 2">
                        <h6>Izaberite kampanju kojoj biste donirali:</h6>
                        <div></div>
                    </div>

                </div>

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

                <a-button type="primary" @click="toDonate">
                    Doniraj {{this.button}}
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
                donation: {
                  euro_amount: "",
                    plan_b: "",
                    user_id: "",
                    campaign_id: "",
                },
                button: "",
                value: 1,
                radioStyle: {
                    display: 'block',
                    height: '30px',
                    lineHeight: '30px',
                },
            };
        },
        methods:
            {
                showDrawer() {
                    this.visible = true;
                }
                ,
                onClose() {
                    this.visible = false;
                }
                ,
                toPickAmount(num) {
                    this.button = "€" + num;
                    this.donation.euro_amount = num;
                }
                ,
                onChange(e) {
                    console.log('radio checked', e.target.value);
                }
                ,
                toDonate() {
                    this.visible = false;
                    // axios.post
                }
                ,
            }
        ,
    }
    ;
</script>