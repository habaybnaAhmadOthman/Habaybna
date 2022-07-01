<template>
  <div>
    <RegisterTemplate>
      <OtpForm
        @send-otp="submitForm"
        @error-happen="showPopupMessage"
        v-if="!showCodeForm"
        ref="phoneForm"
      >
      </OtpForm>
      <CodeForm
        @complete-registration-form="next"
        @error-happen="showPopupMessage"
        v-else
      ></CodeForm>
      <button
        :class="{ 'asb-btn': showCodeForm }"
        @click="submitPhone"
        class="btn-2 mt-30 flex-all m-side-auto font-20"
        id="sign-in-button"
      >
        أرسل رمز التحقق
        <!-- <img src="/images/siteImgs/header/logo.png" class="mr-10" /> -->
      </button>
      <h3 v-if="!showCodeForm" class="mt-50 center light font-15 flex-all p-side-50 flex-wrap">
        <span class="main-color font-15-p">هل أنت عضو في عائلة حبايبنا؟</span>
        <router-link class="d-flex align-center font-15-p" to="/signin"
          >تسجيل دخول</router-link
        >
      </h3>
    </RegisterTemplate>
    <div id="recaptcha-container" class="recaptcha-container"></div>
    <alert-dialog
      :show="!!error"
      :title="error"
      @close="closeModal"
    ></alert-dialog>
    <div v-if="isLoading">
      <loading-spinner></loading-spinner>
    </div>
  </div>
</template>

<script>
import auth from "./../../../../modules/firebase";
import { signInWithPhoneNumber, RecaptchaVerifier } from "firebase/auth";
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import OtpForm from "./../../views/auth/OtpForm.vue";
import CodeForm from "./../../views/auth/CodeForm.vue";

import loading from "./../../mixins/loading.js";

export default {
  mixins: [loading],
  components: {
    RegisterTemplate,
    OtpForm,
    CodeForm,
  },
  data() {
    return {
      showCodeForm: false,
      phoneNumber: "",
      type: "",
      code: "",
    };
  },

  methods: {
    submitPhone() {
      this.$refs.phoneForm.submitForm();
    },
    async next(obj) {
      this.isLoading = true;
      this.$router.replace(`/${this.type}-complete-registration`);

      this.isLoading = false;
    },
    // store phone number and type and otp(optional)
    async submitForm(obj) {
      this.isLoading = true;
      try {
        // call api
        await this.$store.dispatch("user/registerFirstStep", {
          type: obj.type,
          phone: obj.phoneNumber,
        });
        this.phoneNumber = obj.phoneNumber;
        this.type = obj.type;
        this.showCodeForm = true;

        // this.$router.replace(`/${obj.type}-complete-registration`);
      } catch (e) {
        this.showPopupMessage(e.message);
      }
      this.isLoading = false;
    },
  },
  mounted() {
    window.recaptchaVerifier = new RecaptchaVerifier(
      "sign-in-button",
      {
        size: "invisible",
        callback: (response) => {},
      },
      auth
    );
  },
};
</script>
<style scoped>
.asb-btn {
  position: absolute;
  top: 0;
  z-index: -1;
  visibility: hidden;
  opacity: 0;
}
.spinner {
  z-index: 10 !important;
}
</style>
