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
      <div class="row choose col-12">
        <p>Choose Your Gift</p>
      </div>
      <div class="center gift-form">
        <div class="form-group col-sm-md-8">
          <input
            v-model="firstName"
            class="form-control"
            type="text"
            placeholder="First Name"
          />
          <span v-if="!validation.firstName" class="gift-validation"
            >this field is recuired</span
          >
        </div>
        <div class="form-group col-sm-md-8">
          <input
            v-model="lastName"
            class="form-control"
            type="text"
            placeholder="Last Name"
          />
          <span v-if="!validation.lastName" class="gift-validation"
            >this field is recuired</span
          >
        </div>
        <div class="form-group col-sm-md-8 mb-50">
          <input
            v-model="email"
            class="form-control"
            type="email"
            placeholder="Email"
          />
          <span v-if="!validation.email" class="gift-validation"
            >this field is recuired</span
          >
        </div>
      </div>
      <div class="row gifting center">
        <div class="card col-3">
          <img
            class="card-img-top"
            src="/images/siteImgs/gift.jpg"
            alt="Card image cap"
          />
          <div class="card-body">
            <p class="card-text">1 virtual session</p>

            <h2 class="card-title">20 JD</h2>
            <button class="btn gift" @click="sendGift(20)">Gift</button>
          </div>
        </div>
        <div class="card col-3">
          <img
            class="card-img-top"
            src="/images/siteImgs/gift.jpg"
            alt="Card image cap"
          />
          <div class="card-body">
            <p class="card-text">2 virtual sessions</p>

            <h2 class="card-title">40 JD</h2>
            <button class="btn gift" @click="sendGift(40)">Gift</button>
          </div>
        </div>
        <div class="card col-3">
          <img
            class="card-img-top"
            src="/images/siteImgs/gift.jpg"
            alt="Card image cap"
          />
          <div class="card-body">
            <p class="card-text">3 virtual sessions</p>

            <h2 class="card-title">60 JD</h2>
            <button class="btn gift" @click="sendGift(60)">Gift</button>
          </div>
        </div>
        <div class="card col-3">
          <img
            class="card-img-top"
            src="/images/siteImgs/gift.jpg"
            alt="Card image cap"
          />
          <div class="card-body">
            <p class="card-text">5 virtual sessions</p>

            <h2 class="card-title">100 JD</h2>
            <button class="btn gift" @click="sendGift(100)">Gift</button>
          </div>
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
      <input
        type="hidden"
        name="CurrencyISOCode"
        :value="paymentData.CurrencyISOCode"
      />
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

import TheFooter from "../layouts/TheFooter.vue";
export default {
  components: { TheHeader, TheFooter },
  data() {
    return {
      firstName: null,
      lastName: null,
      email: null,
      giftIsValid: false,
      validation: {
        firstName: true,
        lastName: true,
        email: true,
      },
      paymentData: null,
      PaymentFormIsRedy: false,
    };
  },
  methods: {
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
                console.log('xxxxxxxx');
              this.paymentData = res.data[0].SmartRouteParams;
              this.PaymentFormIsRedy = true;
                    setTimeout(() => {
              this.submitForm()

      }, 1500);
            }
          }
        );
      }
    },
    submitForm() {
        console.log( this.$refs.birthday.submit());
    },
    giftValidation() {
      if (this.firstName == null) {
        this.validation.firstName = false;
        this.giftIsValid = false;
      } else {
        this.validation.firstName = true;
        this.giftIsValid = true;
      }
      if (this.lastName == null) {
        this.validation.lastName = false;
        this.giftIsValid = false;
      } else {
        this.validation.lastName = true;
        this.giftIsValid = true;
      }
      if (this.email == null) {
        this.validation.email = false;
        this.giftIsValid = false;
      } else {
        this.validation.email = true;
        this.giftIsValid = true;
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
</style>
