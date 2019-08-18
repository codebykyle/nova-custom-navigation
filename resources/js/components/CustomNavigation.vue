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
    import _ from 'lodash';

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

        methods: {
            resourceLink(resource) {
                return resource.link;
            },

            shouldShowResource(resource) {
                return this.isExpanded && resource.isVisible
            },
        },

        computed: {
            isLink() {
                return this.linkType === 'link';
            },

            isRoute() {
                return this.linkType === 'route';
            },

            isExpanded() {
                return this.alwaysExpanded || this.isActive
            },

            groupLink() {
                return this.route;
            },

            isActive() {
                console.log(this.$route);

                const resourceName = _.get(this.$route, 'params.resourceName', false);
                const categoryDashboard = _.get(this.$route, 'params.categoryName', false);

                if(resourceName) {
                    return _.map(this.resources, 'uriKey').includes(resourceName)
                }

                if (categoryDashboard) {
                    return categoryDashboard === this.dashboardUri;
                }

                return false;
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
