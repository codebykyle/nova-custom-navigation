<template>
    <a href="#" @click.prevent="clicked" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
        <span class="sidebar-icon mr-12pxn" v-html="icon"></span>

        <span class="sidebar-label">
            {{ label }}
        </span>
    </a>
</template>

<script>
    import LinkMixin from '../mixins/Link'

    export default {
        name: "EmptyLink",

        mixins: [LinkMixin],

        methods: {
            clicked() {

            }
        }
    }
</script>

<style scoped>

</style>