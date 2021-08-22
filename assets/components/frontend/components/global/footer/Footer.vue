<template>
    <footer class="container py-5">
        <div class="row">
            <div class="col-12 col-md footer-brand">
                <img :src="require('/assets/media/logo/tick-it-logo-blue.svg')" alt="Tick-It Logo">
            </div>
            <div class="col-12 text-center">
                <small class="d-block mb-3 text-muted">&copy;TallmanCode 2021</small>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped lang="scss">
@import "assets/scss/variables";
footer{
    border-top: 1px solid $grey-border-color;
}
.footer{
    &-brand{
        max-width: 150px;
    }
}
</style>