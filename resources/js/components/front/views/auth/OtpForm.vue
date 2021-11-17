<template>
    <form @submit.prevent="sendOtp" class="">
        <div class="form-group mb-30" :class="{ invalid: !type.isValid }">
            <div class="select-wrapper relative">
                <select
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    v-model="type.val"
                    id="type"
                    @blur="checkValidity"
                >
                    <option value="no" disabled hidden>هل أنت</option>
                    <option value="parnet"
                        >أحد الوالدين أو أفراد العائلة</option
                    >
                    <option value="parnet">أخصائي تربية حاصة أو تأهيل</option>
                    <option value="parnet">آخر</option>
                </select>
            </div>
            <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
        </div>
        <div class="form-group ltr" :class="{ invalid: !phoneNumber.isValid }">
            <VuePhoneNumberInput
                v-model="phoneNumber.input"
                @update="getPhoneVal"
                @blur="checkValidity"
                @input="checkPhoneNumber"
                id="phoneNumber"
            />
            <p class="main-color mt-5 font-12">رقم الهاتف غير صحيح</p>
        </div>
        <div id="recaptcha-container" class="recaptcha-container"></div>
        <button class="btn w-100 mt-30 bold font-20" id="sign-in-button">التالي</button>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </form>
</template>

<script>
import auth from "./../../../../modules/firebase";
import { signInWithPhoneNumber, RecaptchaVerifier } from "firebase/auth";

import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
export default {
    emits: ["phone-registered"],
    data() {
        return {
            isLoading: false,
            type: {
                val: "no",
                isValid: true
            },
            phoneNumber: {
                input: '',
                val: "",
                isValid: true,
                countryCode: "",
                style: false,
                created:false
            },
            otpFormIsValid: true
        };
    },
    methods: {
        getPhoneVal(phoneNumberInput) {
            if (phoneNumberInput.isValid) {
                this.phoneNumber.val = phoneNumberInput.formattedNumber;
                this.phoneNumber.isValid = true;
            }
        },
        checkPhoneNumber(e){
            if(!this.phoneNumber.created) {
                this.phoneNumber.isValid = true;
            }
        },
        otpValidateForm() {
            this.otpFormIsValid = true;
            if (this.phoneNumber.val == "") {
                this.phoneNumber.isValid = false;
                this.otpFormIsValid = false;
            }
            if (this.type.val == "no") {
                this.type.isValid = false;
                this.otpFormIsValid = false;
            }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
            if (e.target.id == "type") {
                if (e.target.value == "no") {
                    this[e.target.id].isValid = false;
                } else {
                    this[e.target.id].isValid = true;
                }
            }
            
        },
        async sendOtp() {
            this.otpValidateForm();
            if (!this.otpFormIsValid) {
                return;
            }
            this.isLoading = true

            let phoneNumber = this.phoneNumber.val;
            // //
            await signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                .then(confirmationResult => {
                    // SMS sent.
                    window.confirmationResult = confirmationResult;
                    this.$emit("phone-registered");
                })
                .catch(error => {
                    // Error; SMS not sent
                    this.$emit("error-happen", "حدث خطأ ما");
                });
            this.isLoading = false
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
    },
    components: { VuePhoneNumberInput }
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
.select-wrapper::after {
    color: #606;
    content: "▾";
    margin-right: 10px;
    pointer-events: none;
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    margin: auto;
    font-size: 20px;
    width: 10px;
    height: 10px;
    line-height: 10px;
}

select {
    -moz-appearance: none;
    -webkit-appearance: none;
}
select:focus {
    color: black;
}
select::-ms-expand {
    display: none;
}
select::-ms-expand {
    display: none;
}
.form-control {
    border: 1px solid #606;
    height: 52px;
}
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgb(121 106 238 / 25%);
}
</style>
