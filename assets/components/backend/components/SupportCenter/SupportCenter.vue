<template>
    <page-template>
        <template v-slot:page_header>
            <page-header>
                <template v-slot:after_title>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-magic fa-sm text-white-50 me-2"></i>Create a new ticket</a>
                </template>
            </page-header>
        </template>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                 src="img/undraw_posting_photo.svg" alt="...">
                        </div>
                        <p>Add some quality, svg illustrations to your project courtesy of <a
                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                            constantly updated collection of beautiful svg images that you can use
                            completely free and without attribution!</p>
                        <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                            unDraw &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </page-template>
</template>

<script>
export default {
    name: "SupportCenter"
}
</script>

<style scoped>

</style>