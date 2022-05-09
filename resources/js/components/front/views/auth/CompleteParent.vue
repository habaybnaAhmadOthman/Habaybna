<template>
    <form @submit.prevent="submitForm" class="p-side-50">
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        <h2 class="main-color text-shadow font-40 bold center mb-30 font-28-p">
            أكمل معلوماتك
        </h2>
        <div class="d-flex space-between">
            <!-- firstName -->
            <div
                class="form-group row-half"
                :class="{ invalid: !firstName.isValid }"
            >
                <input
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    placeholder="الإسم الأول"
                    id="firstName"
                    @blur="checkValidity"
                    v-model.trim="firstName.val"
                />
                <p class="main-color mt-5 font-12">
                    هذا الحقل مطلوب
                </p>
            </div>
            <!-- lastName -->
            <div
                class="form-group row-half"
                :class="{ invalid: !lastName.isValid }"
            >
                <input
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    placeholder="إسم العائلة"
                    id="lastName"
                    @blur="checkValidity"
                    v-model.trim="lastName.val"
                />
                <p class="main-color mt-5 font-12">
                    هذا الحقل مطلوب
                </p>
            </div>
        </div>
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
                @input="passwordCheck"
                @focus="password.isValid = false"
                @blur="checkValidity"
                v-model.trim="password.val"
            />
            <div
                class="pass-visible pointer"
                :class="{ active: !password.show }"
                @click="passwordVisibility"
            ></div>
            <!-- <small>يجب أن تحتوي كلمة السر على أرقام و رموز خاصة و ان لا تقل عن ٨ خانات و احرف كبيرة وصغيرة</small> -->
            <div class="check-pass" v-if="!password.isValid">
                <small
                    class="d-block relative"
                    v-if="!password.has_minimum_lenth"
                    >يجب أن لا تقل كلمة السر عن ٦ خانات</small
                >
            </div>
            <p class="main-color mt-5 font-12">
                هذا الحقل مطلوب
            </p>
        </div>
        <!-- email -->
        <div class="form-group mb-15" :class="{ invalid: !email.isValid }">
            <input
                type="email"
                class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                placeholder="البريد الالكتروني"
                id="email"
                autocomplete="off"
                @blur="checkValidity"
                v-model.trim="email.val"
                oninvalid="this.setCustomValidity('يرجى إدخال بريد إلكتروني صحيح')"
                oninput="setCustomValidity('')"
            />
            <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
        </div>

        <div class="d-flex space-between">
            <!-- gender -->
            <div
                class="form-group row-half"
                :class="{ invalid: !gender.isValid }"
            >
                <div class="select-wrapper relative">
                    <select
                        class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                        v-model="gender.val"
                        id="gender"
                        @blur="checkValidity"
                    >
                        <option value="no" disabled hidden>الجنس</option>
                        <option value="m">ذكر</option>
                        <option value="f">أنثى</option>
                    </select>
                </div>
                <p class="main-color mt-5 font-12">
                    هذا الحقل مطلوب
                </p>
            </div>
            <!-- relative -->
            <div
                class="form-group row-half mb-15"
                :class="{ invalid: !relative.isValid }"
            >
                <div class="select-wrapper relative">
                    <select
                        class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                        v-model="relative.val"
                        id="relative"
                        @blur="checkValidity"
                    >
                        <option value="no" disabled hidden>صلة القرابة</option>
                        <option value="parent">أب / أم</option>
                        <option value="brother">أخ / آخت</option>
                        <option value="relative">أقرباء</option>
                    </select>
                </div>
                <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
        </div>

        <button class="btn-2 mt-30 flex-all m-side-auto font-20">
            إتمام التسجيل
        </button>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </form>
</template>

<script>
import LoadingSpinner from "../../layouts/LoadingSpinner.vue";

import passwordMixin from "./../../mixins/password.js";
export default {
    mixins: [passwordMixin],
    methods: {
        validateForm() {
            this.formIsValid = true;
            if (this.firstName.val == "") {
                this.firstName.isValid = false;
                this.formIsValid = false;
            }
            if (this.lastName.val == "") {
                this.lastName.isValid = false;
                this.formIsValid = false;
            }
            if (this.password.val == "") {
                this.password.isValid = false;
                this.formIsValid = false;
            }
            if (this.email.val == "") {
                this.email.isValid = false;
                this.formIsValid = false;
            }
            if (this.gender.val == "no") {
                this.gender.isValid = false;
                this.formIsValid = false;
            }
            if (this.relative.val == "no") {
                this.relative.isValid = false;
                this.formIsValid = false;
            }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
            if (e.target.id == "gender" || e.target.id == "relative") {
                if (e.target.value == "no") {
                    this[e.target.id].isValid = false;
                } else {
                    this[e.target.id].isValid = true;
                }
            }
            if (e.target.id == "password") {
                this.passwordCheck();
            }
        },
        submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            this.$emit("complete-registration", {
                firstName: this.firstName.val,
                lastName: this.lastName.val,
                password: this.password.val,
                email: this.email.val,
                gender: this.gender.val,
                relative: this.relative.val
            });
        }
    },
    data() {
        return {
            firstName: {
                val: "",
                isValid: true
            },
            lastName: {
                val: "",
                isValid: true
            },
            email: {
                val: "",
                isValid: true
            },
            gender: {
                val: "no",
                isValid: true
            },
            relative: {
                val: "no",
                isValid: true
            },
            formIsValid: true,
            isLoading: false
        };
    },
    components: { LoadingSpinner }
};
</script>

<style scoped>
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
    color: #757575;
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
.pass-group .check-pass small:before {
    content: "x";
    color: #f44336;
    font-weight: bold;
    margin-left: 5px;
}
</style>
