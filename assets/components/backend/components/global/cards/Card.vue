<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3" v-if="$slots.header">
            <slot name="header">
                <h6 class="m-0 font-weight-bold text-primary">Recent Tickets</h6>
            </slot>
        </div>
        <div class="card-body">
            <slot name="body">

            </slot>

        </div>
        <div class="card-footer">
            <slot name="footer">

            </slot>

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