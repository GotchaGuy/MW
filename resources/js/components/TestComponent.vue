<template>
    <div>
 <p class="top" v-for=""    >{{ username }}</p>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                username: "Edi",
                color: "green",
                user: {
                    stavku1: "",
                    stavku2: "",
                    stavku3: "",
                    stavku4: "",
                }

            }
        },
        mounted() {

        },
        methods: {

        }

    }
</script>