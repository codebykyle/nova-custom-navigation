<template>
    <a href="#" @click.prevent="" :target="link.target" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
        <span class="sidebar-icon mr-12pxn" v-html="icon"></span>
        <span class="sidebar-label">
            {{ label }}
        </span>
    </a>
</template>

<script>
    import NavGroupMixin from '../mixins/NavigationGroup'

    export default {
        name: "LinkGroup",
        mixins: [NavGroupMixin]
    }
</script>

<style scoped>

</style>