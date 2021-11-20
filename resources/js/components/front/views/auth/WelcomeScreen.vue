<template>
    <div class="mobile-form pt-50 p-side-50">
        <p class="white font-40 bold center">
            أهلا و سهلاً بك  <br> في عائلة حبايبنا
        </p>
        <form @submit.prevent="">
            
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
                availableTry: 5,
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
                    this.$emit("complete-registration-form");
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
    z-index: 10;
}
</style>
