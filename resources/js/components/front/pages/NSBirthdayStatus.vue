<template>
  <div class="terms-page">
    <TheHeader />
    <div class="container birthday">
      <img src="/images/siteImgs/nsBirthday.jpg" alt="" />
      <p class="celebrations">Celebrations are sweeter when SHARED!</p>
      <p>
        Your Celebrations are sweeter when SHARED! Your contribution will be
        used to cover the costs of virtual sessions to parents of children with
        certain developmental delays and disabilities such as Speech Disorders,
        Autism, Down Syndrome.
      </p>
      <p>
        *Beneficiaries are parents with limited financial resources, across
        Jordan.
      </p>
      <p>
        A heartfelt THANK YOU for your kind gift, on behalf of Nadeem &amp;
        Siraj.
      </p>
      <div v-if="paymentStatus" class="gift-payment-status success">
        <img src="/images/siteImgs/gift-success.png" alt="" />

        <h4>Thank you</h4>
      </div>
      <div v-else class="gift-payment-status success">
        <img src="/images/siteImgs/gift-faild.png" alt="" />

        <h4>Thank you</h4>
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
      axios({ method: "GET", url: "/api/get-gift-payment-status" }).then(
        (res) => {
          console.log(res);
          if (res.data == "faild") {
              this.paymentStatus = false;
            document.documentElement.scrollTop = document.body.scrollTop = 1300;

            // this.$router.replace(`/specialist/${res.data.slug}?payment=false`);
            this.isLoading(false);
                        setTimeout(() => {
            // this.$router.replace("/Nadeem-Sirajs-Birthday-Gift");

            }, 2500);
          } else {
            this.paymentStatus = true;
            document.documentElement.scrollTop = document.body.scrollTop = 1300;

            setTimeout(() => {
            // this.$router.replace("/");

            }, 2500);
            this.isLoading(false);
          }
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
.birthday img {
  width: 100%;
}
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
  margin: auto;
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
