<template>
    <div>
        <RegisterTemplate>
            <LoginForm
                @save-form="login"
            >
            </LoginForm>
            <h2 class="mt-30 center light font-15 flex-all p-side-50">
                <span class="main-color">لست من عائلة حبايبنا؟</span>
                <router-link class="blue d-flex align-center" to="/signin"
                    >إنضم الآن</router-link>
            </h2>
        </RegisterTemplate>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </div>
</template>

<script>
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import LoginForm from "./../../views/auth/LoginForm.vue";

export default {
    components: {
        RegisterTemplate,
        LoginForm
    },
    data() {
        return {
            isLoading: false,
            type: "",
            code: ""
        };
    },

    methods: {
        async login(data) {
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/login", {
                    password: data.password,
                    user: data.user,
                });
            } catch (e) {
                
            }
            this.isLoading = false;
        }
    }
};
</script>
