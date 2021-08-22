<template>
    <div class="container">
        <div class="row">
            <DataSeeder v-if="people.length === 0" @seeded="getPeople"/>
            <div v-if="people.length > 0" class="col-12 text-center">
                <button class="btn btn-danger text-light" @click="purgeData">
                    Clear all data
                </button>
                <vue-mesa :ref="'people_table'"
                          :apiUrl="'/api/personal_details'"
                          :dataPath="'data.data'"
                          :fields="[
                            {name: 'first_name', title: 'Name', label: 'Name'},
                            {name: 'last_name', title: 'Surname', label: 'Surname'},
                        ]">
                </vue-mesa>
            </div>

        </div>
    </div>
</template>

<script>
import DataSeeder from "./components/data-seeder/DataSeeder";

export default {
    name: "ComplexQueries",
    components: {DataSeeder},
    mounted() {
        this.getPeople()
    },
    data() {
        return {
            people: []
        }
    },
    methods: {
        purgeData(){
            axios.post('/api/interests/clear_seed')
                .then((resp) => {
                    console.log(resp)
                    this.getPeople()
                })
        },
        getPeople() {
            axios.get('/api/personal_details')
                .then((resp) => {
                    console.log(resp)
                    this.people = resp.data.data
                })
        }
    }
}
</script>

<style scoped>

</style>