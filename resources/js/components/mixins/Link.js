export default {
    props: {
        label: {
            default: "",
            types: [String]
        },
        link: {
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