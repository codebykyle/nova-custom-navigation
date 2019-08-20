Nova.booting((Vue, router, store) => {
    // Top level components
    Vue.component('custom-navigation', require('./components/CustomNavigation'));

    // Items
    Vue.component('external-link', require('./components/items/ExternalLink'));
    Vue.component('resource-link', require('./components/items/ResourceLink'));

    // Groups
    Vue.component('dashboard-group', require('./components/groups/DashboardGroup'));
    Vue.component('collapsible-group', require('./components/groups/CollapsibleGroup'));
    Vue.component('external-link-group', require('./components/groups/ExternalLinkGroup'));
    Vue.component('route-group', require('./components/groups/RouteGroup'));
});
