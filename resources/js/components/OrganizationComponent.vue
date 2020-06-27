<template>
    <div>
        organization stuff
        <p>
        {{organization.title}}
        </p>
    </div>
</template>


<script>
    export default {
        props: ["dataOrg"],
        data() {
            return {
                organization: JSON.parse(this.dataOrg),
            }
        },
        mounted() {

        },
        methods: {}

    }
</script>