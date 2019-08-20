Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'custom-dashboard',
            path: '/custom-dashboard/:dashboardName',
            component: require('./components/CustomDashboard'),
            props: route => {
                return {
                    dashboardName: route.params.dashboardName
                }
            }
        },
    ]);

    // Top level components
    Vue.component('custom-navigation', require('./components/CustomNavigation'));

    // Dashboards
    Vue.component('card-dashboard', require('./components/dashboards/CardDashboard'));

    // Items
    Vue.component('external-link', require('./components/items/ExternalLink'));
    Vue.component('resource-link', require('./components/items/ResourceLink'));

    // Groups
    Vue.component('collapsible-group', require('./components/groups/CollapsibleGroup'));
    Vue.component('external-link-group', require('./components/groups/ExternalLinkGroup'));
    Vue.component('route-group', require('./components/groups/RouteGroup'));
    Vue.component('dashboard-group', require('./components/groups/DashboardGroup'));
});
