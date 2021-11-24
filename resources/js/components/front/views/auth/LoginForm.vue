<template>
    <div class="mobile-form p-side-50">
        <h2 class="main-color font-40 bold center mb-10">
            تسجيل دخول
        </h2>
        <form @submit.prevent="submitForm">
            <template>
                <div
                    v-if="viaPhone"
                    class="form-group ltr mb-30"
                    :class="{ invalid: !phoneNumber.isValid }"
                >
                    <VuePhoneNumberInput
                        v-model="phoneNumber.input"
                        @update="getPhoneVal"
                        @input="checkPhoneNumber"
                        :show-code-on-list="true"
                        :translations="{
                            countrySelectorLabel: 'رمز الدولة',
                            phoneNumberLabel: 'رقم الهاتف'
                        }"
                        id="phoneNumber"
                        :default-country-code="countryCode"
                    />
                    <p class="main-color mt-5 font-12">رقم الهاتف غير صحيح</p>
                </div>
                <div v-else>
                    <div
                        class="form-group mb-30 relative"
                        :class="{ invalid: !email.isValid }"
                    >
                        <input
                            @blur="checkValidity"
                            v-model.trim="email.val"
                            id="email"
                            type="email"
                            class="form-control font-18 holder-center w-100 user-input"
                            placeholder=" البريد الالكتروني"
                        />
                        <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
                    </div>
                </div>
            </template>
            <div
                class="form-group mb-15 relative"
                :class="{ invalid: !password.isValid }"
            >
                <label class="font-20 main-color mb-10">كلمة المرور</label>
                <input
                    class="form-control font-18 holder-center w-100 password-input"
                    @blur="checkValidity"
                    v-model.trim="password.val"
                    id="password"
                    placeholder="xxxxxx"
                />
                <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <!-- <div class="form-group">
                <label class="checkbox main-color font-16">
                    <input type="checkbox" name="checkbox-checked" checked />
                    تذكرني
                </label>
            </div> -->
            <button
                class="btn mt-30 border-0 pointer flex-all white m-side-auto font-17"
            >
                تسجيل الدخول
            </button>
            <div
                class="main-color mt-15 pointer"
                v-if="viaPhone"
                @click="changeLoginMethod"
            >
                تسجيل الدخول عبر البريد الإلكتروني
            </div>
            <div
                class="main-color mt-15 pointer"
                @click="changeLoginMethod"
                v-else
            >
                تسجيل الدخول عن طريق رقم الهاتف
            </div>
        </form>
    </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

import phoneNumberMixin from "./../../mixins/phoneNumber.js";
export default {
    emits: ["save-form"],
    mixins: [phoneNumberMixin],
    created() {
        this.getUserCountry()
    },
    data() {
        return {
            email: {
                val: "",
                isValid: true
            },
            password: {
                val: "",
                isValid: true
            },
            viaPhone: true,
            countryCode: "",
            formIsValid: true
        };
    },
    methods: {
        async getUserCountry() {
            await this.$store.dispatch('user/getCountryCode');
            this.countryCode = this.$store.getters['user/countryCode']
        },
        changeLoginMethod() {
            this.viaPhone = !this.viaPhone;
            this.phoneNumber.val = ""
            this.phoneNumber.input = ""
            this.email.val = ""
        },
        validateForm() {
            this.formIsValid = true;
            if (this.viaPhone) {
                if (this.phoneNumber.val == "") {
                    this.phoneNumber.isValid = false;
                    this.formIsValid = false;
                }
            } else {
                if (this.email.val == "") {
                    this.email.isValid = false;
                    this.formIsValid = false;
                }
            }
            if (this.password.val == "") {
                this.password.isValid = false;
                this.formIsValid = false;
            }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
        },
        submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            let phone = this.phoneNumber.val;
            if (!this.viaPhone) {
                phone = this.email.val;
            }
            this.$emit("save-form", {
                phone: phone,
                password: this.password.val
            });
        }
    },
    components: { VuePhoneNumberInput }
};
</script>

<style scoped>
.user-input,
.password-input {
    background-image: url(/images/logo.png);
    background-repeat: no-repeat;
    background-size: 40px 40px;
    background-position: 20px center;
}
.password-input {
    background-image: url(/images/logo.png);
}
.form-control {
    padding-right: 20px;
    padding-left: 70px;
}
.checkbox {
    font-family: system-ui, sans-serif;
    font-weight: bold;
    line-height: 1.1;
    display: flex;
    cursor: pointer;
    align-items: center;
}
input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    margin: 0;
    width: 25px;
    height: 25px;
    border: 1px solid #660066;
    border-radius: 3px;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
    margin-left: 12px;
}

input[type="checkbox"]::before {
    content: "";
    width: 15px;
    height: 15px;
    -webkit-clip-path: polygon(
        14% 44%,
        0 65%,
        50% 100%,
        100% 16%,
        80% 0%,
        43% 62%
    );
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    transform: scale(0);
    transform-origin: bottom left;
    transition: 120ms transform ease-in-out;
    /* Windows High Contrast Mode */
    background-color: CanvasText;
}

input[type="checkbox"]:checked::before {
    transform: scale(1);
}
</style>
