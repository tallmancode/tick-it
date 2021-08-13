<template>
    <div class="container-fluid">
        <slot name="page_header">
            <PageHeader></PageHeader>
        </slot>
        <slot></slot>
    </div>
</template>

<script>
import PageHeader from "./PageHeader";
export default {
    name: "PageTemplate",
    components: { PageHeader }
}
</script>
