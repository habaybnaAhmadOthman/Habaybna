<template>
  <div class="mobile-form p-side-50 p-side-12-p">
    <h2 class="main-color font-40 bold center font-28-p">
      رمز التحقق
    </h2>
    <form @submit.prevent="submitCode" class="mt-30">
      <p class="main-color font-14 center mb-15">
        تم ارسال رمز التحقق برسالة نصية
      </p>
      <div class="form-group" :class="{ invalid: !code.isValid }">
        <input
          class="
            bg-main-color
            border-0
            radius-5
            w-100
            p-10
            pointer
            form-control
            trans
          "
          placeholder="أدخل رمز التحقق"
          id="code"
          @blur="checkValidity"
          @input="checkValidity"
          v-model.trim="code.val"
        />
        <!-- <p class="red mt-5 font-12">هذا الحقل مطلوب</p> -->
      </div>
      <div class="">
        <p
          class="main-color mt-5 font-12"
          v-if="!canResend && this.otp.availableTry > 0"
        >
          يمكنك إعادة إرسال رمز التحقق بعد
          <span class="bold">{{ otp.secondsLeft }}</span>
        </p>
        <p
          @click="resendOtp"
          class="pointer underline main-color mt-10 font-12"
          v-else-if="canResend"
        >
          إعادة إرسال الرمز
        </p>
      </div>
      <button
        class="btn-2 mt-30 flex-all m-side-auto font-20"
        id="sign-in-button"
        :disabled="code.val.length != 6 || !code.isValid"
      >
        أكمل عملية التسجيل
        <!-- <img src="/images/siteImgs/header/logo.png" class="mr-10"> -->
      </button>
      <div v-if="isLoading">
        <loading-spinner></loading-spinner>
      </div>
    </form>
  </div>
</template>

<script>
import loading from "./../../mixins/loading.js";
export default {
  mixins: [loading],
  emits: ["error-happen", "complete-registration-form", "send-otp"],
  data() {
    return {
      code: {
        val: "",
        isValid: true,
        showForm: false,
      },
      otp: {
        canResend: false,
        availableTry: 3,
        secondsLeft: 10,
      },
    };
  },
  mounted() {
    this.countDown();
  },
  computed: {
    canResend() {
      return this.otp.canResend && this.otp.availableTry > 0;
    },
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
      if (e.target.value.length != 6) {
        this[e.target.id].isValid = false;
      } else {
        this[e.target.id].isValid = true;
      }
    },
    async submitCode() {
      if (this.code.val.length != 6) {
        this.code.isValid = false;
        return;
      }
      this.isLoading = true;
      // await window.confirmationResult
      //     .confirm(this.code.val)
      //     .then(result => {
      //         // User signed in successfully.
      // ...
      // })
      // .catch(error => {
      //     this.$emit("error-happen", "يرجى التأكد من الرمز");
      // });
      try {
        // call api
        await this.$store.dispatch("user/checkOtp", {otpCode : this.code.val});

          this.$emit("complete-registration-form");
      } catch (e) {
                this.$emit("error-happen", "يرجى التأكد من الرمز");

      }

      this.isLoading = false;
    },
  },
};
</script>

<style scoped>
.spinner {
  z-index: 10 !important;
}
[disabled] {
    opacity: 0.3;
    cursor: not-allowed;
}
</style>
