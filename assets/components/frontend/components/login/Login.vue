<template>
    <form class="form-signin" @submit.prevent="handleSubmit">
        <img class="mb-4 logo" :src="require('/assets/media/logo/tick-it-logo-blue.svg')" alt="">
        <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="email" placeholder="name@example.com" v-model="formData.email">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password" v-model="formData.password">
            <label for="password">Password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-3 mb-3 text-muted">&copy;TallmanCode 2021</p>
    </form>
</template>

<script>
export default {
    name: "Login",
    data() {
        return{
            formData: {
                email: null,
                password: null,
            }
        }
    },
    methods: {
        handleSubmit(){
            axios
                .post('/login', this.formData)
                .then((resp) => {
                    if (resp.status === 204 && resp.headers.location) {
                        window.location.href = resp.headers.location;
                    }
                })
                .catch((err) => {

                })
        }
    }
}
</script>

<style scoped lang="scss">
.form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;


    .logo{

    }
    .checkbox {
        font-weight: 400;
    }
    .form-floating:focus-within {
        z-index: 2;
    }
    input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
}
</style>