<template>
    <div class="mobile-form pt-50 p-side-50">
        <h2 class="white font-22 bold d-flex align-center">
            رمز التحقق
            <img src="/images/siteImgs/header/logo.png" class="mr-10" />
        </h2>
        <form @submit.prevent="submitCode" class="mt-30">
            <p class="white font-14 center mb-15">تم ارسال رمز التحقق برسالة نصية</p>
            <div class="form-group" :class="{ invalid: !code.isValid }">
                <input
                    class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                    placeholder="أدخل رمز التحقق"
                    id="code"
                    @blur="checkValidity"
                    v-model.trim="code.val"
                />
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div class="">
                <p
                    class="white mt-5 font-12"
                    v-if="!canResend && this.otp.availableTry > 0"
                >
                    يمكنك إعادة إرسال رمز التحقق بعد
                    <span class="bold">{{ otp.secondsLeft }}</span>
                </p>
                <p
                    @click="resendOtp"
                    class="pointer underline white mt-10 font-12"
                    v-else-if="canResend"
                >
                    إعادة إرسال الرمز
                </p>
            </div>
            <button
                class="btn-img bg-none mt-30 border-0 pointer flex-all white m-side-auto font-20"
                id="sign-in-button"
            >
                التالي <img src="/images/siteImgs/header/logo.png" class="mr-10">
            </button>
            <div v-if="isLoading">
                <loading-spinner></loading-spinner>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    emits: ["error-happen", "complete-registration-form", "send-otp"],
    data() {
        return {
            isLoading: false,
            code: {
                val: "",
                isValid: true,
                showForm: false
            },
            otp: {
                canResend: false,
                availableTry: 3,
                secondsLeft: 10
            },
            error: null
        };
    },
    mounted() {
        this.countDown();
    },
    computed: {
        canResend() {
            return this.otp.canResend && this.otp.availableTry > 0;
        }
    },
    methods: {
        countDown() {
            if (this.otp.availableTry > 0) {
                const resendInterval = setInterval(() => {
                    this.otp.secondsLeft -= 1;
                    if (this.otp.secondsLeft == 0) {
                        this.otp.canResend = true;
                        this.otp.secondsLeft = 10;
                        clearInterval(resendInterval);
                    } else {
                        this.otp.canResend = false;
                    }
                }, 1000);
            } else {
                this.otp.canResend = false;
            }
        },
        resendOtp() {
            this.otp.canResend = true;
            this.otp.availableTry -= 1;
            this.countDown();
            this.$emit("send-otp", {});
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
        },
        async submitCode() {
            if (this.code.val == "") {
                this.code.isValid = false;
                return;
            }
            this.isLoading = true;
            await window.confirmationResult
                .confirm(this.code.val)
                .then(result => {
                    // User signed in successfully.
                    const user = result.user;
                    this.$emit("complete-registration-form",{code: this.code.val});
                    // ...
                })
                .catch(error => {
                    this.$emit("error-happen", "حدث خطأ ما");
                });
            this.isLoading = false;
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
.form-control {
    border: 1px solid #606;
    height: 52px;
}
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgb(121 106 238 / 25%);
}
.spinner {
    z-index: 10!important;
}
</style>
