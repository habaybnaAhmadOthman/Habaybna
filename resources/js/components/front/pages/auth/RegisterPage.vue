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
                @complete-registration-form="gotCode"
                @send-otp="gotPhone"
                v-else-if="!showCompleteForm"
            ></CodeForm>
            <CompleteParent @complete-registration="registrationDone" v-else-if="showCompleteForm && type == 'parent'"></CompleteParent>
            <CompleteOthers @complete-registration="registrationDone" v-else-if="showCompleteForm && !showInterestScreen"></CompleteOthers>
            <WelcomeScreen v-else-if="showInterestScreen" @submit-interests="addInterests"></WelcomeScreen>
            <button
                :class="{ 'asb-btn': phoneNumber != '' }"
                @click="submitPhone"
                class="btn-img bg-none mt-30 border-0 pointer flex-all white m-side-auto font-20"
                id="sign-in-button"
            >
                أرسل رمز التحقّق <img src="/images/siteImgs/header/logo.png" class="mr-10">
            </button>
            <h2 v-if="!showCompleteForm || !showInterestScreen" class="white mt-30 light font-17 d-flex space-between align-center p-side-50">
                <span class="">هل أنت عضو في حبايبنا؟</span>
                <router-link class="white d-flex align-center" to="/signin"
                    >تسجيل الدخول <img src="/images/siteImgs/header/logo.png" class="mr-10"></router-link
                >
            </h2>
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
import CompleteParent from "./../../views/auth/CompleteParent.vue";
import CompleteOthers from "./../../views/auth/CompleteOthers.vue";
import WelcomeScreen from "./../../views/auth/WelcomeScreen.vue";

export default {
    components: {
        RegisterTemplate,
        OtpForm,
        CodeForm,
        CompleteParent,
        CompleteOthers,
        WelcomeScreen,
    },
    data() {
        return {
            isLoading: false,
            showCodeForm: false,
            showCompleteForm: false,
            showInterestScreen:false,
            phoneNumber: "",
            type: "",
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
        async registrationDone(userData){
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/register",{
                    ...userData,
                    type:this.type,
                    phone: this.phoneNumber
                });
                this.showInterestScreen = true
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما")
            }
            this.isLoading = false;
        },
        addInterests(interests){
            try {
                this.$store.dispatch("user/register",{
                    interests
                });
                this.$router.replace('/')
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما")
            }
        },
        async gotCode() {
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/register", {
                    type: this.type.val,
                    phone: this.phoneNumber
                });
                console.log("done");
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما");
            }
            this.isLoading = false;
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
