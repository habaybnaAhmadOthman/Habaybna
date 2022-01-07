<template>
    <div class="mobile-form p-side-50 p-side-12-p">
        <h2 class="main-color text-shadow font-40 bold center font-28-p">
            مستخدم جديد
        </h2>
        <form @submit.prevent="submitForm" class="mt-30">
            <div class="form-group mb-30" :class="{ invalid: !type.isValid }">
                <div class="select-wrapper relative">
                    <select
                        class="
            w-100
            p-10
            pointer
            form-control
            trans
            center
          "
                        v-model="type.val"
                        id="type"
                        @blur="checkValidity"
                    >
                        <option value="no" disabled hidden>هل أنت</option>
                        <option value="parent"
                            >أحد الوالدين أو أفراد العائلة</option
                        >
                        <option value="specialist">أخصائي تربية خاصة أو تأهيل</option>
                        <option value="other">آخر</option>
                    </select>
                </div>
                <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div
                class="form-group ltr"
                :class="{ invalid: !phoneNumber.isValid }"
            >
                <VuePhoneNumberInput
                    v-model="phoneNumber.input"
                    @update="getPhoneVal"
                    @input="checkPhoneNumber"
                    :show-code-on-list="true"
                    :translations="{
                        countrySelectorLabel: 'رمز الدولة',
                        phoneNumberLabel: 'رقم الهاتف',
                    }"
                    id="phoneNumber"
                    :default-country-code="countryCode"
                />
                <p class="main-color mt-5 font-12">رقم الهاتف غير صحيح</p>
            </div>
        </form>
    </div>
</template>

<script>


import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

import phoneNumberMixin from './../../mixins/phoneNumber.js';

export default {
    emits: ["send-otp"],
    mixins: [phoneNumberMixin],
    data() {
        return {
            type: {
                val: "no",
                isValid: true
            },
            formIsValid: true
        };
    },
    methods: {
        validateForm() {
            this.formIsValid = true;

            if (this.phoneNumber.val == "") {
                this.phoneNumber.isValid = false;
                this.formIsValid = false;
            }
            if (this.type.val == "no") {
                this.type.isValid = false;
                this.formIsValid = false;
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
        submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            let phoneNumber = this.phoneNumber.val;
            this.$emit("send-otp", { phoneNumber, type: this.type.val });
        }
    },
    components: { VuePhoneNumberInput }
};
</script>
<style>
    .country-selector,.country-selector__input ,.input-tel__input{
        height: 52px !important;;
    }
    .country-selector__country-flag {
        top :29px!important;
    }
    #phoneNumber-8_country_selector,.input-tel__input {
        border-color: #606!important;
    }
</style>
<style scoped>
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
.spinner {
    z-index: 11;
}
</style>
<style>
.country-selector__input {
    border-radius:21px 0 0 21px!important;
    border-color:#606!important;
}
.input-tel__input:not(.no-country-selector) {
    border-radius: 0 21px 21px 0!important;
}
.input-tel.is-focused .input-tel__input {
    box-shadow: 0 0 0 0.2rem rgb(121 106 238 / 25%)!important;
}
</style>
