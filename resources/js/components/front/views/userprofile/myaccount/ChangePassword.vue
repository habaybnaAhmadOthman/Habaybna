<template>
    <alert-dialog :show="show" title="تغيير كلمة المرور" @close="closeModal">
        <template>
            <div
                v-if="from == 'change'"
                class="form-group mb-15"
                :class="{ invalid: !oldPassword.isValid }"
            >
                <input
                    class="form-control"
                    type="text"
                    id="oldPassword"
                    placeholder="كلمة السر القديمة"
                    v-model="oldPassword.val"
                    @blur="checkValidity"
                />
                <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div
                class="form-group relative pass-group mb-15"
                :class="{ invalid: !password.isValid }"
            >
                <input
                    :type="!password.show ? 'password' : ''"
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    placeholder="كلمة السر الجديدة"
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
                <div class="check-pass" v-if="!password.isValid">
                    <small
                        class="d-block relative"
                        v-if="!password.has_minimum_lenth"
                        >يجب أن لا تقل كلمة السر عن ٦ خانات</small
                    >
                </div>
                <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div
                v-if="from == 'forget'"
                class="form-group mb-15"
                :class="{ invalid: !rePassword.isValid }"
            >
                <input
                    class="form-control"
                    type="password"
                    id="rePassword"
                    placeholder="تأكيد كلمة السر"
                    v-model="rePassword.val"
                    @blur="checkValidity"
                />
                <p class="main-color mt-5 font-12">كلمة السر غير متطابقة</p>
            </div>
        </template>
        <template #actions>
            <button v-if="from == 'change'" class="btn ml-25" @click="closeModal">إغلاق</button>
            <button class="btn" @click="submitForm">حفظ</button>
        </template>
    </alert-dialog>
</template>

<script>
import passwordMixin from "../../../mixins/password.js";
import loadingMixin from "../../../mixins/loading.js";
export default {
    emits: ["close-password-modal", "alert-password-modal"],
    mixins: [passwordMixin, loadingMixin],
    props: ["show", "from","mobileNumber"],
    data() {
        return {
            isOpened: true,
            oldPassword: {
                isValid: true,
                val: "",
            },
            rePassword: {
                isValid: true,
                val: "",
            },
        };
    },
    methods: {
        async submitForm() {
            this.passwordCheck();
            debugger;
            if (this.from == "change") {
                this.changePasswordSubmit();
            } else {
                this.forgetPasswordSubmit();
            }
        },
        async forgetPasswordSubmit() {
            if (this.rePassword.val == "" || this.password.val != this.rePassword.val) {
                this.rePassword.isValid = false;
            }
            if (
                !this.rePassword.isValid 
            ) {
                return;
            }
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/changePassword", {
                    password: this.password.val,
                    mobileNumber: this.mobileNumber,
                    from: 'forget'
                });
                this.alertModal(true);
            } catch (e) {
                this.alertModal(false);
            }
            this.isLoading = false;
        },
        async changePasswordSubmit() {
            if (this.oldPassword.val == "") {
                this.oldPassword.isValid = false;
            }
            if (!this.oldPassword.isValid || !this.password.isValid) {
                return;
            }
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/changePassword", {
                    oldPassword: this.oldPassword.val,
                    newPassword: this.password.val,
                });
                this.alertModal(true);
            } catch (e) {
                this.alertModal(false);
            }
            this.isLoading = false;
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
            if (e.target.id == "password") {
                this.passwordCheck();
            }
            if (e.target.id == "rePassword" && this.password.val != this.rePassword.val) {
                this.rePassword.isValid = false;
            }
        },
        alertModal(isShow) {
            this.clearFields();
            this.$emit("alert-password-modal", isShow);
        },
        closeModal() {
            this.clearFields();
            this.$emit("close-password-modal");
        },
        clearFields() {
            this.password.val = "";
            this.oldPassword.val = "";
            this.password.has_minimum_lenth = false;
            // this.password.has_number = false;
            // this.password.has_lowercase = false;
            // this.password.has_uppercase = false;
            // this.password.has_special = false;
        },
    },
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
