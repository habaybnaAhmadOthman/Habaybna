<template>
  <div class="terms-page">
    <TheHeader />
    <div class="container birthday">
      <!-- <img
            src="/images/siteImgs/Green Minimalist Happy Birthday Card.jpg"
            alt=""
        /> -->

      <div class="bg-white d-flex flex-column mt-50 pb-20">
        <p class="celebrations">
          سعداء باهتمامك في الإنضمام إلى عائلة حبايبنا.نت ومساعدتك في تلبية
          احتياجات طفلك يرجى تعبئة البيانات لإتمام عملية الدفع .
        </p>
        <div class="d-flex justify-center">
          <form @submit.prevent class="col-md-6 center p-10">
            <div class="form-group mb-10">
              <input
                required
                v-model="name"
                class="form-control w-100 pr-20"
                type="text"
                placeholder="الأسم الكامل"
              />
              <span v-if="!validation.name" class="gift-validation"
                >هذا الحقل مطلوب</span
              >
            </div>
            <div class="form-group mb-20">
              <input
                required
                v-model="email"
                class="form-control w-100 pr-20"
                type="email"
                placeholder="البريد الالكتروني"
              />
              <span v-if="!validation.email" class="gift-validation"
                >هذا الحقل مطلوب</span
              >
            </div>
            <div class="form-group mb-10">
              <input
                required
                v-model="phoneNumber"
                class="form-control w-100 pr-20"
                type="text"
                :placeholder="info.placeHolder"
              />
              <span v-if="!validation.phoneNumber" class="gift-validation"
                >هذا الحقل مطلوب</span
              >
            </div>
            <button class="btn gift mt-20" @click="subscribe()">
              أكمل الدفع
            </button>
          </form>
        </div>
      </div>
    </div>
    <form
      ref="birthday"
      v-if="PaymentFormIsRedy"
      method="post"
      :action="paymentData.RedirectURL"
      @submit.prevent="submitForm"
    >
      <input type="hidden" name="Amount" :value="paymentData.Amount" />
      <input type="hidden" name="Channel" :value="paymentData.Channel" />
      <input type="hidden" name="CurrencyISOCode" :value="paymentData.CurrencyISOCode" />
      <input type="hidden" name="Language" :value="paymentData.Language" />
      <input type="hidden" name="MerchantID" :value="paymentData.MerchantID" />
      <input type="hidden" name="MessageID" :value="paymentData.MessageID" />
      <input
        type="hidden"
        name="PaymentDescription"
        :value="paymentData.PaymentDescription"
      />
      <input type="hidden" name="Quantity" :value="paymentData.Quantity" />
      <input
        type="hidden"
        name="ResponseBackURL"
        :value="paymentData.ResponseBackURL"
      />
      <input type="hidden" name="ThemeID" :value="paymentData.ThemeID" />
      <input
        type="hidden"
        name="TransactionID"
        :value="paymentData.TransactionID"
      />
      <input type="hidden" name="Version" :value="paymentData.Version" />
      <input type="hidden" name="SecureHash" :value="paymentData.secureHash" />
    </form>
    <TheFooter />
  </div>
</template>

<script>
import TheHeader from "../layouts/header/TheHeader.vue";
// import VuePhoneNumberInput from "vue-phone-number-input";
// import "vue-phone-number-input/dist/vue-phone-number-input.css";

import TheFooter from "../layouts/TheFooter.vue";
export default {
  components: { TheHeader, TheFooter },
  data() {
    return {
      countries: ["uae", "ksa", "other"],
      name: null,
      email: null,
      phoneNumber: "",
      canSubscribe: false,
      validation: {
        name: true,
        email: true,
        phoneNumber: true,
      },
      info_c: [
        {
          count: "uae",
          placeHolder: "رقم الهاتف مثال    971xxxxxxxxx+",
          phoneValidation: /\+971([\d]{9})/,
          amount: 22000,
          currency: "784",
        },
        {
          count: "ksa",
          placeHolder: "رقم الهاتف مثال    966xxxxxxxxx+",
          phoneValidation:/\+966([\d]{9})/,
          amount: 22000,
          currency: "682",
        },
        {
          count: "other",
          placeHolder: "رقم الهاتف مثال  (123)545456789+",
          phoneValidation: /\+[0-9]{1,3}([\d]{9})/,
          amount: 5600,
          currency: "840",
        },
      ],
      paymentData: null,
      PaymentFormIsRedy: false,
    };
  },
  methods: {
    subscribe() {
      this.giftValidation();
      if (this.canSubscribe) {
        const Obj = {
          name: this.name,
          email: this.email,
          phone: this.phoneNumber,
          info: this.info,
        };
        let self = this;
        const resp = this.callApi("post", "/api/subscribe", Obj).then((res) => {
          if (res.status == 200) {
            this.paymentData = res.data;
            this.PaymentFormIsRedy = true;
            setTimeout(() => {
              this.submitForm();
            }, 1500);
          }
        });
      }
    },
    submitForm() {
      this.$refs.birthday.submit();
    },
    giftValidation() {
      if (this.name == null) {
        this.validation.name = false;
        this.canSubscribe = false;
      } else {
        this.validation.name = true;
        this.canSubscribe = true;
      }
      if (this.email == null) {
        this.validation.email = false;
        this.canSubscribe = false;
      } else {
        this.validation.email = true;
        this.canSubscribe = true;
      }
      if (
        this.phoneNumber == "" ||
        !this.phoneNumber.match(this.info.phoneValidation)
      ) {
        this.validation.phoneNumber = false;
        this.canSubscribe = false;
      } else {
        this.validation.phoneNumber = true;
        this.canSubscribe = true;
      }
    },
  },
  mounted() {
  },
  computed: {
    country() {
      return this.countries.includes(this.$route.query.cou)
        ? this.$route.query.cou
        : "other";
    },

    isUae() {
      return this.country == "uae" ?? false;
    },
    isKsa() {
      return this.country == "ksa" ?? false;
    },
    phoneValidation() {
      if (this.isUae) {
        return /\+971([\d]{9})/;
      }
      if (this.isKsa) {
        return /\+966([\d]{9})/;
      }
      return /\+{3}([\d]{9})/;
    },
    phonePlaceHolder() {
      if (this.isUae) {
        return "رقم الهاتف مثال    971xxxxxxxxx+";
      }
      if (this.isKsa) {
        return "رقم الهاتف مثال    966+";
      }
      return "رقم الهاتف مثال    xxxxxxxxxxxx+";
    },
    info() {
      let data = null;

      this.info_c.forEach((one) => {
        if (one.count == this.country) {
          data = one;
        }
      });
      return data;
    },
  },
};
</script>
<style scoped>
h1 {
  font-size: 100px;
}
.birthday {
  /* background-color: #e0f2f2; */
  direction: rtl;
}

.birthday p {
  font-size: 27px;
  margin: 16px 0;
  padding: 0 9px;
}
.birthday .celebrations {
  padding: 20px;
  text-transform: capitalize;
}

.gift-validation {
  color: red;
  display: block;
  text-align: right;
  font-size: small;
  margin-right: 15px;
  margin-top: 3px;
}
</style>
