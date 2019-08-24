<template>
    <a
        :href="link"
        :target="target"
        class="cursor-pointer select-none flex items-center font-normal dim text-white mb-3 text-base no-underline">
        <span class="resource-label">
            {{ label }}
        </span>
    </a>
</template>

<script>
    import Link from '../mixins/Link'

    export default {
        name: "external-link",
        mixins: [Link]
    }
</script>

<style scoped>

</style>