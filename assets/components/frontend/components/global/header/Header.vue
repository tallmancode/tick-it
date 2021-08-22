<template>
    <header class="site-header sticky-top py-1">
        <nav class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <a class="py-2 brand" href="#" aria-label="Tick IT">
                <img :src="require('/assets/media/logo/tick-it-logo.svg')" alt="Tick-It Logo">
            </a>
            <div class="nav-links">
                <router-link class="py-2 px-2 d-none d-md-inline-block" :to="{ name: 'Home'}">Home</router-link>
                <router-link class="py-2 px-2 d-none d-md-inline-block" :to="{ name: 'ComplexQueries'}">Complex Queries</router-link>
                <router-link class="py-2 px-2 d-none d-md-inline-block" :to="{ name: 'Login'}">Login</router-link>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style scoped lang="scss">
.site-header {
    background-color: rgba(0, 0, 0, .85);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    backdrop-filter: saturate(180%) blur(20px);
    a {
        color: #8e8e8e;
        transition: color .15s ease-in-out;
        text-decoration: none;
        &:hover {
            color: #fff;
            text-decoration: none;
        }
    }
    .brand{
        img{
            height: 30px;
            width: 100%;
        }
    }
}
</style>