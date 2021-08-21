export default {
    fields: {
        type: Array,
        required: true,
    },
    filters: {
        type: Array
    },
    sort: {
        type: [Object, Boolean],
        default: false
    },
    apiUrl: {
        type: String,
        default: '',
    },
    reactiveApiUrl: {
        type: Boolean,
        default: true,
    },
    data: {
        type: [Array, Object],
        default: null,
    },
    apiMode: {
        type: Boolean,
        default: true,
    },
    eventPrefix: {
        type: String,
        default () {
            return 'vuetable:';
        },
    },
    dataPath: {
        type: String,
        default: 'data.hydra:member',
    },
    totalItemsPath: {
        type: String,
        default: 'data.hydra:totalItems',
    },
    paginationPath: {
        type: String,
        default: 'data.hydra:view',
    },
    trackBy: {
        type: String,
        default: 'id',
    },
    silent: {
        type: Boolean,
        default: false,
    },
    perPage: {
        type: Number,
        default: 10,
    },
    initialPage: {
        type: Number,
        default: 1,
    },
    firstPage: {
        type: Number,
        default: 1,
    },
    fieldPrefix: {
        type: String,
        default () {
            return 'vuetable-field-';
        },
    },
    localLoader: {
        type: Boolean,
        default: false
    }
}
