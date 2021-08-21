<template>
    <card>
        <template v-slot:header>
            <h6 class="m-0 font-weight-bold text-primary">Recent Tickets</h6>
        </template>
        <template v-slot:body>
            <ul class="ticket-list list-group-flush ps-0">
                <li v-for="ticket in getTickets" class="list-group-item">
                    <h6 :class="['m-0 font-weight-bold', tickStatusClass(ticket.ticketStatus)]" >{{ ticket.title }}</h6>
                    <p>{{ ticket.description }}</p>
                    <div class="row">
                        <div class="col-6">
                            Logged by: {{ ticket.user.name }} {{ ticket.user.surname }}
                        </div>
                        <div class="col-6">
                            Date Logged: {{ ticket.createdAt }}
                        </div>
                    </div>
                </li>
            </ul>
        </template>
        <template v-slot:footer>
            <router-link :to="{name: 'TicketsOverview'}">
                View all tickets
            </router-link>
        </template>
    </card>
</template>

<script>

import {mapGetters} from "vuex";

export default {
    name: "RecentTickets",
    methods: {
        tickStatusClass(status){
            switch(status) {
                case 'in progress': return 'text-primary'
                case 'resolved': return 'text-success'
                default: return 'text-danger'
            }
        }
    },
    computed: {
        ...mapGetters('Tickets', ['getTickets']),
    }
}
</script>

<style lang="scss" scoped>
.ticket-list {
    .list-group-item {

    }
}
</style>