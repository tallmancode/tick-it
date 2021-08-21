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
            <div class="col-xl-3 col-md-6 mb-4">
                <TicketCard></TicketCard>
            </div>
        </div>
    </page-template>
</template>

<script>
import { $vfm } from 'vue-final-modal'
import TicketSlide from "./components/slide/TicketSlide";
import TicketCard from "./components/cards/TicketCard";
export default {
    name: "SupportCenter",
    components: { TicketCard },
    methods: {
        showTicketFormSlide(){
            $vfm.show({component: TicketSlide})
        }
    },
    beforeMount() {
        this.$store.dispatch('Tickets/fetchTypes', null, { root:true })
    }
}
</script>

<style scoped>

</style>