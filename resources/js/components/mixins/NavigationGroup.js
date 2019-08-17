export default {
    props: {
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
        allowExpansion: {
            default: true,
            types: [Boolean]
        },
        alwaysExpanded: {
            default: false,
            types: [Boolean]
        },
        links: {
            default: () => ([]),
            types: [Array]
        },
    },

    methods: {
        shouldShowLink(link) {
            return this.isExpanded && link.visible;
        },
    },

    computed: {
        isExpanded() {
            return this.alwaysExpanded || this.isActive
        },

        isActive() {
            return this.isGroupActive || this.isSubItemActive;
        },

        isGroupActive() {
            return false;
        },

        isSubItemActive() {
            let currentResourceName = _.get(this.$route, 'params.resourceName', false);

            let hasActive = false;

            _.forEach(this.links, (item) => {
                let groupResourceName = _.get(item.linkUrl, 'params.resourceName', false);

                if (groupResourceName !== false) {
                    if (currentResourceName === groupResourceName) {
                        hasActive = true;
                        return false;
                    }
                }
            });

            return hasActive;
        },
    }
}