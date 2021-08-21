<template>
    <vue-final-modal
        v-slot="{ close }"
        v-bind="$attrs"
        classes="modal-container"
        content-class="modal-content"
        transition="slide"
    >
        <div class="slide__header">
            <span class="slide__title">
                <slot name="title"></slot>
            </span>
            <a class="slide__close" @click="close">
                <i class="fa-times fa me-2"></i>
            </a>
        </div>
        <div class="slide__content">
            <slot name="content"></slot>
        </div>
    </vue-final-modal>
</template>

<script>
import { VueFinalModal } from 'vue-final-modal'
export default {
    name: "SlideModal",
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
    width: 100%;
    position: fixed;
}
:deep(.modal-content) {
    position: absolute;
    right: 0;
    top:0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    border-top-left-radius: 16px;
    border-bottom-left-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #fff;
    max-width: 50%;
    .slide__header{
        position: relative;
        border-bottom: 1px solid $grey-border-color;
        padding-bottom: 1rem;
        .slide__title {
            margin: 0 2rem 0 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .slide__close {
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
    .slide__content{
        padding: 1rem 0;
    }
}
</style>