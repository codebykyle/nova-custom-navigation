<template>
    <loading-view :loading="initialLoading">
        <div
            :is="dashboard.component"
            v-bind="dashboard"
            v-if="!initialLoading && dashboard">
        </div>
    </loading-view>
</template>

<script>
export default {
    props: {
        dashboardName: {
            default: null,
            types: [String]
        }
    },

    data: () => ({
        initialLoading: false,
        dashboard: null
    }),

    mounted() {
        this.initializeComponent()
    },

    methods: {
        async initializeComponent() {
            await this.getDashboard();
            this.initialLoading = false;
        },

        getDashboard() {
            return Nova.request().get('/nova-vendor/nova-custom-navigation/dashboard/' + this.dashboardName)
                .then((result) => {
                    this.dashboard = result.data;
                })
                .catch(error => {
                    if (error.response.status >= 500) {
                        Nova.$emit('error', error.response.data.message);
                        return
                    }

                    if (error.response.status === 404 && this.initialLoading) {
                        this.$router.push({name: '404'});
                        return
                    }

                    if (error.response.status === 403) {
                        this.$router.push({name: '403'});
                        return
                    }
                });
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
