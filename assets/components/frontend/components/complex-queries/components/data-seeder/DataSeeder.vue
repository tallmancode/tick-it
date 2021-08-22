<template>
    <div class="col-12 text-center">
        <h6>It looks like no one is interested! Add some interests to get started.</h6>
        <button class="btn btn-primary" @click="seedData">
            Create Data
        </button>
        <p class="text-danger mt-2" v-if="errors.tables"> {{ errors.tables }}</p>
    </div>
</template>

<script>
export default {
    name: "DataSeeder",
    data(){
        return{
            loading: false,
            errors: false
        }
    },
    methods: {
        seedData(){
            axios.post('/api/interests/seed')
            .then((resp) => {
                this.$emit('seeded', resp.data)
            })
            .catch((err) => {
                if(err.response){
                   this.errors = err.response.data
                }
            })
        }
    }
}
</script>

<style scoped>

</style>