<template>
    <div class="vue-table__header">
        <div class="vue-table__filterToggle">
            <a @click="toggleFilters">
                <i class="bi bi-filter-right"></i>
                Filters
            </a>
        </div>
        <div class="vue-table__filterCollapse  mb-4">
            <div class="inner">
                <slot :fields="tableFilters" name="tableFilters">
                    <form action="">
                        <div class="row vue-table__filters">
                            <template :key="filter.field" v-for="filter in tableFilters">
                                <div class="form-group standard-input" v-bind:class="filter.class">
                                    <label :for="filter.field">{{ filter.label }}</label>
                                    <input :id="filter.field" type="text" v-model="filter.value" class="form-control">
                                </div>
                            </template>
                        </div>
                        <div class="vue-table__filter-actions">
                            <button @click="resetFilter" type="button" class="btn btn__primary">Reset Filters</button>
                            <button @click="updateFilters" type="button" class="btn btn__light">Filter</button>
                        </div>
                    </form>

                </slot>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "VueTableFilters",
    props: {
        filterOptions: {
            type: [Object, Array],
            default: null,
        },
    },
    data() {
        return {
            eventPrefix: 'vuetable-filters:',
            tableFilters: [],
        }
    },
    mounted() {
        this.loadFilters()
    },
    methods: {
        toggleFilters(event) {
            const toggleButton = event.currentTarget;
            const wrapper = document.querySelector('.vue-table__header .vue-table__filterCollapse');
            const inner = document.querySelector('.vue-table__header .vue-table__filterCollapse .inner');

            const isActive = wrapper.classList.contains('visible');

            if (!isActive) {
                wrapper.classList.add('visible');
                const height = inner.offsetHeight;
                wrapper.style.maxHeight = height + 'px'
            } else {
                wrapper.classList.remove('visible');
                wrapper.style.maxHeight = '0px'
            }
        },
        loadFilters() {
            const value = {value: ''}
            this.tableFilters = this.filterOptions.map(filter => { return {...filter, ...value}})
        },
        updateFilters() {
            this.$emit(this.eventPrefix + 'change-filter', this.tableFilters)
        },
        resetFilter() {
            this.loadFilters()
            this.$emit(this.eventPrefix + 'change-filter', this.tableFilters)

        }
    }
};
</script>
