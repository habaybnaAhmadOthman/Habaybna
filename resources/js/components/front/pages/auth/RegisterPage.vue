<template>
    <div>
        <FormTemplate>
            <OtpForm
                @send-otp="gotPhone"
                @error-happen="showErrorMessage"
                v-if="!showCodeForm"
                ref="phoneForm"
            >
            </OtpForm>
            <CodeForm
                @complete-registration-form="gotCode"
                @send-otp="gotPhone"
                v-else-if="!showCompleteForm"
            ></CodeForm>
            <CompleteRegistration v-else></CompleteRegistration>
            <button :class="{'asb-btn': phoneNumber != ''}"
                @click="submitPhone"
                class="btn w-100 mt-30 bold font-20"
                id="sign-in-button"
            >
                التالي
            </button>
            <h2 v-if="!showCodeForm" class="main-color mt-50 light font-17">هل أنت عضو في حبايبنا؟ <router-link class="pr-5" to="/signin">تسجيل الدخول</router-link></h2>
        </FormTemplate>
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
// forms
import FormTemplate from "./../../layouts/FormTemplate.vue";
import OtpForm from "./../../views/auth/OtpForm.vue";
import CodeForm from "./../../views/auth/CodeForm.vue";
import CompleteRegistration from "./../../views/auth/CompleteRegistration.vue";

export default {
    components: {
        FormTemplate,
        OtpForm,
        CodeForm,
        CompleteRegistration
    },
    data() {
        return {
            isLoading: false,
            showCodeForm: false,
            showCompleteForm: false,
            phoneNumber: "",
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
        gotCode() {
            this.showCompleteForm = true;
        },
        showErrorMessage(msg) {
            this.error = msg;
        }

        // // add phone number styling
        // getStyleDirection() {
        //     if (!this.phoneNumber.style) {
        //         var css =
        //                 ".vti__dropdown-list { right: 0; }.vti__dropdown-item {display:flex;align-items:center;}",
        //             head =
        //                 document.head ||
        //                 document.getElementsByTagName("head")[0],
        //             style = document.createElement("style");

        //         head.appendChild(style);

        //         style.type = "text/css";
        //         style.appendChild(document.createTextNode(css));
        //     }
        // },
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
    z-index: 10;
}
</style>