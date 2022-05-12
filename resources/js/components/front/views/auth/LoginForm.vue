<template>
    <div class="mobile-form p-side-50 p-side-12-p">
        <h2 class="main-color font-40 bold center mb-10 font-28-p d-flex-p space-between">
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
            <!-- password -->
            <div
                class="form-group relative pass-group mb-15"
                :class="{ invalid: !password.isValid }"
            >
                <input
                    :type="!password.show ? 'password' : ''"
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    placeholder="كلمة السر"
                    id="password"
                    @blur="checkValidity"
                    v-model.trim="password.val"
                />
                <div
                    class="pass-visible pointer"
                    :class="{ active: !password.show }"
                    @click="passwordVisibility"
                ></div>
                <p class="main-color mt-5 font-12">
                    هذا الحقل مطلوب
                </p>
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
            <div class="d-flex flex-wrap space-between">
                <template>
                    <div
                        class="main-color mt-15 pointer center-p font-13 bold"
                        v-if="viaPhone"
                        @click="changeLoginMethod"
                    >
                        تسجيل الدخول عبر البريد الإلكتروني
                    </div>
                    <div
                        class="main-color mt-15 pointer center-p font-13 bold"
                        @click="changeLoginMethod"
                        v-else
                    >
                        تسجيل الدخول عن طريق رقم الهاتف
                    </div>
                </template>
                <div class="blue mt-15 pointer center-p font-13">
                    <router-link to="/forget-password">نسيت كلمة المرور</router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

import phoneNumberMixin from "./../../mixins/phoneNumber.js";
import passwordMixin from "./../../mixins/password.js";
export default {
    emits: ["save-form"],
    mixins: [phoneNumberMixin, passwordMixin],
    data() {
        return {
            email: {
                val: "",
                isValid: true
            },
            viaPhone: true,
            formIsValid: true
        };
    },
    methods: {
        changeLoginMethod() {
            this.viaPhone = !this.viaPhone;
            this.phoneNumber.val = "";
            this.phoneNumber.input = "";
            this.email.val = "";
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
    background-image: url(/images/user-icon-red.svg);
    background-repeat: no-repeat;
    background-size: 25px 25px;
    background-position: 10px center;
}
.password-input {
    background-image: url(/images/logo.png);
}
.form-control {
    padding-right: 20px;
    padding-left: 70px;
}
.checkbox {
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
.pass-visible {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTIuMDE1IDdjNC43NTEgMCA4LjA2MyAzLjAxMiA5LjUwNCA0LjYzNi0xLjQwMSAxLjgzNy00LjcxMyA1LjM2NC05LjUwNCA1LjM2NC00LjQyIDAtNy45My0zLjUzNi05LjQ3OC01LjQwNyAxLjQ5My0xLjY0NyA0LjgxNy00LjU5MyA5LjQ3OC00LjU5M3ptMC0yYy03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzNC44MzUgNy40NDkgMTIuMDE1IDcuNDQ5YzcuNzMzIDAgMTEuOTg1LTcuNDQ5IDExLjk4NS03LjQ0OXMtNC4yOTEtNi41NTEtMTEuOTg1LTYuNTUxem0tLjAxNSAzYy0yLjIwOSAwLTQgMS43OTItNCA0IDAgMi4yMDkgMS43OTEgNCA0IDRzNC0xLjc5MSA0LTRjMC0yLjIwOC0xLjc5MS00LTQtNHoiLz48L3N2Zz4=)
        no-repeat center;
    position: absolute;
    left: 5px;
    width: 30px;
    height: 30px;
    top: 12px;
    margin: auto;
}
.pass-visible.active {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTkuNjA0IDIuNTYybC0zLjM0NiAzLjEzN2MtMS4yNy0uNDI4LTIuNjg2LS42OTktNC4yNDMtLjY5OS03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzMS45MjggMi45NTEgNS4xNDYgNS4xMzhsLTIuOTExIDIuOTA5IDEuNDE0IDEuNDE0IDE3LjM3LTE3LjAzNS0xLjQxNS0xLjQxNXptLTYuMDE2IDUuNzc5Yy0zLjI4OC0xLjQ1My02LjY4MSAxLjkwOC01LjI2NSA1LjIwNmwtMS43MjYgMS43MDdjLTEuODE0LTEuMTYtMy4yMjUtMi42NS00LjA2LTMuNjYgMS40OTMtMS42NDggNC44MTctNC41OTQgOS40NzgtNC41OTQuOTI3IDAgMS43OTYuMTE5IDIuNjEuMzE1bC0xLjAzNyAxLjAyNnptLTIuODgzIDcuNDMxbDUuMDktNC45OTNjMS4wMTcgMy4xMTEtMi4wMDMgNi4wNjctNS4wOSA0Ljk5M3ptMTMuMjk1LTQuMjIxcy00LjI1MiA3LjQ0OS0xMS45ODUgNy40NDljLTEuMzc5IDAtMi42NjItLjI5MS0zLjg1MS0uNzM3bDEuNjE0LTEuNTgzYy43MTUuMTkzIDEuNDU4LjMyIDIuMjM3LjMyIDQuNzkxIDAgOC4xMDQtMy41MjcgOS41MDQtNS4zNjQtLjcyOS0uODIyLTEuOTU2LTEuOTktMy41ODctMi45NTJsMS40ODktMS40NmMyLjk4MiAxLjkgNC41NzkgNC4zMjcgNC41NzkgNC4zMjd6Ii8+PC9zdmc+)
        no-repeat center;
}
</style>