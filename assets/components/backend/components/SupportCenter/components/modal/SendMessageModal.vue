<template>
    <StdModal>
        <template v-slot:title>Send {{ $attrs.ticket.customer.name }} a message</template>
        <template v-slot:content>
            <div class="row">
                <form @submit.prevent="handleSubmit">
                    <div class="form-group">
                        <label for="title">Subject</label>
                        <input id="title" v-model="formData.title" class="form-control form-control-user"
                               placeholder="Enter a title for your ticket" type="text"
                               v-bind:class="{'is-invalid' : errors.title}">
                        <span v-if="errors.title" class="text-danger">
                        {{ errors.title }}
                    </span>

                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" v-model="formData.message"
                                  class="form-control form-control-user" placeholder="Enter a message for your ticket"
                                  v-bind:class="{'is-invalid' : errors.message}"></textarea>
                        <span v-if="errors.message" class="text-danger">
                                {{ errors.message }}
                            </span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Send Mail</button>
                    </div>
                </form>
            </div>
        </template>
    </StdModal>

</template>

<script>
import StdModal from "../../../global/page/StdModal";
export default {
    name: "SendMessageModal",
    components: {StdModal},
    data(){
        return {
            errors: false,
            formData: {
                ticket:this.$attrs.ticket['@id'],
                customer:this.$attrs.ticket.customer['@id'],
                title: '',
                message: ''
            }
        }
    },
    mounted(){
        console.log(this.$attrs.ticket)
    },
    methods:{
        handleSubmit(){
            axios.post('/api/replies', this.formData)
            .then((resp) => {
                console.log(resp)
            })
        }
    }
}
</script>

<style scoped>

</style>