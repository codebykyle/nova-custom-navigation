<template>
    <div class="mb-8">
        <div class="" v-if="isLink">
            <a :href="link.href" :target="link.target" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
                <span class="sidebar-icon mr-12pxn" v-html="icon"></span>
                <span class="sidebar-label">
                    {{ label }}
                </span>
            </a>
        </div>
        <div class="" v-if="isRoute">
            <router-link tag="h3" :to="groupLink" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
                <span class="sidebar-icon mr-12pxn" v-html="icon"></span>
                <span class="sidebar-label">
                    {{ label }}
                </span>
            </router-link>
        </div>


            <ul class="list-reset mb-4 ml-32px expandable" v-if="isExpanded">
                <li class="leading-tight text-sm" v-for="resource in resources">
                    <router-link
                        :to="resourceLink(resource)"
                        v-if="shouldShowResource(resource)"
                        class="cursor-pointer select-none flex items-center font-normal dim text-white mb-3 text-base no-underline"  >
                        <span class="resource-label">
                            {{ resource.label }}
                        </span>
                    </router-link>
                </li>
            </ul>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        resources: {
            default: () => ([]),
            types: [Array]
        },
        classes: {
            default: () => ([]),
            types: [Array]
        },
        icon: {
            default: "",
            types: [String]
        },
        label: {
            default: "Navigation Item",
            types: [String]
        },
        route: {
            default: () => ({}),
            types: [Object]
        },
        link: {
            default: "/",
            types: [String]
        },
        linkType: {
            default: "route",
            types: [String]
        },
        dashboardUri: {
            default: null,
            types: [String]
        },
        alwaysExpanded: {
            default: false,
            types: [Boolean]
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
