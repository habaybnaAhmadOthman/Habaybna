<template>
    <div>
        <RegisterTemplate>
            <LoginForm
                @send-otp="login"
                @error-happen="showErrorMessage"
            >
            </LoginForm>
            <h2 class="white mt-30 light font-17 d-flex space-between align-center p-side-50">
                <span class="">هل أنت عضو في حبايبنا؟</span>
                <router-link class="white d-flex align-center" to="/signin"
                    >تسجيل الدخول <img src="/images/siteImgs/header/logo.png" class="mr-10"></router-link
                >
            </h2>
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

export default {
    components: {
        RegisterTemplate,
        LoginForm
    },
    data() {
        return {
            isLoading: false,
            showCodeForm: false,
            phoneNumber: "",
            type: "",
            code: "",
            error: null
        };
    },

    methods: {
        submitPhone() {
            this.$refs.phoneForm.submitForm();
        },
        closeModal() {
            this.error = null;
        },
        // store phone number and type and otp(optional)
        async login(otpCode) {
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/registerFirstStep", {
                    type: this.type,
                    code: otpCode,
                    phone: this.phoneNumber
                });
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما");
            }
            this.isLoading = false;
            this.showCompleteForm = true;
        },
        showErrorMessage(msg) {
            this.error = msg;
        }
    }
};
</script>
