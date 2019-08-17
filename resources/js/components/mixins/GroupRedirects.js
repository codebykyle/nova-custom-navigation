export default {
    props: {
        linkType: {
            default: 'link',
            types: [String]
        },
        linkUrl: {
            default: () => ({}),
            types: [String, Object]
        },
    },

    methods: {
        shouldShowLink(link) {
            return this.isExpanded && link.visible;
        },
    },

    computed: {
        isGroupActive() {
            let groupResourceName = _.get(this.linkUrl, 'params.resourceName', false);
            let currentResourceName = _.get(this.$route, 'params.resourceName', false);

            if(groupResourceName) {
                if (currentResourceName === groupResourceName) {
                    return true;
                }
            }

            return false;
        },
    }
}