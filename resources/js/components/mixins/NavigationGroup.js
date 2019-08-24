export default {
    props: {
        label: {
            default: "Navigation Item",
            types: [String]
        },
        link: {
            default: () => ([]),
            types: [Array]
        },
        items: {
            default: () => ([]),
            types: [Array]
        },
        classes: {
            default: () => ([]),
            types: [Array]
        },
        icon: {
            default: "",
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
        hasActive: {
            default: false,
            types: [Boolean]
        }
    },

    methods: {
        shouldShowLink(link) {
            return this.isExpanded && link.visible;
        },
    },

    computed: {
        isExpanded() {
            return true;
        }
    }
}