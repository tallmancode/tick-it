<template>
    <div class="table-responsive vue-mesa">
        <VueTableFilters v-if="filters"
                         :filterOptions="filters"
                         @vuetable-filters:change-filter="changeFilter">
        </VueTableFilters>
        <div class="table-header-row" v-if="this.$slots.headerRow">
            <slot name="headerRow"></slot>
        </div>

        <table ref="vuetable" class="table">
            <thead>
            <slot :fields="tableFields" name="tableHeader">
                <tr>
                    <template v-for="field in tableFields" :key="field.name">
                        <th :class="[{'sorting' : field.sortable, 'asc' : sorting.property === field.sortName && sorting.direction === 'asc', 'desc' : sorting.property === field.sortName && sorting.direction === 'desc'}]"
                            @click="(field.sortable ? changeSort(field) : '')">
                            {{ field.title }}
                        </th>
                    </template>
                </tr>
            </slot>
            </thead>
            <tbody>
            <template v-for="(item, itemIndex) in tableData" :key="itemIndex">
                <tr :item-index="itemIndex">
                    <template v-for="(field, fieldIndex) in tableFields" :key="fieldIndex">
                        <template v-if="isFieldComponent(field.name)">
                            <td>
                                <component :is="field.name"
                                           :row-data="item"
                                           :row-field="field" :row-index="itemIndex" :style="{width: field.width}"
                                           :vuetable="vuetable"
                                           @vuetable:field-event="onFieldEvent"
                                />
                            </td>
                        </template>
                        <template v-else-if="isFieldSlot(field.name)">
                            <td :key="fieldIndex">
                                <slot :name="getSpecialFieldName(field.name)"
                                      :rowData="item" :rowField="field" :rowIndex="itemIndex"
                                />
                            </td>
                        </template>
                        <template v-else>
                            <td v-html="$vueMesa.objValue(item, field.name)"/>
                        </template>
                    </template>
                </tr>
            </template>
            </tbody>
        </table>
        <VueTablePagination :first-page="firstPage"
                            :perPage="perPage"
                            :tablePagination="tablePagination"
                            :totalItems="totalItems"
                            @vuetable-pagination:change-page="changePage"/>
        <div class="vue-table__loader">

        </div>
    </div>
</template>

<script>
import PropsApi from './js/propsApi';
import VueTablePagination from "./VueTablePagination";
import VueTableFilters from "./VueTableFilters";
import qs from 'qs'
export default {
    name: "VueTable",
    components: {
        VueTablePagination,
        VueTableFilters,
    },
    props: PropsApi,
    data() {
        return {
            tableData: null,
            tableFields: [],
            appendParams: {},
            tablePagination: null,
            currentPage: this.initialPage,
            totalItems: 0,
            sorting: false
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        changePage(page) {
            this.currentPage = page;
            this.loadData();
        },
        changeSort(field) {

            let propertyName = ''
            if(field.sortName){
                propertyName = field.sortName
            }else{
                propertyName= field.name
            }

            if(this.sorting.property === propertyName){
               this.sorting.direction = this.sorting.direction === 'asc' ? 'desc' : 'asc'
            }

            this.sorting.property = propertyName


            this.loadData();

        },
        changeFilter(filterArray) {
            this.appendParams = {};
            for (const filter of filterArray) {
                if (filter.value) {
                    this.appendParams[filter.field] = filter.value
                }
            }
            this.loadData();
        },
        isFieldComponent(fieldName) {
            if (fieldName instanceof Object) {
                return true;
            }
            const parts = fieldName.split(":");
            return parts[0] === '__component';
        },
        isFieldSlot: function (fieldName) {
            const parts = fieldName.split(":");
            return parts[0] === '__slot'
        },
        loadData() {
            if (this.isDataMode) {
                return;
            }
            this.fireEvent('loading');

            if (this.apiUrl === '') return;
            this.tableFields = this.$vueMesa.normalizeFields(this.fields);

            let params = {itemsPerPage: this.perPage};

            let appendedParams = this.appendParams

            params = {...params, ...appendedParams}

            if (!this.sorting) {
                this.sorting = this.sort
            }

            if (this.sorting) {
                params.order = {
                    [this.sorting.property] : this.sorting.direction
                }
            }

            if (this.currentPage > 1) {
                params.page = this.currentPage;
            }

            return axios.get(this.apiUrl, {
                params: params,
                showLoader: !this.localLoader,
                paramsSerializer: params => {
                    return qs.stringify(params, {arrayFormat: 'brackets'})
                }
            })
                .then((resp) => {
                    this.handleSuccess(resp);
                }).catch((err) => {
                    this.handleFailed(err.response);
                });
        },
        getSpecialFieldName(fieldName) {
            return fieldName.split(':')[1]
        },
        handleSuccess(resp) {
            this.fireEvent('load-success', resp);
            this.tableData = this.$vueMesa.objValue(resp, this.dataPath);
            this.totalItems = this.$vueMesa.objValue(resp, this.totalItemsPath);


            this.tablePagination = this.$vueMesa.objValue(resp, this.paginationPath);

            this.$nextTick(() => {
                this.checkIfRowIdentifierExists();
                // this.updateHeader()
                //this.fireEvent('pagination-data', this.tablePagination)
                this.fireEvent('loaded');
            });

        },
        checkIfRowIdentifierExists() {
            if (!this.dataIsAvailable) return;
            if (!this.hasRowIdentifier) {
                this.warn('You seem to be missing a identifier on your rows. Default identifier is the id property');
                return false;
            }
            return true;
        },
        handleFailed(response) {
            this.fireEvent('load-error', response);
            this.fireEvent('loaded');
        },
        onFieldEvent(payload) {
            this.fireEvent(payload.action, payload.data, this);
        },
        fireEvent() {
            if (arguments.length === 1) {
                //console.log(this.eventPrefix + arguments[0])
                return this.$emit(this.eventPrefix + arguments[0]);
            }
            if (arguments.length > 1) {
                let args = Array.from(arguments);
                args[0] = this.eventPrefix + args[0];
                //console.log(this.eventPrefix + arguments[0], args)
                return this.$emit(this.eventPrefix + arguments[0], args);
            }
        },
        refresh() {
            this.currentPage = this.firstPage;
            return this.loadData();
        },
        // objValue: function (obj, is) {
        //     let parts = is.split('.');
        //     let newObj = obj[parts[0]];
        //     if (parts[1]) {
        //         parts.splice(0, 1);
        //         let newString = parts.join('.');
        //         return this.objValue(newObj, newString);
        //     }
        //     return newObj;
        // },
        warn(msg) {
            if (!this.silent) {
                console.warn(msg);
            }
        },
        arrayParams(params){
            const keys = Object.keys(params);
            let options = '';

            keys.forEach((key) => {
                const isParamTypeObject = typeof params[key] === 'object';
                const isParamTypeArray = isParamTypeObject && (params[key].length >= 0);

                if (!isParamTypeObject) {
                    options += `${key}=${params[key]}&`;
                }

                if (isParamTypeObject && isParamTypeArray) {
                    params[key].forEach((element) => {
                        options += `${key}=${element}&`;
                    });
                }
            });

            return options ? options.slice(0, -1) : options;
        }

    },
    computed: {
        isApiMode() {
            return this.apiMode;
        },
        isDataMode() {
            return !this.apiMode;
        },
        dataIsAvailable() {
            if (!this.tableData) return false;
            return this.tableData.length > 0;
        },
        hasRowIdentifier() {
            return this.tableData && typeof (this.tableData[0][this.trackBy]) !== 'undefined';
        },
        vuetable() {
            return this;
        },

    },
    watch: {
        apiUrl(newVal, oldVal) {
            if (this.reactiveApiUrl && newVal !== oldVal)
                this.refresh();
        },
    },

};
</script>

