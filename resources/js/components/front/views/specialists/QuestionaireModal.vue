<template>
  <!-- :show="querstionaireModal.show" -->
  <alert-dialog
    :show="show"
    :title="'نموذج الطفل'"
    @close="close"
    portal="questionaire-modal"
  >
    <div class="">
      <p class="font-20 mb-20 font-18-p">
        النموذج أدناه يساعد الأخصائي على الاستعداد للمكالمة يرجى تعبئته
      </p>
      <form class="w-100">
        <div class="d-flex gap-10 mb-20">
          <div class="form-group relative w-50">
            <input
              v-model.trim="age.val"
              id="age"
              type="text"
              class="form-control font-18 holder-center w-100"
              placeholder="عمر الطفل"
            />
          </div>
          <div
            class="form-group relative w-50"
            :class="{ invalid: !childStatus.isValid }"
          >
            <input
              v-model.trim="childStatus.val"
              id="childStatus"
              type="childStatus"
              class="form-control font-18 holder-center w-100"
              placeholder=" حالة الطفل"
            />
            <p class="main-color font-12">هذا الحقل مطلوب</p>
          </div>
        </div>
        <div
          class="form-group mb-20 relative"
          :class="{ invalid: !message.isValid }"
        >
          <textarea
            v-model.trim="message.val"
            id="message"
            class="form-control font-18 holder-center w-100"
            placeholder="الرسالة"
            rows="5"
          ></textarea>
          <p class="main-color font-12">هذا الحقل مطلوب</p>
        </div>
        <div class="">
          
        </div>
      </form>
    </div>
    <template #actions>
      <button @click="submitForm($event)" class="btn font-20 w-70 ml-10">أرسل</button>
      <button @click="close" class="btn-3 radius-12 font-20 w-30 p-0-p">إلغاء</button>
    </template>
  </alert-dialog>
</template>

<script>
export default {
  props: ["show"],
  emits: ["close"],
  data() {
    return {
      age: {
        val: "",
        isValid: true,
      },
      childStatus: {
        val: "",
        isValid: true,
      },
      message: {
        val: "",
        isValid: true,
      },
      formIsValid: true,
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
    validateForm() {
      this.formIsValid = true;
      this.message.isValid = true;
      if (this.message.val == "") {
        this.message.isValid = false;
        this.formIsValid = false;
      }
    },
    submitForm(evt) {
      evt.preventDefault();
      this.validateForm();
      if (!this.formIsValid) {
        return;
      }
      try {
        this.$store.dispatch("specialist/childInfoForAppointment", {
          message: this.message.val,
          age: this.age.val,
          childStatus: this.childStatus.val,
        });
        this.close()
        this.$store.commit("alertDialogMsg", "شكراً لتعاونكم");
        this.age.val = "";
        this.childStatus.val = "";
        this.message.val = "";
      } catch (e) {
        this.$store.commit("alertDialogMsg", e.message);
      }
      // this.sendMail()
    },
  },
};
</script>

<style scoped>
input,textarea {
    box-shadow: 0px 3px 6px #00000029;
    border: 1px solid #B7B7B7;
    border-radius: 10px;
      padding: 10px;
    font-size: 17px;
}
textarea {
    height:auto;
}

@media (max-width: 767px) {
    input,textarea {
      font-size: 15px;
    }
}
</style>