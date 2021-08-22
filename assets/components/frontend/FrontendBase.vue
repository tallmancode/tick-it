<template>
    <Header></Header>
    <main>
        <router-view :key="$route.fullPath" v-slot="{ Component }">
            <transition appear mode="out-in" name="fade">
                <component :is="Component"/>
            </transition>
        </router-view>
        <LoadingDots v-if="loading"></LoadingDots>
    </main>
    <Footer></Footer>
</template>

<script>
import Header from "./components/global/header/Header";
import Footer from "./components/global/footer/Footer";
import LoadingDots from "./components/global/loading-indicators/dots/LoadingDots";
import { mapState } from "vuex";
export default {
    name: "FrontendBase",
    components: { Header, Footer, LoadingDots },
    computed: {
        ...mapState('Loader', ['loading'])
    }
}
</script>

<style lang="scss">
.container {
    max-width: 960px;
}
main{
    min-height: calc(100vh - (55px + 325px));
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    position: relative;
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