<template>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <img :src="require('/assets/media/logo/tick-it-logo-backend.svg')" alt="tick-it logo">
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <router-link :to="{name: 'Dashboard'}" class="nav-link">
                <i class="fas fa-user"></i>
                <span>Dashboard</span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Tickets
        </div>

        <li class="nav-item">
            <router-link :to="{name: 'TicketsOverview'}" class="nav-link">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Tickets Overview</span>
            </router-link>>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Logout</span></a>
        </li>
    </ul>
    <!-- End of Sidebar -->
</template>

<script>
import SidebarNotification from "./components/SidebarNotification";
export default {
    name: "Sidebar",
    components: {SidebarNotification}
}
</script>

<style scoped lang="scss">

</style>