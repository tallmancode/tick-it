<template>
    <ul v-show="lastPage > firstPage && tablePagination" class="vue-table__pagination">
        <li>
            <a @click="loadPage(firstPage)" v-bind:class="{disabled: currentPage === 1}">
                <span >First</span>
            </a>
        </li>
        <li>
            <a @click="loadPage('prev')" v-bind:class="{disabled: currentPage === 1}">
                <span>Prev</span>
            </a>
        </li>
        <li v-for="(n, i) in totalPages" >
            <a @click="loadPage(i+firstPage)" :key="i" v-html="n" v-bind:class="{active: n === currentPage}">

            </a>
        </li>
        <li>
            <a @click="loadPage('next')" v-bind:class="{disabled: currentPage === lastPage}">
                <span>Next</span>
            </a>
        </li>
        <li>
            <a @click="loadPage(lastPage)" v-bind:class="{disabled: currentPage === lastPage}">
                <span>Last</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "VueTablePagination",
        props: {
            firstPage: {
                type: Number,
                default: 1,
            },
            totalItems: {
                type: Number,
                default: 0,
            },
            tablePagination: {
                type: [Object, Array],
                default: null,
            },
            perPage: {
                type: Number,
                default: 10,
            },

        },
        data() {
            return{
                lastPage : 0,
                eventPrefix: 'vuetable-pagination:',
                currentPage: 1,
            }
        },
        mounted() {


        },
        methods: {
            loadPage (page) {

                if(this.currentPage === page) return
                if(page === 'next' && this.currentPage !== this.lastPage){
                    page = this.currentPage + 1

                }else if(page === 'prev' && this.currentPage !== 1) {
                    page = this.currentPage - 1
                }
                this.currentPage = page;
                this.$emit(this.eventPrefix + 'change-page', page)
            },
        },
        watch: {
            totalItems (newVal, oldVal) {

            },
        },
        computed: {
            totalPages(){
                let pageCount =  this.totalItems / this.perPage;
                if(pageCount < 1) return
                this.lastPage = Math.ceil(pageCount)

                return this.lastPage;
            }
        }
    };
</script>
<style scoped lang="scss">

</style>
