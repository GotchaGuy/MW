<template>
    <div>
        <a-button type="primary" @click="showDrawer">
            <a-icon type="plus"/>
            Doniraj
        </a-button>
        <a-drawer
                title="Koliko želite da donirate?"
                :width="720"
                :visible="visible"
                :body-style="{ paddingBottom: '80px' }"
                @close="onClose"
        >
            <a-form :form="form" layout="vertical" hide-required-mark>
                <a-row :gutter="16">
                    <a-col :span="12">
                        <a-form-item label="Name">
                            <a-input
                                    v-decorator="['name',{
                    rules: [{ required: true, message: 'Please enter user name' }],
                  },]"placeholder="Please enter user name"
                            />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="Url">
                            <a-input
                                    v-decorator="[
                  'url',
                  {
                    rules: [{ required: true, message: 'please enter url' }],
                  },
                ]"
                                    style="width: 100%"
                                    addon-before="http://"
                                    addon-after=".com"
                                    placeholder="please enter url"
                            />
                        </a-form-item>
                    </a-col>
                </a-row>

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
                    Doniraj
                </a-button>
            </div>
        </a-drawer>
    </div>
</template>
<script>
    export default {
        name: 'Donate',
        data() {
            return {
                form: this.$form.createForm(this),
                visible: false,
            };
        },
        methods: {
            showDrawer() {
                this.visible = true;
            },
            onClose() {
                this.visible = false;
            },
        },
    };
</script>