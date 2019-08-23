Nova.booting((Vue, router, store) => {
    // Top level components
    Vue.component('custom-navigation', require('./components/CustomNavigation'));

    // Items
    Vue.component('web-link', require('./components/redirects/WebLink'));
    Vue.component('route-link', require('./components/redirects/RouteLink'));
});
