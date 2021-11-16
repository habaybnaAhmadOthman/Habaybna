<template>
    <div class="header-margin">
        <div class="container soft-bg radius-12 pt-30 pb-30">
            <AuthHeader></AuthHeader>
            <div class="p-side-30 mt-50">
                <form
                    @submit.prevent="sendOtp"
                    v-if="!code.showForm"
                    class=""
                >
                    <div class="form-group">
                        <select v-model="type.val">
                            <option value="no" disabled hidden>هل أنت</option>
                            <option value="parnet"
                                >أحد الوالدين أو أفراد العائلة</option
                            >
                            <option value="parnet"
                                >أخصائي تربية حاصة أو تأهيل</option
                            >
                            <option value="parnet">آخر</option>
                        </select>
                    </div>
                    <div class="form-group" :class="{ invalid: !phoneNumber.val }">
                        <vue-tel-input
                            @open="getStyleDirection"
                            v-model="phoneNumber.val"
                            @input="getPhoneVal"
                            :inputOptions="{
                                placeholder: 'xxxxx',
                                required: true,
                                invalidMsg: 'please enter a valid number',
                                id: 'phoneNumberInput'
                            }"
                            :dropdownOptions="{
                                showDialCodeInSelection: true,
                                showFlags: true
                            }"
                        ></vue-tel-input>
                    </div>
                    <div id="recaptcha-container" class="recaptcha-container"></div>
                    <button id="sign-in-button">Register</button>
                    <router-link to="/login">Login instead</router-link>
                </form>

                <form @submit.prevent="submitCode" v-else>
                    <div class="form-group" :class="{ invalid: !code.isValid }">
                        <input
                            id="code"
                            @blur="checkValidity"
                            v-model.trim="code.val"
                        />
                        <p>this field is required</p>
                    </div>
                    <button>Code</button>
                </form>
            </div>
        </div>
        <alert-dialog
            :show="!!error"
            title="An error occurred"
            @close="closeModal"
        ></alert-dialog>
    </div>
</template>

<script>
import auth from "./../../../../modules/firebase.js";
import { signInWithPhoneNumber, RecaptchaVerifier } from "firebase/auth";

import { VueTelInput } from "vue-tel-input";
import "vue-tel-input/dist/vue-tel-input.css";

// page header
import AuthHeader from "./../../layouts/header/AuthHeader.vue";

export default {
    components: {
        VueTelInput,
        AuthHeader
    },
    data() {
        return {
            type: {
                val: "no",
                isValid: true
            },
            phoneNumber: {
                val: "",
                isValid: true,
                countryCode: "",
                styles: false
            },
            email: {
                val: "",
                isValid: true
            },
            password: {
                val: "",
                isValid: true
            },
            code: {
                val: "",
                isValid: true,
                showForm: false
            },
            formIsValid: true,
            error: null
        };
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
    },

    methods: {
        closeModal() {
            this.error = null;
        },
        getPhoneVal(number, phoneObject) {
            this.phoneNumber.countryCode = phoneObject.country.dialCode;
        },
        // add phone number styling
        getStyleDirection() {
            if (!this.phoneNumber.style) {
                var css =
                        ".vti__dropdown-list { right: 0; }.vti__dropdown-item {display:flex;align-items:center;}",
                    head =
                        document.head ||
                        document.getElementsByTagName("head")[0],
                    style = document.createElement("style");

                head.appendChild(style);

                style.type = "text/css";
                style.appendChild(document.createTextNode(css));
            }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
            if (e.target.id == "email" && !e.target.value.includes("@")) {
                this[e.target.id].isValid = false;
            }
        },
        validateForm() {
            this.formIsValid = true;
            if (!this.email.val.includes("@") || this.email.val == "") {
                this.email.isValid = false;
                this.formIsValid = false;
            }
            if (this.password.val == "") {
                this.password.isValid = false;
                this.formIsValid = false;
            }
        },
        sendOtp() {
            // this.validateForm()
            // if (!this.formIsValid) {
            //     return;
            // }

            let countryCode = "+" + this.phoneNumber.countryCode;
            let phoneNumber = countryCode + this.phoneNumber.val.slice(1);
            // //
            signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                .then(confirmationResult => {
                    // SMS sent.
                    window.confirmationResult = confirmationResult;
                    this.code.showForm = true;
                })
                .catch(error => {
                    // Error; SMS not sent
                    this.error = error.message || "Some thing went wrong";
                });
        },
        submitCode() {
            if (this.code.val == "") {
                this.code.isValid = false;
                return;
            }
            // ...
            window.confirmationResult
                .confirm(this.code.val)
                .then(result => {
                    // User signed in successfully.
                    const user = result.user;
                    // ...
                })
                .catch(error => {
                    this.error = error.message || "Some thing went wrong";
                    // User couldn't sign in (bad verification code?)
                });
        }
    }
};
</script>

<style scoped>
.form-group p {
    display: none;
}
.form-group.invalid p {
    display: block;
}
.vti__input {
    text-align: right;
    unicode-bidi: plaintext;
}
.soft-bg {
    background: #d0ebf1;
}
</style>
