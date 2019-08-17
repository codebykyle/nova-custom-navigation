<template>
    <a
        :href="linkUrl"
        :target="target"
        class="cursor-pointer select-none flex items-center font-normal dim text-white mb-3 text-base no-underline">
        <span class="resource-label">
            {{ label }}
        </span>
    </a>
</template>

<script>
    import LinkItem from '../mixins/LinkItem'

    export default {
        name: "external-link",
        mixins: [LinkItem]
    }
</script>

<style scoped>

</style>