<template>
  <!-- :show="querstionaireModal.show" -->
  <alert-dialog
    :show="show"
    :title="'نموذج الطفل'"
    :fixed="fixed"
    @close="close"
    portal="questionaire-modal"
  >
    <div class="">
      <p class="font-20 mb-20 font-18-p">
        النموذج أدناه يساعد الأخصائي على الاستعداد للمكالمة يرجى تعبئته
      </p>
      <form autocomplete="off" class="w-100">
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        <div class="d-flex gap-10 mb-20">
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

          <div
            :class="{ invalid: !birthdate.isValid }"
            class="form-group relative w-50"
            v-if="years.length > 0"
          >
            <!-- <input
              v-model.trim="age.val"
              id="age"
              type="text"
              class="form-control font-18 holder-center w-100"
              placeholder="عمر الطفل عند معرفة حالته"
            /> -->
            <select
              class="
                bg-white
                border-0
                radius-5
                w-100
                p-10
                pointer
                form-control
                trans
              "
              v-model="birthdate.val"
              id="birthdate"
              required
            >
              <option value="" disabled hidden>سنة ميلاد الطفل</option>
              <option v-for="year in years" :value="year" :key="year">
                {{ year }}
              </option>
            </select>
            <p class="main-color font-12">هذا الحقل مطلوب</p>
          </div>
        </div>
        <div class="d-flex gap-10 mb-20">
          <div
            class="form-group relative w-50"
            :class="{ invalid: !age.isValid }"
          >
            <input
              v-model.trim="age.val"
              id="age"
              type="number"
              class="form-control font-18 holder-center w-100"
              placeholder=" عُمر الطفل عند معرفة حالته"
              autocomplete="off"
            />
            <p class="main-color font-12">هذا الحقل مطلوب</p>
          </div>

          <div
            :class="{ invalid: !childSituation.isValid }"
            class="form-group relative w-50"
          >
            <!-- <input
              v-model.trim="age.val"
              id="age"
              type="text"
              class="form-control font-18 holder-center w-100"
              placeholder="عمر الطفل عند معرفة حالته"
            /> -->
            <select
              class="
                bg-white
                border-0
                radius-5
                w-100
                p-10
                pointer
                form-control
                trans
              "
              v-model="childSituation.val"
              id="childSituation"
              required
            >
              <option value="" disabled hidden>وضع الطفل</option>
              <option :value="'مندمج بالمدرسة'">مندمج بالمدرسة</option>
              <option :value="'يذهب إلى مركز'">يذهب إلى مركز</option>
              <option :value="'يتلقى جلسات'">يتلقى جلسات</option>
              <option :value="'في المنزل'">في المنزل</option>
            </select>
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
            placeholder="إوصف لنا المشكلة"
            rows="5"
          ></textarea>
          <p class="main-color font-12">هذا الحقل مطلوب</p>
        </div>
      </form>
    </div>
    <template #actions>
      <button @click="submitForm($event)" class="btn font-20 w-70 ml-10">
        حفظ
      </button>
      <button @click="close" class="btn-3 radius-12 font-20 w-30 p-0-p">
        تجاهل
      </button>
    </template>
  </alert-dialog>
</template>

<script>
import sysYears from "../../../../modules/years";
export default {
  props: ["show", "fixed","callIDFromCobone"],
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
      birthdate: {
        val: "",
        isValid: true,
      },
      childSituation: {
        val: "",
        isValid: true,
      },
      message: {
        val: "",
        isValid: true,
      },
      years: [],
      formIsValid: true,
    };
  },
  mounted() {
    this.years = sysYears;
  },
  methods: {
    close() {
      this.$router.replace(`/specialist/${this.$route.params.specialist}`);
      this.$emit("close");
    },
    validateForm() {
      this.formIsValid = true;
      this.childSituation.isValid = true;
      this.birthdate.isValid = true;
      this.childStatus.isValid = true;
      this.age.isValid = true;
      this.message.isValid = true;

      if (this.childSituation.val == "") {
        this.childSituation.isValid = false;
        this.formIsValid = false;
      }
      if (this.birthdate.val == "") {
        this.birthdate.isValid = false;
        this.formIsValid = false;
      }
      if (this.childStatus.val == "") {
        this.childStatus.isValid = false;
        this.formIsValid = false;
      }
      if (this.age.val == "") {
        this.age.isValid = false;
        this.formIsValid = false;
      }
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
          childSituation: this.childSituation.val,
          age: this.age.val,
          message: this.message.val,
          childStatus: this.childStatus.val,
          birthdate: new Date().getFullYear() - +this.birthdate.val,
          callID: this.$route.query["apt-id"] || this.callIDFromCobone,
        });
        this.close();
        // this.$store.commit("alertDialogMsg", "شكراً لتعاونكم");
        this.age.val = "";
        this.childStatus.val = "";
        this.childSituation.val = "";
        this.birthdate.val = "";
        this.message.val = "";
        this.$router.replace(`/profile/my-call-log`);
      } catch (e) {
        this.$store.commit("alertDialogMsg", e.message);
      }
      // this.sendMail()
    },
  },
};
</script>

<style scoped>
input,
textarea,
select {
  box-shadow: 0px 3px 6px #00000029;
  border: 1px solid #b7b7b7;
  border-radius: 10px;
  padding: 10px;
  font-size: 17px;
}
select:invalid {
  color: #b7b7b7;
}
textarea {
  height: auto;
}

@media (max-width: 767px) {
  input,
  textarea {
    font-size: 15px;
  }
}
</style>
