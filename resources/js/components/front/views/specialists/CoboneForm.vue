<template>
  <div class="w-100">
    <form
      @submit.prevent="submitCoubon"
      class="cobone-form relative d-flex w-100"
    >
      <input
        type="text"
        v-model="promoCode"
        class="w-80 cobone-input"
        placeholder="هل لديك كوبون أو قسيمة شرائية استخدمها الآن ؟"
      />
      <input type="submit" value="" class="apply-cobone w-10 pointer" />
    </form>
    <info-modal
      :show="infoModal.show"
      :title="infoModal.title"
      @close="closeInfoModal"
      :description="infoModal.description"
      :success="infoModal.status"
      :fixed="infoModal.isFixed"
      portal="cobone-modal"
    >
      <div class="d-flex">
        <span class="gray font-35 before-discount bold ml-30">
          <template>{{ Math.round(1) }} $</template>
        </span>
        <span class="bold font-35 main-color">{{ Math.round(1) }} $</span>
      </div>
      <!-- <button @click="buyCourse" class="btn">
          إشترك الآن
      </button> -->
    </info-modal>
  </div>
</template>

<script>
import infoModalMixin from "../../mixins/infoModal";
export default {
  mixins: [infoModalMixin],
  emits: ["buyAppointment","getPromoCode"],
  props: ["specialistID","isLoggedIn"],
  data() {
    return {
      promoCode: "",
      discountVal: null,
      callPrice: 45
    };
  },
  methods: {
    isLoading(status) {
      this.$store.commit("isLoading", status);
    },
    async submitCoubon() {
      this.infoModal.isFixed = false;
      if (!this.isLoggedIn) {
        this.$store.commit("loginModal", true);
        return false;
      }
      if (this.promoCode == "") {
        this.$store.commit("alertDialogMsg", "يرجى إدخال كود الخصم");
        return false;
      }
      let checkPromoCode;

      this.isLoading(true);
      try {
        checkPromoCode = await this.$store.dispatch("courses/promoCode", {
          specialistID: this.specialistID,
          promoCode: this.promoCode,
          usage: "Call",
        });
        if (checkPromoCode.isValid) {
          this.$emit("getPromoCode", checkPromoCode.id);
        }
      } catch (error) {
        console.log(error);
      }
      this.isLoading(false);
      if (!checkPromoCode) {
        this.$store.commit("alertDialogMsg", "كود الخصم غير صحيح");
        return;
      }
      if (checkPromoCode.discount_perc == 100) {
        // free
        this.setInfoModal(
          "سوف يتم إرسال الرابط لبريدك الإلكتروني",
          "لقد قمت بإدخال رقم الكوبون بنجاح",
          true,
          true,
          true
        );
      } else {
        // discount success

        this.discountVal =
          this.callPrice -
          this.callPrice * (checkPromoCode.discount_perc / 100);
        this.setInfoModal(
          "يمكنك إتمام عملية الشراء",
          "لقد قمت بإدخال رقم الكوبون بنجاح",
          true,
          false,
          true
        );
      }
    },
  },
};
</script>

<style scoped>
.cobone-form {
  height: 60px;
}
.cobone-input {
  border: 1px solid #939598;
  border-radius: 0 25px 25px 0;
  color: #939598;
  font-size: 12px;
  padding: 20px 8px;
}
.apply-cobone {
  background-color: #632f63;
  position: relative;
  border-radius: 25px 0 0 25px;
  border: 0;
  width: 20%;
  background-image: url(/images/arrow-left.svg);
  background-repeat: no-repeat;
  background-position: center;
}
.before-discount {
  position: relative;
  top: 1px;
}
.before-discount:after {
  content: "";
  position: absolute;
  left: -4px;
  top: -3px;
  bottom: 0;
  margin: auto;
  width: 108%;
  height: 1px;
  background: red;
}
.btn {
  width: 340px;
  font-size: 18px;
  font-weight: bold;
  height: 60px;
  border-radius: 25px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
}
@media (max-width: 767px) {
  .cobone-form {
    height: 50px;
  }
}
</style>
