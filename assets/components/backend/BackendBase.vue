<template>
    <Sidebar v-if="hasRole('ROLE_SUPPORT')"></Sidebar>
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <TopNav></TopNav>
            <!-- Begin Page Content -->
            <router-view v-slot="{ Component }">
                <transition mode="out-in" name="fade">
                    <component :is="Component"/>
                </transition>
            </router-view>
        </div>
        <!-- End of Main Content -->
    </div>
    <GlobalLoading></GlobalLoading>
</template>

<script>
import Sidebar from "./components/global/sidebar/Sidebar";
import TopNav from "./components/global/topnav/TopNav";
import GlobalLoading from "./components/global/loading/GlobalLoading";
import {mapGetters} from "vuex";

export default {
    name: "BackendBase",
    components: {Sidebar, TopNav, GlobalLoading},
    computed: {
        ...mapGetters('Auth', ['hasRole'])
    }
}
</script>

<style scoped>

</style>