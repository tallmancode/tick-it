<template>
    <div class="loader">
        <div class="loading__inner">
            <h1>Loading
                <div class="dots"><span class="dot z"></span><span class="dot f"></span><span class="dot s"></span><span class="dot t"><span class="dot l"></span></span></div>
            </h1>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoadingDots",
    mounted(){
        const dots = document.querySelector(".dots")
        this.animateDots(dots, "dots--animate");
    },
    methods: {
        animateDots: function(element, className){
            element.classList.add(className);
            setTimeout(() => {
                element.classList.remove(className);
                setTimeout(() => {
                    this.animateDots(element, className)
                }, 500);
            }, 1000);
        }
    },

}
</script>

<style lang="scss" scoped>
//Loading indicator
.loader{
    background-color: #FFFFFF;
    position: absolute;
    top: 0;
    left: 0;
    height: calc(100vh - (55px + 325px));
    width: 100%;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    &--inner{

    }
}
.dots {
    display: inline-flex;

    &--animate .dot {
        &.z {
            animation: scale .8s .2s forwards;
        }

        &.f,
        &.s {
            animation: right .5s forwards;
        }

        &.l {
            animation: rightDown .4s .1s forwards linear, drop 2s .4s forwards linear;
        }

    }
}

.dot {
    & {
        display: inline-block;
        width: 10px;
        height: 10px;
        background: var(--bs-body-color);
        border-radius: 10px;
        position: relative;
        margin-left: 6px;
        opacity: 1;
    }

    &.z {
        position: absolute;
        transform: scale(0);

        @keyframes scale {
            100% {
                transform: scale(1);
            }
        }
    }

    &.f,
    &.s {
        transform: translateX(0px);

        @keyframes right {
            100% {
                transform: translateX(16px);
            }
        }
    }

    &.t {
        background: transparent;
    }

    .l {
        margin-left: 0;
        position: absolute;
        top: 0;
        left: 0;

        @keyframes rightDown {

            50% {
                top: 4px;
                left: 16px;
            }

            100% {
                top: 12px;
                left: 24px;
            }
        }

        @keyframes drop {
            100% {
                transform: translate(70px, calc(35px + (100vh/2)));
                opacity: 0;
            }
        }
    }
}
</style>