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
        <vue-mesa :ref="'ticket_table'"
                  :apiUrl="'/api/tickets'"
                  :fields="[
                            {name: 'title', title: 'Title', label: 'Title', sortable: true},
                            {name: 'customer.name', title: 'Customer Name', label: 'Customer Name', sortable: true},
                            {name: 'customer.surname', title: 'Customer Surname', label: 'Customer Surname', sortable: true},
                            {name:  '__slot:date', title: 'Logged At', label: 'Logged At', sortable: true, sortName: 'createdAt'},
                            {name: 'ticketStatus.name', title: 'Status', label: 'Status', sortable: true},
                            {name:  '__slot:actions', title: 'Actions', label: 'Actions'},
                        ]"
                  :sort="{property: 'createdAt', direction: 'desc'}">
            <template v-slot:date="{rowData}">
                {{ $moment(rowData.createdAt).format('DD-MM-yyyy HH:MM') }}
            </template>
            <template v-slot:actions="{rowData}">
                <a class="btn btn-primary btn-sm me-2 d-inline" @click="showTicketSlide(rowData)">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-success btn-sm me-2 d-inline" @click="showMailModal(rowData)">
                    <i class="fas fa-envelope"></i>
                </a>
            </template>
        </vue-mesa>
    </page-template>
</template>

<script>
import {$vfm} from 'vue-final-modal'
import TicketSlide from "../../SupportCenter/components/slide/TicketSlide";
import CreateTicketSlide from "../../SupportCenter/components/slide/CreateTicketSlide";
import SendMessageModal from "../../SupportCenter/components/modal/SendMessageModal";
export default {
    name: "TicketsOverview",
    methods: {
        showTicketFormSlide(){
            $vfm.show({component: CreateTicketSlide, on: {'before-close': this.closeSlide}})
        },
        showTicketSlide(ticketData) {
            $vfm.show({component: TicketSlide, bind: {ticket: ticketData}})
        },
        showMailModal(ticketData){
            $vfm.show({component: SendMessageModal, bind: {ticket: ticketData}})
        },
        closeSlide(event) {
            this.$refs.ticket_table.loadData()
        },

    },
}
</script>
<style scoped>

</style>