<template>
    <StandardModal>
        <template v-slot:title><span class="text-danger">Purge Data</span></template>
        <template v-slot:content>
            <p>Are you sure you want to purge all data. This cannot be undone!!</p>
            <div class="row text-center">
                <div class="col-12 col-md-6 ">
                    <button type="button" class="btn btn-danger text-light" @click="confirm">Nuke it all!</button>
                </div>
                <div class="col-12 col-md-6">
                    <button type="button" class="btn btn-success" @click="cancel">Cancel</button>
                </div>
            </div>
        </template>
    </StandardModal>
</template>

<script>
import StandardModal from "../../../global/modals/StandardModal";
export default {
    name: "ClearDataModal",
    components: { StandardModal },
    methods: {
        confirm(){
            axios.post('/api/interests/clear_seed', null, { showLoader: false })
                .then((resp) => {
                    this.$emit('deleted')
                })
        },
        cancel(){
            this.$vfm.toggle('ClearDataModal')
        }

    }
}
</script>

<style scoped>

</style>