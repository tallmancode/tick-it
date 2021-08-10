<template>
    <footer class="container py-5">
        <div class="row">
            <div class="col-12 col-md footer-brand">
                <img :src="require('/assets/media/logo/tick-it-logo-blue.svg')" alt="Tick-It Logo">
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary" href="#">Cool stuff</a></li>
                    <li><a class="link-secondary" href="#">Random feature</a></li>
                    <li><a class="link-secondary" href="#">Team feature</a></li>
                    <li><a class="link-secondary" href="#">Stuff for developers</a></li>
                    <li><a class="link-secondary" href="#">Another one</a></li>
                    <li><a class="link-secondary" href="#">Last time</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary" href="#">Resource name</a></li>
                    <li><a class="link-secondary" href="#">Resource</a></li>
                    <li><a class="link-secondary" href="#">Another resource</a></li>
                    <li><a class="link-secondary" href="#">Final resource</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary" href="#">Business</a></li>
                    <li><a class="link-secondary" href="#">Education</a></li>
                    <li><a class="link-secondary" href="#">Government</a></li>
                    <li><a class="link-secondary" href="#">Gaming</a></li>
                </ul>
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