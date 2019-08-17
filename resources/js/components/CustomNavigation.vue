<template>
    <div class="mb-8">
        <div class="" v-for="group in navigationGroups">
            <div
                :is="group.component"
                v-bind="group">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            navigationGroups: {
                default: () => ([]),
                types: [Array]
            }
        },

        mounted() {
            //
        },
    }
</script>

<style lang="scss" scoped>

</style>
