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
        <ModalsContainer></ModalsContainer>
    </div>
    <GlobalLoading></GlobalLoading>
</template>

<script>
import Sidebar from "./components/global/sidebar/Sidebar";
import TopNav from "./components/global/topnav/TopNav";
import GlobalLoading from "./components/global/loading/GlobalLoading";
import { ModalsContainer } from 'vue-final-modal'
import {mapGetters} from "vuex";
import store from "../../vuex/store";

export default {
    name: "BackendBase",
    components: {Sidebar, TopNav, GlobalLoading, ModalsContainer},
    mounted() {
        store.dispatch('Auth/me', null, {root: true})
        this.$store.dispatch('Tickets/fetchTypes', null, { root:true })
        this.$store.dispatch('Tickets/fetchStatuses', null, { root:true })
    },
    computed: {
        ...mapGetters('Auth', ['hasRole'])
    }
}
</script>

<style scoped>

</style>