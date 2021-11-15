<template>
    <form @submit.prevent="register" class="pt-100 p-side-30 mt-30">
        <!-- <div :class="{'invalid': !email.isValid}" class="form-group">
            <input placeholder="email" id="email" @blur="checkValidity" v-model.trim="email.val" />
            <p>please enter a correct email</p>
        </div>
        <div class="form-group" :class="{invalid: !password.isValid}">
            <input type="password" id="password" @blur="checkValidity" v-model.trim="password.val" />
            <p>this field is required</p>
        </div> -->
        <div :class="{ invalid: !phoneNumber.isValid }" class="form-group">
            <input
                placeholder="phoneNumber"
                id="phoneNumber"
                @blur="checkValidity"
                v-model.trim="phoneNumber.val"
            />
            <p>please enter a correct phoneNumber</p>
        </div>
        <div id="recaptcha-container" class="recaptcha-container"></div>
        <button id="sign-in-button">Register</button>
        <router-link to="/login">Login instead</router-link>
    </form>
</template>

<script>
import auth from "./../../../../modules/firebase.js";
import { signInWithPhoneNumber, RecaptchaVerifier } from "firebase/auth";
export default {
    data() {
        return {
            phoneNumber: {
                val: "",
                isValid: true
            },
            email: {
                val: "",
                isValid: true
            },
            password: {
                val: "",
                isValid: true
            },
            appVerifier: "",
            formIsValid: true
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
        register() {
            // this.validateForm()
            // if (!this.formIsValid) {
            //     return;
            // }

            let countryCode = "+962"; //india
            let phoneNumber = countryCode + "786753791";
            // //

            // const appVerifier = window.recaptchaVerifier;
            signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                .then(confirmationResult => {
                    // SMS sent.
                    // window.confirmationResult = confirmationResult;
                    // ...
                })
                .catch(error => {
                    // Error; SMS not sent
                    console.log(error);
                });
            // auth.sendOtp(window.recaptchaVerifier);
            // let countryCode = "+962"; //india
            // let phoneNumber = countryCode + "786753791";
            // //

            // //
            // firebase
            //     .auth()
            //     .signInWithPhoneNumber(phoneNumber, appVerifier)
            //     .then(function(confirmationResult) {
            //         // SMS sent. Prompt user to type the code from the message, then sign the
            //         // user in with confirmationResult.confirm(code).
            //         window.confirmationResult = confirmationResult;
            //         //
            //         alert("SMS sent");
            //     })
            //     .catch(function(error) {
            //         // Error; SMS not sent
            //         // ...
            //         alert("Error ! SMS not sent");
            //     });
            // // }
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
</style>
