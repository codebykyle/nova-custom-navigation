<template>
    <router-link :to="link.route" class="text-white text-justify no-underline dim">
        {{ label }}
    </router-link>
</template>

<script>
    import LinkMixin from '../mixins/Link'

    export default {
        name: "resource-link",

        mixins: [LinkMixin],

        calculated: {
        }
    }
</script>

<style scoped>

</style>