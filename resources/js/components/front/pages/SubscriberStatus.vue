<template>
  <div class="terms-page">
    <TheHeader />
    <div class="container birthday">
      <div v-if="paymentStatus" class="gift-payment-status success">
        <img src="/images/success-icon.png" alt="" />

        <h4>عملية دفع ناجحة</h4>
        <p>سنقوم بتحويلك الى صفحة التسجيل</p>
        <h4>شكرا لك</h4>
      </div>
      <div
        v-if="paymentStatus == false"
        class="gift-payment-status success mt-20"
      >
        <img src="/images/siteImgs/gift-faild.png" alt="" />

        <h4 class="mt-20">عملية الدفع قد فشلت</h4>
      </div>
    </div>

    <TheFooter />
  </div>
</template>

<script>
import TheHeader from "../layouts/header/TheHeader.vue";

import TheFooter from "../layouts/TheFooter.vue";
export default {
  components: { TheHeader, TheFooter },
  created() {
    this.checkStatus();
  },
  data() {
    return {
      paymentStatus: null,
    };
  },
  methods: {
    checkStatus() {
      this.isLoading(true);
      axios({ method: "GET", url: "/api/get-subscribe-payment-status" }).then(
        (res) => {
          if (res.data == "faild") {
            setTimeout(() => {
              this.paymentStatus = false;
            }, 500);
            setTimeout(() => {
              this.$router.replace("/subscribe?cou=other");
            }, 2500);

            // document.documentElement.scrollTop = document.body.scrollTop = 1000;
          } else {
            setTimeout(() => {
              this.paymentStatus = true;
            }, 500);
            // document.documentElement.scrollTop = document.body.scrollTop = 1000;

            setTimeout(() => {
              this.$router.replace("/signup");
            }, 2500);
          }
          this.isLoading(false);
        }
      );
    },
    isLoading(status) {
      this.$store.commit("isLoading", status);
    },
    sendGift(amount) {

this.giftValidation();
      if (this.giftIsValid) {
        const Obj = {
          first: this.firstName,
          last: this.lastName,
          email: this.email,
          amount: amount,
        };
        let self = this;
        const resp = this.callApi("post", "/api/siraj-nadim-gift", Obj).then(
          (res) => {
            console.log("res");
            if (res.status == 200) {
              console.log("xxxxxxxx");
              this.paymentData = res.data[0].SmartRouteParams;
              this.PaymentFormIsRedy = true;
              setTimeout(() => {
                this.submitForm();
              }, 1500);
            }
          }
        );
      }
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
  direction: ltr;
}
/* .birthday img {
  width: 100%; 
} */
.birthday p {
  font-size: 27px;
  margin: 16px 0;
  padding: 0 9px;
}
.birthday .celebrations {
  font-size: 35px;
  margin: 36px 0;
  font-family: monospace;
  text-transform: capitalize;
}

.gifting .card {
  opacity: 0.8;
  cursor: pointer;
  margin: 7px auto;
  transition-duration: 0.2s;
  transition-delay: 0.1s;
  background-color: #e4ebf0;
  border-radius: 7px;
}
.gifting p {
  margin: 7px auto;
}
.gifting .card:hover {
  opacity: 1;
  box-shadow: rgb(144 59 166 / 31%) 0px 20px 30px -10px;
  background-color: #d5dfe6d1;
}
.birthday .gifting p {
  font-size: 21px;
}
.birthday .gifting h2 {
  text-align: center;
}
.gifting .card:focus {
  opacity: 1;
  box-shadow: rgb(144 59 166 / 31%) 0px 20px 30px -10px;
}
/* .gifting .card .card-body {
  text-align: center;
} */
.choose {
  margin: 60px 0;
}
.choose p {
  margin: auto;
  font-size: 34px;
  text-transform: uppercase;
  font-weight: bold;
}
.gift-form .form-control {
  margin: 5px 0;
}
.gift-form input {
  padding: 0 15px;
  font-size: 24px;
}
.gift-validation {
  color: red;
  display: block;
}
.gift-payment-status {
  max-width: 50%;
  margin: 20px auto;
  text-align: center;
  font-size: 24px;
}
.success {
  color: rgb(131 57 117);
}
@media only screen and (max-width: 480px) {
  .gift-payment-status {
    max-width: 100%;
  }
}
</style>
