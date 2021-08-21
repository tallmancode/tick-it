<template>
    <page-template>
        <template v-slot:page_header>
            <page-header>
                <template v-slot:after_title>
                    <a @click="showTicketFormSlide" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-magic fa-sm text-white-50 me-2"></i>Create a new ticket</a>
                </template>
            </page-header>
        </template>
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
                <RecentTickets></RecentTickets>
            </div>
        </div>
    </page-template>
</template>

<script>
import { $vfm } from 'vue-final-modal'
import RecentTickets from "./Cards/RecentTickets";
import CreateTicketSlide from "../SupportCenter/components/slide/CreateTicketSlide";
export default {
    name: "Dashboard",
    components: { RecentTickets },
    methods: {
        showTicketFormSlide(){
            $vfm.show({component: CreateTicketSlide})
        }
    },

}
</script>

<style scoped>

</style>