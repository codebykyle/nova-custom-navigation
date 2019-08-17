<template>
    <router-link
        :to="linkUrl"
        v-if="visible"
        class="cursor-pointer select-none flex items-center font-normal dim text-white mb-3 text-base no-underline"  >
            <span class="resource-label">
                {{ label }}
            </span>
    </router-link>
</template>

<script>
    import LinkItem from '../mixins/LinkItem'
    export default {
        name: "resource-link",
        mixins: [LinkItem]
    }
</script>

<style scoped>

</style>