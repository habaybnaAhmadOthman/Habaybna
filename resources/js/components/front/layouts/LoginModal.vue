<template>
    <portal to="destination">
        <aside>
            <div
                v-if="showModal"
                class="w-100 h-100 backdrop"
                @click="closeLoginModal"
            ></div>
            <transition name="modal">
                <dialog class="login-modal w-90-p" v-if="showModal" open>
                    <img
                        src="/images/close-icon-color.png"
                        @click="closeLoginModal"
                        class="close-modal-icon"
                        width="24"
                        height="24"
                    />

                    <form class="login-form" @submit.prevent="submitForm">
                        <template>
                            <p class="font-27 bold pr-10 main-color mb-40 font-20-p mb-20-p">تسجيل الدخول</p>
                            <div
                                v-if="viaPhone"
                                class="form-group ltr mb-20 input-box"
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
                                <p class="main-color mt-5 font-12 req">
                                    رقم الهاتف غير صحيح
                                </p>
                            </div>
                            <div v-else>
                                <div
                                    class="form-group mb-20 input-box relative"
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
                                    <p class="main-color mt-5 font-12 req">
                                        هذا الحقل مطلوب
                                    </p>
                                </div>
                            </div>
                        </template>
                        <!-- password -->
                        
                        <div
                            class="form-group relative pass-group mb-20 input-box mb-10-p"
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
                        <div class="d-flex space-between mb-40 flex-wrap-p mb-10-p">
                            <router-link class="main-color font-20 bold mb-10-p font-16-p" to="/"
                                >هل نسيت كلمة السر؟</router-link
                            >
                            <p class="black-2 bold font-20 font-16-p">
                                هل أنت مستخدم جديد؟
                                <router-link class="main-color pr-10 p-0-p" to="/register"
                                    >سجل من هنا</router-link
                                >
                            </p>
                        </div>
                        <input type="submit" class="main-bg white submit-btn font-20 bold flex-all pointer font-16-p" value="تسجيل دخول">
                        <div
                            class="main-color mt-15 pointer center-p"
                            v-if="viaPhone"
                            @click="changeLoginMethod"
                        >
                            تسجيل الدخول عبر البريد الإلكتروني
                        </div>
                        <div
                            class="main-color mt-15 mt-10-p pointer center-p"
                            @click="changeLoginMethod"
                            v-else
                        >
                            تسجيل الدخول عن طريق رقم الهاتف
                        </div>
                    </form>

                </dialog>
            </transition>
            <alert-dialog
                :show="!!error"
                :title="error"
                @close="closeModal"
            >
            <template v-if="isBanned" #actions>
                <router-link to="/contact-us" class="btn mb-10 ml-10">
                    اضغط هنا للمتابعة
                </router-link>
            </template>
            </alert-dialog>
            <div v-if="isLoading">
                <loading-spinner></loading-spinner>
            </div>
        </aside>
    </portal>
</template>

<script>
import loadingMixin from "../mixins/loading";
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

import phoneNumberMixin from "../mixins/phoneNumber";
import passwordMixin from "../mixins/password.js";

export default {
    mixins: [loadingMixin, phoneNumberMixin, passwordMixin],
    components: { VuePhoneNumberInput },
    computed: {
        showModal() {
            return this.$store.getters["loginModal"];
        }
    },
    data: () => ({
        email: {
            val: "",
            isValid: true
        },
        viaPhone: true,
        formIsValid: true,
        isBanned: false
    }),
    methods: {
        changeLoginMethod() {
            this.viaPhone = !this.viaPhone;
            this.phoneNumber.val = "";
            this.phoneNumber.input = "";
            this.email.val = "";
        },
        closeLoginModal() {
            this.$store.commit("loginModal", false);
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
        async submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            let phone = this.phoneNumber.val;
            if (!this.viaPhone) {
                phone = this.email.val;
            }

            this.isLoading = true;
            this.isBanned = false
            try {
                await this.$store.dispatch("user/loginModal", {
                    phone: phone,
                    password: this.password.val
                });
                const userType = this.$store.getters["user/type"];

                if (userType == "admin") {
                    window.location.href = "/admin";
                } else {
                    this.$store.commit("forceRefresh");
                }
            } catch (e) {
                if (e.message == 'تم إيقاف حسابك') { 
                    this.isBanned = true
                }
                this.showPopupMessage(e.message);
            }
            this.isLoading = false;
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10000;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 3%;
    left: 10%;
    z-index: 10000000;
    right: 0;
    left: 0;
    margin: auto;
    width: 900px;
    height: 582px;
    background: #fafafa;
    box-shadow: 0px 3px 6px #00000029;
    border: 1px solid #707070;
    border-radius: 10px;
    overflow-y: auto;
}

.modal-enter-active {
    animation: modal 0.3s ease-out;
}

.modal-leave-active {
    animation: modal 0.3s ease-in reverse;
}
.close-modal-icon {
    position: absolute;
    top: 35px;
    right: 40px;
    cursor: pointer;
}
.login-form {
    padding: 90px 150px 100px 150px;
}
.input-box input {
    background: #ffffff 0% 0% no-repeat padding-box;
    box-shadow: 0px 1px 3px #00000029;
    border: 1px solid #c6c6c6;
    border-radius: 10px;
    height: 60px;
    color: #939598;
    font-size: 20px;
    padding: 20px;
    width: 100%;
}
.submit-btn {
    width: 100%;
    border-radius: 25px;
    border: 0;
    height: 50px;
}
@keyframes modal {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
.req {
    display: none;
}
.input-box.invalid .req {
    display: block;
}
input::placeholder {
    color:#939598!important;
}
.input-box.invalid .req {
    text-align: right;
}
@media (max-width: 767px) {
    .close-modal-icon {
        left: 18px;
        right: auto;
        top: 18px;
    }
    .login-form {
        padding: 20px 12px 20px 12px;
    }
    .input-box input {
        font-size: 16px!important;
    }
    dialog {
        height: auto;
        padding: 0;
    }
}
</style>
<style>
.login-modal .country-selector__input:not(.no-country-selector) {
    border-color:#c6c6c6!important;
    border-radius: 0 10px 10px 0!important;
}
.login-modal .country-selector,.login-modal .country-selector__input,.login-modal .input-tel__input {
    height: 60px !important;
}
.login-modal #phoneNumber-8_country_selector,.login-modal .input-tel__input {
    border-color:#c6c6c6!important;
}
.login-modal .input-tel__input:not(.no-country-selector) {
    border-top-left-radius: 10px!important;
    border-bottom-left-radius: 10px!important;
}
.login-modal .vue-phone-number-input {
    box-shadow: 0px 1px 3px #00000029;
    border-radius: 10px;
}
@media (max-width: 767px) {
    .country-selector__list {
        right: 0!important;
    }
    .lang-en .country-selector__list {
        right: auto!important;
        left: 0!important;
    }
}
</style>
<style scoped>
.pass-visible {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTIuMDE1IDdjNC43NTEgMCA4LjA2MyAzLjAxMiA5LjUwNCA0LjYzNi0xLjQwMSAxLjgzNy00LjcxMyA1LjM2NC05LjUwNCA1LjM2NC00LjQyIDAtNy45My0zLjUzNi05LjQ3OC01LjQwNyAxLjQ5My0xLjY0NyA0LjgxNy00LjU5MyA5LjQ3OC00LjU5M3ptMC0yYy03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzNC44MzUgNy40NDkgMTIuMDE1IDcuNDQ5YzcuNzMzIDAgMTEuOTg1LTcuNDQ5IDExLjk4NS03LjQ0OXMtNC4yOTEtNi41NTEtMTEuOTg1LTYuNTUxem0tLjAxNSAzYy0yLjIwOSAwLTQgMS43OTItNCA0IDAgMi4yMDkgMS43OTEgNCA0IDRzNC0xLjc5MSA0LTRjMC0yLjIwOC0xLjc5MS00LTQtNHoiLz48L3N2Zz4=)
        no-repeat center;
    position: absolute;
    left: 5px;
    width: 30px;
    height: 30px;
    top: 0;
    bottom :0;
    margin: auto;
}
.pass-visible.active {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTkuNjA0IDIuNTYybC0zLjM0NiAzLjEzN2MtMS4yNy0uNDI4LTIuNjg2LS42OTktNC4yNDMtLjY5OS03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzMS45MjggMi45NTEgNS4xNDYgNS4xMzhsLTIuOTExIDIuOTA5IDEuNDE0IDEuNDE0IDE3LjM3LTE3LjAzNS0xLjQxNS0xLjQxNXptLTYuMDE2IDUuNzc5Yy0zLjI4OC0xLjQ1My02LjY4MSAxLjkwOC01LjI2NSA1LjIwNmwtMS43MjYgMS43MDdjLTEuODE0LTEuMTYtMy4yMjUtMi42NS00LjA2LTMuNjYgMS40OTMtMS42NDggNC44MTctNC41OTQgOS40NzgtNC41OTQuOTI3IDAgMS43OTYuMTE5IDIuNjEuMzE1bC0xLjAzNyAxLjAyNnptLTIuODgzIDcuNDMxbDUuMDktNC45OTNjMS4wMTcgMy4xMTEtMi4wMDMgNi4wNjctNS4wOSA0Ljk5M3ptMTMuMjk1LTQuMjIxcy00LjI1MiA3LjQ0OS0xMS45ODUgNy40NDljLTEuMzc5IDAtMi42NjItLjI5MS0zLjg1MS0uNzM3bDEuNjE0LTEuNTgzYy43MTUuMTkzIDEuNDU4LjMyIDIuMjM3LjMyIDQuNzkxIDAgOC4xMDQtMy41MjcgOS41MDQtNS4zNjQtLjcyOS0uODIyLTEuOTU2LTEuOTktMy41ODctMi45NTJsMS40ODktMS40NmMyLjk4MiAxLjkgNC41NzkgNC4zMjcgNC41NzkgNC4zMjd6Ii8+PC9zdmc+)
        no-repeat center;
}
.pass-group .check-pass small:before {
    content: "x";
    color: #f44336;
    font-weight: bold;
    margin-left: 5px;
}
</style>