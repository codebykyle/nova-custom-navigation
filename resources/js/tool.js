Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'category-dashboard',
            path: '/category-dashboard/:categoryName',
            component: require('./components/Tool'),
            props: route => {
                return {
                    categoryName: route.params.categoryName
                }
            }
        },
    ]);

    Vue.component('custom-navigation', require('./components/CustomNavigation'));

    // Items
    Vue.component('external-link', require('./components/items/ExternalLink'));
    Vue.component('resource-link', require('./components/items/ResourceLink'));

    // Groups
    Vue.component('collapsible-group', require('./components/groups/CollapsibleGroup'));
    Vue.component('external-link-group', require('./components/groups/ExternalLinkGroup'));
    Vue.component('route-group', require('./components/groups/RouteGroup'))
});
