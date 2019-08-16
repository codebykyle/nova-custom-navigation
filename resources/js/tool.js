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

    Vue.component('navigation-group', require('./components/NavigationGroup'));
});
