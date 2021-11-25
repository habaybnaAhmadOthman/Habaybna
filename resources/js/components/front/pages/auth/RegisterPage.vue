<template>
    <div>
        <RegisterTemplate>
            <OtpForm
                @send-otp="gotPhone"
                @error-happen="showErrorMessage"
                v-if="!showCodeForm"
                ref="phoneForm"
            >
            </OtpForm>
            <CodeForm
                @complete-registration-form="submitForm"
                @send-otp="gotPhone"
                v-else
            ></CodeForm>
            <button
                :class="{ 'asb-btn': showCodeForm }"
                @click="submitPhone"
                class="btn-2 mt-30 flex-all m-side-auto font-20"
                id="sign-in-button"
            >
                أرسل رمز التحقّق
                <img src="/images/siteImgs/header/logo.png" class="mr-10" />
            </button>
            <h3 class="mt-50 center light font-15 flex-all p-side-50">
                <span class="main-color">هل أنت عضو في عائلة حبايبنا؟</span>
                <router-link class="blue d-flex align-center" to="/signin"
                    >تسجيل دخول</router-link
                >
            </h3>
        </RegisterTemplate>
        <div id="recaptcha-container" class="recaptcha-container"></div>
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
import auth from "./../../../../modules/firebase";
import { signInWithPhoneNumber, RecaptchaVerifier } from "firebase/auth";
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import OtpForm from "./../../views/auth/OtpForm.vue";
import CodeForm from "./../../views/auth/CodeForm.vue";

import loading from "./../../mixins/loading.js";

export default {
    mixins: [loading],
    components: {
        RegisterTemplate,
        OtpForm,
        CodeForm
    },
    data() {
        return {
            showCodeForm: false,
            phoneNumber: "",
            type: "",
            code: ""
        };
    },

    methods: {
        submitPhone() {
            this.$refs.phoneForm.submitForm();
        },
        async gotPhone(obj) {
            this.isLoading = true;
            if (!obj.phoneNumber) {
                obj.phoneNumber = this.phoneNumber;
                await window.recaptchaVerifier
                    .render()
                    .then(function(widgetId) {
                        grecaptcha.reset(widgetId);
                    });
            } else {
                this.phoneNumber = obj.phoneNumber;
                this.type = obj.type;
            }
            await signInWithPhoneNumber(
                auth,
                obj.phoneNumber,
                window.recaptchaVerifier
            )
                .then(confirmationResult => {
                    // SMS sent.
                    window.confirmationResult = confirmationResult;
                    this.showCodeForm = true;
                })
                .catch(error => {
                    console.log(error);
                    // Error; SMS not sent
                    this.showErrorMessage("حدث خطأ ما");
                });

            this.isLoading = false;
        },
        // store phone number and type and otp(optional)
        async submitForm(otpCode) {
            this.isLoading = true;
            try {
                // call api
                await this.$store.dispatch("user/registerFirstStep", {
                    type: this.type,
                    code: otpCode,
                    phone: this.phoneNumber,
                    token: document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")
                });
                this.$router.replace(`/${this.type}-complete-registration`);
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما");
            }
            this.isLoading = false;
        }
    },
    mounted() {
        window.recaptchaVerifier = new RecaptchaVerifier(
            "sign-in-button",
            {
                size: "invisible",
                callback: response => {}
            },
            auth
        );
    }
};
</script>
<style scoped>
.asb-btn {
    position: absolute;
    top: 0;
    z-index: -1;
    visibility: hidden;
    opacity: 0;
}
.spinner {
    z-index: 10 !important;
}
</style>
