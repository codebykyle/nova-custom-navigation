export default {
    props: {
        label: {
            default: "",
            types: [String]
        },
        linkUrl: {
            default: null,
            types: [String]
        },
        target: {
            default: '_blank',
            types: [String]
        },
        visible: {
            default: true,
            types: [Boolean]
        }
    }
}