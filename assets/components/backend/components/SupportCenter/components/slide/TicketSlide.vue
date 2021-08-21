<template>
    <SlideModal>
        <template v-slot:title>Ticket:# {{$attrs.ticket.id}} - {{$attrs.ticket.title}}</template>
        <template v-slot:content>
            <div class="row mb-4">
                <div class="small text-grey-500">Customer</div>
                <div class="col-6">
                    Name: {{ $attrs.ticket.customer.name }}
                </div>
                <div class="col-6">
                    Surname: {{ $attrs.ticket.customer.surname }}
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <div class="small text-grey-500">Ticket logged by {{ $attrs.ticket.user.name }} {{ $attrs.ticket.user.surname }}</div>
                </div>
                <div class="col-6">
                    <div class="small text-grey-500">Ticket logged at {{ $moment($attrs.ticket.createdAt).format('DD-MM-yyyy HH:MM') }}</div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 mb-4">
                    <div class="small text-grey-500">
                        Ticket Status
                        <span :class="['badge rounded-pill me-4', tickStatusClass($attrs.ticket.ticketStatus)]">
                            {{$attrs.ticket.ticketStatus.name}}</span>
                        <a class="btn btn-primary btn-sm" @click="showEdit = true" v-if="!showEdit">Change Status</a>
                    </div>
                </div>
                <div class="col-12 mb-4" v-if="showEdit">
                    <form>
                        <div class="form-group row">
                            <div class="col-6">
                                <multi-select
                                    id="ticket-type"
                                    v-model="status"
                                    :label="'name'"
                                    :mode="'single'"
                                    :options="getStatuses"
                                    :valueProp="'@id'"
                                    :canDeselect = false
                                    :canClear = false
                                />
                            </div>
                            <div class="col-6">
                                <button class="d-none d-sm-inline-block btn btn-mds btn-primary shadow-sm" type="submit"
                                        @click.prevent="updateStatus()">Update Status
                                </button>
                                <a class="btn btn-danger ms-4" @click="showEdit = false">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </SlideModal>
</template>

<script>
import SlideModal from "../../../global/page/SlideModal";

import {mapGetters, mapActions} from "vuex";

export default {
    name: "TicketSlide",
    components: {
        SlideModal
    },
    data() {
        return {
            errors: false,
            formLoading: false,
            showEdit: false,
            status: null
        }
    },
    mounted() {
        this.status = this.getStatuses.find(type => type.name === this.$attrs.ticket.ticketStatus.name)['@id']
    },
    methods: {
        tickStatusClass(status){
            switch(status) {
                case 'in progress': return 'bg-primary'
                case 'resolved': return 'bg-success'
                default: return 'bg-danger'
            }
        },
        updateStatus() {
            axios({ method: 'patch',
                url: this.$attrs.ticket['@id'],
                data: {ticketStatus: this.status},
                showLoader: false,
                headers: {
                    'Content-Type': 'application/merge-patch+json'
                }
            }).then((resp) => {
                this.$attrs.ticket.ticketStatus = this.getStatuses.find(type => type['@id'] === this.status)
            })
        },
        handleApiError(err){
            if (err.data.violations && err.status === 422) {
                let errObj = {};
                err.data.violations.forEach((error) => {
                    errObj[error.propertyPath] = error.message;
                });
                this.errors = errObj;
            }
        }
    },
    computed: {
        ...mapGetters('Tickets', [
            'getTypes', 'getStatuses'
        ])
    }
}
</script>

<style scoped>

</style>