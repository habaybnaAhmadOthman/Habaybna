<template>
    <form @submit.prevent="submitForm" class="card-body">
        <div class="form-group">
            <label class="form-control-label">الاسم كامل</label>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group m-0-i" :class="{ invalid: !firstName.isValid }">
                        <input class="form-control" placeholder="الإسم الأول" 
                        id="firstName"
                        @blur="checkValidity"
                        v-model.trim="firstName.val" />
                        <p class="main-color mt-5 font-12">
                            لا يمكنك ترك هذا الحقل فارغ
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group m-0-i" :class="{ invalid: !lastName.isValid }">
                        <input class="form-control" placeholder="العائلة" 
                        id="lastName"
                        @blur="checkValidity"
                        v-model.trim="lastName.val"
                        />
                        <p class="main-color mt-5 font-12">
                            لا يمكنك ترك هذا الحقل فارغ
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group m-0-i" :class="{ invalid: !email.isValid }">
                        <label class="form-control-label">البريد الإلكتروني</label>
                        <input class="form-control" placeholder="البريد الإلكتروني" 
                        id="email"
                        @blur="checkValidity"
                        v-model.trim="email.val"
                        />
                        <p class="main-color mt-5 font-12">
                            لا يمكنك ترك هذا الحقل فارغ
                        </p>
                    </div>            
                    
                </div>
                <div class="col-md-4">
                    <label class="form-control-label">رقم الهاتف</label>
                    <div
                        class=" ltr"
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
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-control-label">سنة الميلاد</label>
                    <input class="form-control" placeholder="1999" v-model="birthdate.val" />
                </div>
                <div class="col-md-4">
                    <div class="form-group m-0-i">
                        <label class="form-control-label">الجنس</label>
                        <select class="form-control" id="gender" v-model="gender.val" >
                            <option value="no" disabled hidden>الجنس</option>
                            <option value="m">ذكر</option>
                            <option value="f">أنثى</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-control-label">صلة القرابة</label>
                    <select class="form-control" id="relative" v-model="relative.val">
                        <option value="no" disabled hidden>صلة القرابة</option>
                        <option value="parent">أب / أم</option>
                        <option value="brother">أخ / آخت</option>
                        <option value="relative">أقرباء</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-control-label">البلد</label>
                    <input class="form-control" placeholder="البلد" v-model="country.val" />
                </div>
                <div class="col-md-4">
                    <label class="form-control-label">المدينة</label>
                    <input class="form-control" placeholder="المدينة" v-model="city.val" />
                </div>
                <div class="col-md-4">
                    <label class="form-control-label">عدد الأبناء</label>
                    <input
                        type="number"
                        class="form-control"
                        placeholder="عدد الأبناء"
                        v-model.trim="noChilds.val"
                    />
                </div>
            </div>
        </div>
        <div class="form-group admin-control">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-control-label">الإهتمامات</label>
                    <multiselect
                        v-model="tags"
                        :options="interestsList"
                        :searchable="true"
                        :close-on-select="false"
                        :multiple="true"
                        :taggable="true"
                        label="title"
                        track-by="title"
                        placeholder="يرجى إختيار الإهتمامات"
                    ></multiselect>
                    <p class="main-color mt-5 font-12" v-if="!tagsValid">
                            لا يمكنك ترك هذا الحقل فارغ
                    </p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn-2 mt-30 flex-all m-side-auto font-20">حفظ</button>
                </div>
            </div>
        </div>
    </form>
</template>
<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
// mixins
import phoneNumberMixin from "../../../mixins/phoneNumber.js";
import passwordMixin from "../../../mixins/password.js";
export default {
    emits: ["submit-form"],
    mixins: [phoneNumberMixin, passwordMixin],
    components: { Multiselect, VuePhoneNumberInput },
    props: ["interestsList"],
    data() {
        return {
            tags: "",
            tagsValid: true,
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
            country: {
                val: "",
                isValid: true
            },
            city: {
                val: "",
                isValid: true
            },
            birthdate: {
                val: "",
                isValid: true
            },
            noChilds: {
                val: "",
                isValid: true
            },
            formIsValid: true,
        };
    },
    methods: {
        validateForm() {
            this.formIsValid = true;
            this.tagsValid = true;
            if (this.firstName.val == "") {
                this.firstName.isValid = false;
                this.formIsValid = false;
            }
            if (this.lastName.val == "") {
                this.lastName.isValid = false;
                this.formIsValid = false;
            }
            if (this.email.val == "") {
                this.email.isValid = false;
                this.formIsValid = false;
            }
            // if (this.tags.length < 1) {
            //     this.tagsValid = false;
            // }
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

            // let tagIDs = [];
            // this.tags.forEach(item => tagIDs.push(item.id));
            
            this.$emit("submitForm", {
                firstName: this.firstName.val,
                lastName: this.lastName.val,
                email: this.email.val,
                gender: this.gender.val,
                relative: this.relative.val,
                country: this.country.val,
                city: this.city.val,
                birthdate: this.birthdate.val,
                noChilds: this.noChilds.val,
                interests: [],
            });
        }
    }
};
</script>
<style scoped>
.profile .pass-visible {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTIuMDE1IDdjNC43NTEgMCA4LjA2MyAzLjAxMiA5LjUwNCA0LjYzNi0xLjQwMSAxLjgzNy00LjcxMyA1LjM2NC05LjUwNCA1LjM2NC00LjQyIDAtNy45My0zLjUzNi05LjQ3OC01LjQwNyAxLjQ5My0xLjY0NyA0LjgxNy00LjU5MyA5LjQ3OC00LjU5M3ptMC0yYy03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzNC44MzUgNy40NDkgMTIuMDE1IDcuNDQ5YzcuNzMzIDAgMTEuOTg1LTcuNDQ5IDExLjk4NS03LjQ0OXMtNC4yOTEtNi41NTEtMTEuOTg1LTYuNTUxem0tLjAxNSAzYy0yLjIwOSAwLTQgMS43OTItNCA0IDAgMi4yMDkgMS43OTEgNCA0IDRzNC0xLjc5MSA0LTRjMC0yLjIwOC0xLjc5MS00LTQtNHoiLz48L3N2Zz4=)
        no-repeat center;
    position: absolute;
    left: 5px;
    width: 30px;
    height: 30px;
    top: 5px;
    margin: auto;
}
.profile .pass-visible.active {
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTkuNjA0IDIuNTYybC0zLjM0NiAzLjEzN2MtMS4yNy0uNDI4LTIuNjg2LS42OTktNC4yNDMtLjY5OS03LjU2OSAwLTEyLjAxNSA2LjU1MS0xMi4wMTUgNi41NTFzMS45MjggMi45NTEgNS4xNDYgNS4xMzhsLTIuOTExIDIuOTA5IDEuNDE0IDEuNDE0IDE3LjM3LTE3LjAzNS0xLjQxNS0xLjQxNXptLTYuMDE2IDUuNzc5Yy0zLjI4OC0xLjQ1My02LjY4MSAxLjkwOC01LjI2NSA1LjIwNmwtMS43MjYgMS43MDdjLTEuODE0LTEuMTYtMy4yMjUtMi42NS00LjA2LTMuNjYgMS40OTMtMS42NDggNC44MTctNC41OTQgOS40NzgtNC41OTQuOTI3IDAgMS43OTYuMTE5IDIuNjEuMzE1bC0xLjAzNyAxLjAyNnptLTIuODgzIDcuNDMxbDUuMDktNC45OTNjMS4wMTcgMy4xMTEtMi4wMDMgNi4wNjctNS4wOSA0Ljk5M3ptMTMuMjk1LTQuMjIxcy00LjI1MiA3LjQ0OS0xMS45ODUgNy40NDljLTEuMzc5IDAtMi42NjItLjI5MS0zLjg1MS0uNzM3bDEuNjE0LTEuNTgzYy43MTUuMTkzIDEuNDU4LjMyIDIuMjM3LjMyIDQuNzkxIDAgOC4xMDQtMy41MjcgOS41MDQtNS4zNjQtLjcyOS0uODIyLTEuOTU2LTEuOTktMy41ODctMi45NTJsMS40ODktMS40NmMyLjk4MiAxLjkgNC41NzkgNC4zMjcgNC41NzkgNC4zMjd6Ii8+PC9zdmc+)
        no-repeat center;
}
.profile .pass-group .check-pass small:before {
    content: "x";
    color: #f44336;
    font-weight: bold;
    margin-left: 5px;
}
</style>
