Nova.booting((Vue, router, store) => {
    // Top level components
    Vue.component('custom-navigation', require('./components/CustomNavigation'));

    // Groups
    Vue.component('collapsible-group', require('./components/groups/CollapsibleGroup'));

    // Links
    Vue.component('empty-link', require('./components/links/EmptyLink'));
    Vue.component('resource-link', require('./components/links/ResourceLink'));
    Vue.component('web-link', require('./components/links/WebLink'));

    // Redirects
    Vue.component('web-redirect', require('./components/redirects/WebRedirect'));
    Vue.component('route-redirect', require('./components/redirects/RouteRedirect'));
});
