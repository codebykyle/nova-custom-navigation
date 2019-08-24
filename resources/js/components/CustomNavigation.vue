<template>
    <div class="mb-8">
        <div class="" v-for="group in navigation">
            <div
                :is="group.component"
                v-bind="group">
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';

    const RESOURCE = 'RESOURCE';
    const DASHBOARD = 'DASHBOARD';
    const LENS = 'LENS';
    const TOOL = 'TOOL';


    export default {
        props: {
            navigation: {
                default: () => ([]),
                types: [Array]
            }
        },

        data: () => ({
            activeNavigation: null
        }),

        created() {
            this.$watch('$route', () => {
                this.setActiveNavGroup();
            })
        },

        mounted() {

        },

        methods: {
            setActiveNavGroup() {
                let linkMatches = this.$route.matched;
                let activeLinkType = this.activeLinkType;

                console.log('Active link type', activeLinkType);
                console.log('link matches', linkMatches);

                let activeNavGroup = _.find(this.navigation, function (navigationGroup) {
                    let groupRoute = _.get(navigationGroup, 'link.route');

                    console.log('Group routes', groupRoute);

                    let subItems = _.map(_.get(navigationGroup, 'items', []), function (item) {
                        return _.get(item, 'link')
                    });

                    console.log('Sub routes', subItems);

                    let linksRoutes = [groupRoute, ...subItems].filter(function (e) {
                        return e != null
                    });

                    console.log('Link routes', linksRoutes);

                    for (let linkItem in linksRoutes) {
                        if (linkItem.name in linkMatches) {
                            return true
                        }
                    }

                    return false;
                });

                this.activeNavigation = activeNavGroup;
            }

        },

        computed: {
            activeLinkType() {
                switch (this.$route.name) {
                    case 'index':
                    case 'detail':
                    case 'create':
                    case 'edit':
                        return RESOURCE;
                    case 'dashboard.custom':
                    case 'dashboard':
                        return DASHBOARD;
                    case 'lens':
                        return LENS;
                    default:
                        return TOOL
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
