<template>
    <div class="container-fluid">
        <slot name="page_header">
            <page-header></page-header>
        </slot>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "PageTemplate",
}
</script>
