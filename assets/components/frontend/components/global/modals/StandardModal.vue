<template>
    <vue-final-modal
        v-slot="{ close }"
        v-bind="$attrs"
        classes="modal-container"
        content-class="modal-content"
    >
        <div class="modal__header">
            <span class="modal__title">
                <slot name="title"></slot>
            </span>
            <a class="modal__close" @click="close">
                <i class="fa-times fa me-2"></i>
            </a>
        </div>
        <div class="modal__content">
            <slot name="content"></slot>
        </div>
    </vue-final-modal>
</template>

<script>
import { VueFinalModal } from 'vue-final-modal'
export default {
    name: "StandardModal",
    inheritAttrs: false,
    components: {VueFinalModal},
    data(){
        return{
        }
    },
    methods:{
    }
}
</script>

<style scoped lang="scss">
@import "assets/scss/variables";
:deep(.modal-container) {
    display: flex;
    justify-content: center;
    align-items: center;
}
:deep(.modal-content) {
    position: relative;
    display: flex;
    flex-direction: column;
    margin: 0 1rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    background: #fff;
    max-width: 600px;
    .modal__header{
        position: relative;
        border-bottom: 1px solid $grey-border-color;
        padding-bottom: 1rem;
        .modal__title {
            margin: 0 2rem 0 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .modal__close {
            position: absolute;
            display: block;
            top: 0.5rem;
            right: 0.5rem;
            cursor: pointer;
            i{
                color: $grey-border-color;
                font-size: 30px;
                &:hover{
                    color: $red;
                }
            }
        }
    }
    .modal__content{
        max-width: 600px;
        padding: 1rem 0;
    }
}
</style>