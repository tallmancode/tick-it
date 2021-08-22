<template>
    <div class="col-12">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-center">
                <button class="btn btn-primary me-3" @click="getAnimalLovers">Animal Lovers</button>
                <button class="btn btn-secondary me-3" @click="getSportsAndChildren">Children & Sport Lovers</button>
                <button class="btn btn-info me-3" @click="getUniqueInterests">Unique Interests & No Docs</button>
                <button class="btn btn-success me-3" @click="getFiversAndSixers">5 or 6 interests</button>
            </div>
            <div class="col-12 viewer-container mb-4">
                <div class="row">
                    <div class="col-md-6 col-12 border-end">
                        <h4 class="text-center">Sql Query</h4>
                        <div class="code-block">
                            <span v-if="sqlQuery">
                                <pre>{{sqlQuery}}</pre>
                            </span>
                            <p class="text-center" v-else>No queries yet. Run one by pressing the buttons above</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <h4 class="text-center">Result Set</h4>
                        <div class="code-block">
                            <span v-if="resultSet">
                                <pre>{{resultSet}}</pre>
                            </span>
                            <p class="text-center" v-else>No results yet. Run a query by pressing the buttons above</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "QueriesViewer",
    data(){
        return{
            sqlQuery : false,
            resultSet: false
        }
    },
    methods:{
        getAnimalLovers(){
            axios.get('/queries/youre_a_animal')
            .then((resp) => {
                this.sqlQuery = resp.data.query
                this.resultSet = resp.data.data
            })
        },
        getSportsAndChildren(){
            axios.get('/queries/children_and_sports')
                .then((resp) => {
                    this.sqlQuery = resp.data.query
                    this.resultSet = resp.data.data
                })
        },
        getUniqueInterests(){
            axios.get('/queries/unique_interest')
                .then((resp) => {
                    this.sqlQuery = resp.data.query
                    this.resultSet = resp.data.data
                })
        },

        getFiversAndSixers(){
            axios.get('/queries/fivers_and_sixers')
                .then((resp) => {
                    this.sqlQuery = resp.data.query
                    this.resultSet = resp.data.data
                })
        }
    },

}
</script>

<style scoped lang="scss">
.code-block{
    max-height: 200px;
    overflow-y: auto;
}
</style>