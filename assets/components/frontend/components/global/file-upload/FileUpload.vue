<template>
    <div ref="file__container" class="upload__wrapper" v-bind:class="{'has-error' : errorsProp.file }">
        <div ref="file__upload" class="upload__inner">
            <img :src="require('/assets/media/file-upload/folder-empty.png')" alt="">
            <p v-if="instructionString">{{ instructionString }}</p>
            <div class="upload__divider">
                OR
            </div>
            <button class="btn btn-primary" @click="showFileSelect">
                Browse Files
            </button>
            <input id="upload_input" ref="fileInput" class="media-input"
                   multiple
                   name="upload_input" type="file" @change="onFileChange" v-if="uploadReady">
            <div v-if="errorsProp.file" class="error">
                {{ errorsProp.file }}
            </div>
            <div v-if="processing" class="upload__loading">
<!--                <img :src="require('/assets/media/images/tlb-loading.gif')" alt="">-->
                <p>Processing Your Upload</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FileUpload",
    props: {
        instructionString: {
            type: [String, Boolean],
            default: false
        },
        uploadMethod: {
            type: [Function],
            required: true
        },
        errorsProp: {
            type: [Object, Boolean],
            default: false
        },
        modelValue: [Object, Boolean, Array, String]
    },
    mounted() {
        this.initDragAndDrop()
    },
    data() {
        return {
            processing: false,
            file: null,
            uploadReady: true,
            errors: false,
        }
    },
    methods: {
        showLoader(value){
            if(typeof value === 'boolean'){
                this.processing = value
            } else {
                this.processing = !this.processing
            }
        },
        clearInput(){
            this.uploadReady = false
            this.$nextTick(() => {
                this.uploadReady = true
            })
        },
        determineDragAndDropCapable() {
            let div = document.createElement('div');
            return (('draggable' in div)
                || ('ondragstart' in div && 'ondrop' in div))
                && 'FormData' in window
                && 'FileReader' in window;
        },
        initDragAndDrop() {
            this.dragAndDropCapable = this.determineDragAndDropCapable();

            if (this.dragAndDropCapable) {

                ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (evt) {
                    this.$refs.file__upload.addEventListener(evt, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }.bind(this), false);
                }.bind(this));

                this.$refs.file__upload.addEventListener('drop', function (e) {
                    let files = e.target.files || e.dataTransfer.files;
                    if (files.length) {
                        this.file = files[0];
                        this.uploadMethod(files[0]);
                    }
                }.bind(this));
            }
        },
        showFileSelect: function () {
            if (this.fileUploading) return;
            this.$refs.fileInput.click();
        },
        onFileChange(e) {
            this.fileUploading = true;
            let files = e.target.files || e.dataTransfer.files;
            this.file = files[0]
            if (!files.length) return;
            this.uploadMethod(files[0]);
            this.$emit('update:modelValue', files[0]);
            this.fileUploading = false
        },
    },
    watch:{

    }
}
</script>

<style lang="scss" scoped>
@import "assets/scss/variables";
.upload {
    &__wrapper {
        border-radius: 16px;
        border: 1px solid $grey-border-color;
        padding: 30px;

        &.has-error {
            border-color: #f00;
        }

        .error {
            color: #f00;
        }
    }

    &__inner {
        overflow: hidden;
        position: relative;
        background-color: #F1F4FA;
        border: 1px dashed $grey-border-color;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px 10px;

        img {
            margin-bottom: 14px;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin-bottom: 14px;
            color: #636C80;
        }

        .media-input {
            visibility: hidden;
        }
    }

    &__divider {
        position: relative;
        font-size: 22px;
        text-transform: uppercase;
        color: $grey-border-color;
        margin-bottom: 14px;

        &:before, &:after {
            content: '';
            height: 1px;
            width: 80px;
            position: absolute;
            top: 50%;
            transform: translateX(-50%);
            background-color: $grey-border-color;
        }

        &:before {
            left: -50px;
        }

        &:after {
            right: -130px;
        }
    }

    &__loading {
        flex-direction: column;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        bottom: 0;
        width: 100%;
        background-color: #F1F4FA;

        img {
            max-width: 70px;
        }
    }
}
.error{
    font-size: 14px;
    width: 100%;
    text-align: center;
}
</style>