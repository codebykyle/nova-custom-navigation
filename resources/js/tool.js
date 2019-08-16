Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'nav-group-dashboard',
            path: '/group-dashboard/:codeName',
            component: require('./components/Tool'),
            props: route => {
                return {
                    codeName: route.params.codeName
                }
            }
        },
    ])
})
