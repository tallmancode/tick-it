<template>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <slot name="page_title">
            <h1 class="h3 mb-0 text-gray-800">{{pageTitle}}</h1>
        </slot>
        <slot name="after_title">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </slot>
    </div>
</template>

<script>
export default {
    name: "PageHeader",
    props:  {
        title: null
    },
    computed: {
        pageTitle(){
            return this.$route.meta.title
        }
    }
}
</script>

<style scoped>

</style>