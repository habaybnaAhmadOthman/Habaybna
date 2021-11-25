<template>
    <div>
        <RegisterTemplate>
            <LoginForm @save-form="login"> </LoginForm>
            <h3 class="mt-50 center light font-15 flex-all p-side-50">
                <span class="main-color">لست من عائلة حبايبنا؟</span>
                <router-link class="blue d-flex align-center" to="/signup"
                    >إنضم الآن</router-link
                >
            </h3>
        </RegisterTemplate>
        <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        ></alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </div>
</template>

<script>
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import LoginForm from "./../../views/auth/LoginForm.vue";
import loadingMixin from './../../mixins/loading.js'
export default {
    mixins: [loadingMixin],
    components: {
        RegisterTemplate,
        LoginForm
    },
    data() {
        return {
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
                    phone: data.phone
                });

                this.$router.replace("/");
            } catch (e) {
                this.showErrorMessage(e);
            }
            this.isLoading = false;
        }
    }
};
</script>
