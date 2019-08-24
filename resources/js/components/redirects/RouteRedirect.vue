<template>
    <router-link
        :to="link"
        v-if="visible"
        class="cursor-pointer select-none flex items-center font-normal dim text-white mb-3 text-base no-underline"  >
            <span class="resource-label">
                {{ label }}
            </span>
    </router-link>
</template>

<script>
    import Link from '../mixins/Link'

    export default {
        name: "resource-link",
        mixins: [Link]
    }
</script>

<style scoped>

</style>