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
        <div class="form-group col-sm-md-8">
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
        <div class="form-check mt-15">
          <input
            type="checkbox"
            class="form-check-input"
            id="exampleCheck1"
            value="true"
            v-model="showInlist"
          />
          <label class="form-check-label ml-10" for="exampleCheck1"
            >Let nadeem & sirag know .</label
          >

        </div>
        <div v-if="showInlist" class="form-group col-sm-md-8 mb-50">
          <textarea
            v-model="message"
            class="form-control p-10 message"
            type="text"
            placeholder="write a message .."
          />
          <span v-if="!validation.firstName" class="gift-validation"
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
    <a href="#users-list" class="btn-show-list"> Gifts List </a>
    <div class="birthday-modal" id="users-list">
      <a href="#" class="colse-x">X</a>
      <a href="#" class="close"></a>
      <div class="target-inner">
        <div v-for="(user, index) in users" :key="index" class="card">
          <div class="card-head">
            <img src="/images/avatars/default.jpg" alt="" />
            <span>{{ user.firstName }} {{ user.lastName }}</span>
            <div class="card-gift">{{ user.amount }}</div>
          </div>
          <div class="card-content">
            <p>{{user.msg}}.</p>
          </div>
        </div>
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
      users: [],
      showInlist: false,
      message: null,
    };
  },
  methods: {
    getUserList() {
      const resp = this.callApi("get", "api/get-users-gift?success=1").then(
        (res) => {
          if (res.status == 200) {
            this.users = res.data;
          }
        }
      );
    },

    sendGift(amount) {
      this.giftValidation();
      if (this.giftIsValid) {
        const Obj = {
          first: this.firstName,
          last: this.lastName,
          email: this.email,
          amount: amount,
          showinList:this.showInlist,
          msg:this.message,
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
    submitForm() {
      console.log(this.$refs.birthday.submit());
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
  mounted() {
    this.getUserList();
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

.btn-show-list {
  position: fixed;
  left: -5%;
  top: 50%;
  font-size: 40px;
  background-color: #903ba6;
  color: #fff;
  padding: 5px 20px;
  border-radius: 45px 0px 40px 0px;
  opacity: 0.8;
  transition: left 0.3s ease-in;
}
.btn-show-list:hover {
  opacity: 1;
  left: 1%;
}
.birthday-modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  pointer-events: none;
  opacity: 0;
  transition: opacity 200ms;
}
.birthday-modal:target {
  pointer-events: all;
  opacity: 1;
}
.close {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: #34495e;
  opacity: 0.5;
  transition: opacity 200ms;
}
.close:hover {
  opacity: 0.4;
}
.target-inner {
  display: grid;
  overflow: a;
  grid-template-columns: 30% 30% 30%;
  width: 73%;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  position: absolute;
  background: white;
  padding: 34px;
  /* direction: rtl; */
  text-align: left;
  overflow-y: scroll;
  justify-content: space-around;
  max-height: 70vh;
  direction: ltr;
  border-radius: 15px;
}
.card {
  border: 1px solid #1a16164d;
  margin: 9px 0;
  padding: 7px 0px;
  border-radius: 9px;
  box-shadow: 0px 2px 1px 0px #00000070;
}
.card .card-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card .card-head img {
  width: 64px;
  height: 64px;
}
.card .card-head span {
  font-size: 1.3rem;
}
.card .card-content p {
  font-size: 1.2rem;
  padding: 3px 0px 1px 10px;
}
.card .card-gift {
  min-width: 30%;
  min-height: 58px;
  border-radius: 5px;
  background-image: url(/images/siteImgs/gift.jpg);
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  font-weight: bolder;
  font-size: 1.8rem;
  background-size: cover;
}
@media screen and(min-width: 576px) {
}
@media screen and (max-device-width: 480px) and (orientation: portrait) {
  .target-inner {
    min-width: 95%;
    display: block;
  }
  .btn-show-list {
    position: fixed;
    right: -17%;
    top: 8%;
    font-size: 27px;
    background-color: #903ba6;
    color: #fff;
    padding: 5px 20px;
    border-radius: 45px 0px 40px 0px;
    opacity: 0.8;
    left: unset;
    transition: right 0.5s ease-in;
  }
  .btn-show-list:hover {
    right: 0;
  }
}
.colse-x {
  right: 6%;
  top: 18%;
  z-index: 99899989898989;
  position: absolute;
  font-size: 43px;
  border-radius: 53%;
  border: 3px solid #5f5a5a;
  color: #912cfa;
  padding: 3px 15px;
  font-weight: 100;
}
.form-check-input {
  content: "";
  width: 1.5rem;
  height: 1.5rem;
}
.form-check label {
  font-size: 1.5rem;
}

.form-control.message {
  transition: all 0.4s ease-in;
  width: 50%;
  min-height: 80px;
}
</style>
