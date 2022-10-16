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
        placeholder="هل لديك كود خصم؟ استخدمه وتابع من هنا"
      />
      <input
        :disabled="canEnterCode"
        type="submit"
        value=""
        class="apply-cobone w-10 pointer"
      />
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
      <div v-if="discountVal" class="d-flex w-100">
        <span class="gray font-35 before-discount bold ml-30">
          <template>{{ callPrice }} USD</template>
        </span>
        <span class="bold font-35 main-color"
          >{{ Math.round(discountVal) }} USD</span
        >
      </div>
      <button v-if="promoID" @click="bookAppointment" class="btn">
        متابعة
      </button>
      <button v-else @click="closeInfoModal" class="btn">متابعة</button>
    </info-modal>
  </div>
</template>

<script>
import infoModalMixin from "../../mixins/infoModal";
export default {
  mixins: [infoModalMixin],
  emits: [
    "buyAppointment",
    "getPromoCode",
    "open-questionaire-modal",
    "saveSelectedApt",
  ],
  props: [
    "specialistID",
    "isLoggedIn",
    "canEnterCode",
    "selectedAppointment",
    "slug",
  ],
  data() {
    return {
      promoCode: "",
      discountVal: null,
      callPrice: 54,
      priceAfterDiscount: null,
      promoID: null,
      callID: null,
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
        this.$emit("saveSelectedApt", true);
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
        this.promoID = checkPromoCode.id;
        this.setInfoModal(
          "تم استخدام الكوبون بنجاح",
          "سيتم إضافة رابط المكالمة في سجل المكالمات الخاص بك",
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
          "لقد قمت بإدخال رقم الكوبون بنجاح",
          "يمكنك إتمام عملية الشراء",
          true,
          false,
          true
        );
        this.$store.commit("specialist/callPrice", this.discountVal);
      }
    },
    async bookAppointment() {
      this.isLoading(true);
      const selectedApt = this.selectedAppointment;
      try {
        const resp = await this.$store.dispatch("specialist/bookAppointment", {
          appointmentID: selectedApt.id,
          slug: this.slug,
          specialistID: this.specialistID,
          hasPromoCode: {
            id: this.promoID,
          },
        });
        this.callID = resp.SmartRouteParams.appointment_id;
        this.closeInfoModal();
        this.$emit("open-questionaire-modal", this.callID);
      } catch (error) {
        this.$store.commit("alertDialogMsg", error.message);
      }
      this.isLoading(false);
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
  background-color: #780d93 !important;
  position: relative;
  border-radius: 25px 0 0 25px;
  border: 0;
  width: 20%;
  background-image: url(/images/arrow-left.svg) !important;
  background-repeat: no-repeat !important;
  background-position: center !important;
  transition: 0.3s;
}
.apply-cobone:disabled {
  opacity: 0.5;
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
