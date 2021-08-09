<template>
    <Header></Header>
    <main>
        <router-view :key="$route.fullPath" v-slot="{ Component }">
            <transition appear mode="out-in" name="fade">
                <component :is="Component"/>
            </transition>
        </router-view>
    </main>
    <Footer></Footer>
</template>

<script>
import Header from "./components/global/header/Header";
import Footer from "./components/global/footer/Footer";
export default {
    name: "FrontendBase",
    components: { Header, Footer }
}
</script>

<style lang="scss">
.container {
    max-width: 960px;
}
.flex-equal > * {
    flex: 1;
}
@media (min-width: 768px) {
    .flex-md-equal > * {
        flex: 1;
    }
}
</style>