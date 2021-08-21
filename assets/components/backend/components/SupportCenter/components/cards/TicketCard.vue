<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Tickets</h6>
        </div>
        <div class="card-body">
            <ul>
                <li v-for="ticket in getTickets">
                    {{ticket.title}}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TicketCard",
    beforeMount() {
        if(this.getTickets.length === 0){
            this.$store.dispatch('Tickets/fetchTickets', null, { root: true })
        }
    },
    computed: {
        ...mapGetters('Tickets', ['getTickets'])
    }
}
</script>

<style scoped>

</style>