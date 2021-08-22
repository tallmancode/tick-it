<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="form-group">
                    <label>Sorting Type</label>
                    <multi-select
                        v-model="ordering"
                        :canClear=false
                        :canDeselect=false
                        :mode="'single'"
                        :options="orderingOptions"
                    />
                </div>
            </div>
            <div class="col-12">
                <FileUpload ref="uploader"
                            v-model="file"
                            :errors-prop="errors"
                            :instruction-string="'Drag your email signature here to start uploading (.txt, .xlsx, .csv).'"
                            :upload-method="uploadMedia"></FileUpload>
            </div>
        </div>
    </div>
</template>

<script>
import FileUpload from "../global/file-upload/FileUpload";
import ErrorModal from "../global/modals/ErrorModal";

export default {
    name: "FileManipulation",
    components: {FileUpload},
    data() {
        return {
            file: null,
            errors: false,
            ordering: 'alphabetical',
            orderingOptions: ['alphabetical', 'length']
        }
    },
    methods: {
        uploadMedia(file) {
            this.errors = false
            let formData = new FormData();
            formData.append('file', file);
            formData.append('ordering', this.ordering)
            axios
                .post('/file/manipulation/file/manipulation', formData, {showLoader: false})
                .then((resp) => {
                    let fileLink = document.createElement('a');
                    fileLink.href = '/uploads/file-manipulation' + resp.data.filePath;
                    document.body.appendChild(fileLink);
                    fileLink.click()
                    this.file = null
                    this.$refs.uploader.clearInput();
                })
                .catch((err) => {
                    if (err.response) {
                        if (err.response.status === 422) {
                            this.errors = err.response.data
                            console.log(this.errors)
                        }
                    } else {

                    }
                    this.$vfm.show({component: ErrorModal})
                    this.$refs.uploader.clearInput();
                })
        }
    }
}
</script>

<style scoped>

</style>