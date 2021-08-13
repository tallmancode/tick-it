<template>
    <div id="loading" v-if="loading">
        <div class="loading__inner">
            <div class="bounceball"></div>
            <div class="text">NOW LOADING</div>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "GlobalLoading",
    computed: {
        ...mapState('Loader', ['loading'])
    }
}
</script>

<style scoped lang="scss">
$width: 15px;
$height: 15px;
$bounce_height: 30px;
#loading {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100vh;
    background: #fff;
    z-index: 9999;
    .loading {
        &__inner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            .bounceball {
                position: relative;
                display: inline-block;
                height: 37px;
                width: $width;
                &:before {
                    position: absolute;
                    content: "";
                    display: block;
                    top: 0;
                    width: $width;
                    height: $height;
                    border-radius: 50%;
                    background-color: #fbae17;
                    transform-origin: 50%;
                    animation: bounce 500ms alternate infinite ease;
                }
            }
            .text {
                color: #fbae17;
                display: inline-block;
                margin-left: 5px;
            }
        }
    }
}

@keyframes bounce {
    0% {
        top: $bounce_height;
        height: 5px;
        border-radius: 60px 60px 20px 20px;
        transform: scaleX(2);
    }
    35% {
        height: $height;
        border-radius: 50%;
        transform: scaleX(1);
    }
    100% {
        top: 0;
    }
}
</style>