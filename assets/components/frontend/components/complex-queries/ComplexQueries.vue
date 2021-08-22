<template>
    <div class="container py-4">
        <div class="row">
            <DataSeeder v-if="people.length === 0" @seeded="getPeople"/>
            <QueriesViewer v-if="people.length > 0"/>
            <div v-if="people.length > 0" class="col-12 border-top pt-4">
                <vue-mesa :ref="'people_table'"
                          :apiUrl="'/api/personal_details'"
                          :dataPath="'data.data'"
                          :fields="[
                            {name: 'first_name', title: 'Name', label: 'Name'},
                            {name: 'last_name', title: 'Surname', label: 'Surname'},
                            {name: 'interest_count', title: 'Number of interests', label: 'Number of interests'},
                            {name: 'doc_count', title: 'Number of documents', label: 'Number of documents'},
                        ]">
                    <template v-slot:headerRow>
                        <button class="btn btn-danger text-light" @click="purgeData">
                            Clear all data
                        </button>
                    </template>
                </vue-mesa>
            </div>
        </div>
    </div>
</template>

<script>
import DataSeeder from "./components/data-seeder/DataSeeder";
import QueriesViewer from "./components/queries/QueriesViewer";
import ClearDataModal from "./components/data-seeder/ClearDataModal";
export default {
    name: "ComplexQueries",
    components: { DataSeeder, QueriesViewer },
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
            this.$vfm.show({component: ClearDataModal, bind: { name:'ClearDataModal'}, on:{'deleted' : this.purgeComplete}})
        },
        purgeComplete(){
            this.$vfm.toggle('ClearDataModal')
            this.getPeople();
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