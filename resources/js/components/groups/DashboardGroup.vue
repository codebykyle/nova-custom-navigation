<template>
    <div class="mb-8">
        <div class="navigation-group">
            <router-link tag="h3" :to="linkUrl" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
                <span class="sidebar-icon mr-12pxn" v-html="icon"></span>
                <span class="sidebar-label">
                    {{ label }}
                </span>
            </router-link>
        </div>

        <ul class="list-reset mb-4 ml-32px expandable navigation-list" v-if="isExpanded">
            <li class="leading-tight text-sm navigation-item" v-for="link in links">
                <div
                    :is="link.component"
                    v-if="shouldShowLink(link)"
                    class=""
                    v-bind="link">
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import _ from 'lodash';
    import NavGroupMixin from '../mixins/NavigationGroup';
    import Redirects from '../mixins/GroupRedirects';

    export default {
        params: {

        },

        mixins: [
            NavGroupMixin,
            Redirects
        ],

        mounted() {
            //
        },

        methods: {
        },

        computed: {
            isActive() {
                return this.isGroupActive || this.isSubItemActive
            },

            isGroupActive() {
                let dashboardGroupName = _.get(this.linkUrl, 'params.dashboardName', false);
                let currentDashboardName = _.get(this.$route, 'params.dashboardName', false);

                if (currentDashboardName) {
                    return currentDashboardName === dashboardGroupName;
                }

                return false;
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
