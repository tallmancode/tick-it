<template>
    <SlideModal ref="slideModal">
        <template v-slot:title>Create a new ticket</template>
        <template v-slot:content>
            <form>
                <div class="form-group">
                    <label for="title">Subject</label>
                    <input id="title" v-model="formData.title" class="form-control form-control-user"
                           placeholder="Enter a title for your ticket" type="text"
                           v-bind:class="{'is-invalid' : errors.title}">
                    <span v-if="errors.title" class="text-danger">
                        {{ errors.title }}
                    </span>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="name">Customer First Name:</label>
                        <input id="name" v-model="formData.customer.name" class="form-control form-control-user"
                               placeholder="Enter a title for your ticket" type="text"
                               v-bind:class="{'is-invalid' : errors.title}">
                        <span v-if="errors.title" class="text-danger">
                            {{ errors.title }}
                        </span>
                    </div>
                    <div class="col-6">
                        <label for="surname">Customer Last Name:</label>
                        <input id="surname" v-model="formData.customer.surname"
                               class="form-control form-control-user" placeholder="Enter a title for your ticket"
                               type="text"
                               v-bind:class="{'is-invalid' : errors.title}">
                        <span v-if="errors.title" class="text-danger">
                            {{ errors.title }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Customer Email</label>
                    <input id="email" v-model="formData.customer.email" class="form-control form-control-user"
                           placeholder="Enter a title for your ticket" type="text"
                           v-bind:class="{'is-invalid' : errors.customer}">
                    <span v-if="errors.customer" class="text-danger">
                        {{ errors.customer.email }}
                    </span>
                </div>
                <div class="form-group">
                    <label for="ticket-type">Ticket Type</label>
                    <multi-select
                        id="ticket-type"
                        v-model="formData.ticketType"
                        :canClear=false
                        :canDeselect=false
                        :label="'name'"
                        :mode="'single'"
                        :options="getTypes"
                        :valueProp="'@id'"
                    />
                </div>
                <div class="form-group">
                    <label for="ticket-status">Ticket Status</label>
                    <multi-select
                        id="ticket-type"
                        v-model="formData.ticketStatus"
                        :canClear=false
                        :canDeselect=false
                        :label="'name'"
                        :mode="'single'"
                        :options="getStatuses"
                        :valueProp="'@id'"
                    />
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" v-model="formData.description"
                              class="form-control form-control-user" placeholder="Enter a message for your ticket"
                              v-bind:class="{'is-invalid' : errors.description}"></textarea>
                    <span v-if="errors.description" class="text-danger">
                        {{ errors.description }}
                    </span>
                </div>
                <div class="form-group">
                    <button class="d-none d-sm-inline-block btn btn-mds btn-primary shadow-sm" type="submit"
                            @click.prevent="handleSubmit()">Create Ticket
                    </button>
                </div>
            </form>
        </template>
    </SlideModal>
</template>

<script>
import SlideModal from "../../../global/page/SlideModal";

import {mapGetters, mapActions} from "vuex";
import {$vfm} from 'vue-final-modal'

export default {
    name: "TicketSlide",
    components: {
        SlideModal
    },
    data() {
        return {
            errors: false,
            formLoading: false,
            formData: {
                title: '',
                ticketType: null,
                ticketStatus: null,
                description: '',
                latitude: '',
                longitude: '',
                customer: {
                    '@id': null,
                    name: '',
                    surname: '',
                    email: ''
                }
            },
        }
    },
    async mounted() {
        await this.$store.dispatch('Tickets/geolocation').then((resp) => {
            this.formData.latitude = resp.coords.latitude
            this.formData.longitude = resp.coords.longitude
        })
        this.formData.ticketType = this.getTypes.find(type => type.name === 'Sales')['@id']
        this.formData.ticketStatus = this.getStatuses.find(type => type.name === 'new')['@id']
    },
    methods: {
        ...mapActions('Tickets', ['createTicket']),
        handleSubmit() {
            this.formLoading = true
            this.createTicket(this.formData)
                .then((resp) => {
                    console.log(resp)
                    $vfm.hideAll()
                })
                .catch((err) => {
                    if (err.response) {
                        this.handleApiError(err.response)
                    }
                })
                .finally(() => {
                    this.formLoading = false
                })
        },
        handleApiError(err) {
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