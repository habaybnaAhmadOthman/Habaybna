<template>
  <!-- @close="closeInfoModal" -->
  <normal-modal
    :show="showModal"
    :fixed="true"
    portal="add-session-modal"
    @close="closeModal"
  >
    <div class="">
      <p class="font-24 yellow bold mb-20">تحديد أوقاتي المتاحة</p>
      <form>
        <div class="form-group w-100 mb-20" :class="{ invalid: !day.isValid }">
          <select class="w-100" v-model="day.val" id="day">
            <option value="">إختر اليوم</option>
            <option
              v-for="item in availableDays"
              :key="item.value"
              :value="item.value"
            >
              {{ item.label }}
            </option>
          </select>
          <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
        </div>

        <div class="d-flex gap-20">
          <div
            class="form-group w-100 mb-20"
            :class="{ invalid: !from.isValid }"
          >
            <label>الوقت من</label>
            <input
              class="w-100"
              type="time"
              id="from"
              v-model="from.val"
            />
            <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
          </div>
          <div
            class="form-group w-100 mb-20"
            :class="{ invalid: !to.isValid }"
          >
            <label>الوقت إلى</label>
            <input
              class="w-100"
              type="time"
              id="to"
              v-model="to.val"
            />
            <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
          </div>
        </div>
      </form>
      <div class="d-flex gap-20">
        <button @click="closeModal" class="radius-60 gray dismiss-btn pointer">إلغاء</button>
        <button @click="submitForm" class="radius-60 main-bg border-0 white font-18 pointer pt-15 pb-15">حفظ</button>
        <button class="radius-60 main-bg border-0 white font-18 pointer pt-15 pb-15">حفظ وإستمرار</button>
      </div>
    </div>
  </normal-modal>
</template>

<script>
import NormalModal from "../../../layouts/NormalModal.vue";
export default {
  emits: ["close","add-new-session"],
  props: ["showModal","tableIntervals"],
  components: { NormalModal },
  created() {
    this.appendAvailableDays_DropDown();
  },
  methods: {
    submitForm(){
      var intervals = this.prepareIntervals();
      if (intervals.length > 0) {
        this.$emit('add-new-session',intervals);
        this.closeModal();
      }
    },
    // this function check validity,
    // show popup message if the date is invalid
    // return array of intervals devided to 30 minutes
    prepareIntervals() {
      let fromHour,
      fromMinutes,
      toHour,
      toMinutes,
      fromDate ,
      toDate,
      isValid,
      intervals = [];
      isValid = validateFields(this);
      if (isValid) {
        prepareFromTo(this);
        // check if from date < to date
        if (!isFromSmallerThanTo()){
          this.$store.commit('alertDialogMsg','يرجى تعبئة الوقت بشكل صحيح')
          return [];
        }
        fillIntervals(this);
        return intervals;
      } else
        return []
      
      
      function fillIntervals(self){
        while (isFromSmallerThanTo()) {
          var newInterval = fromDate.toISOString();
          if (!self.tableIntervals.includes(newInterval))
            intervals.push(newInterval)
          fromDate.setMinutes(fromDate.getMinutes() + 30)
        }
        if (intervals.length == 0)
          self.$store.commit('alertDialogMsg','هذه الفترة موجودة بالفعل')
      }
      function isFromSmallerThanTo(){
        return Math.abs(fromDate < toDate)
      }

      function validateFields(self){
        self.day.isValid = true;
        self.from.isValid = true;
        self.to.isValid = true;
        if (self.day.val == '') {
          self.day.isValid = false;
        }
        if (self.from.val == '') {
          self.from.isValid = false;
        }
        if (self.to.val == '') {
          self.to.isValid = false;
        }
        if (!self.day.isValid || !self.from.isValid || !self.to.isValid)
          return false;

        return true;
      }

      function prepareFromTo(self) {
        fromHour = self.from.val.split(':')[0];
        fromMinutes = +self.from.val.split(':')[1];
        toHour = self.to.val.split(':')[0];
        toMinutes = +self.to.val.split(':')[1];
        fromDate = new Date(self.day.val);
        toDate = new Date(self.day.val);
        

        if (fromMinutes > 30) 
          fromMinutes = 30
        else
          fromMinutes = 0
        if (toMinutes > 30) 
          toMinutes = 30
        else
          toMinutes = 0
        fromDate.setHours(fromHour,fromMinutes,0);
        toDate.setHours(toHour,toMinutes,0);
      }
    },
    closeModal() {
      this.$emit("close", false);
    },
    appendAvailableDays_DropDown() {
      let today = new Date();
      const appendedDays = [];
      for (let i = 0; i < 7; i++) {
        let day = new Date(today.getTime() + i * 24 * 60 * 60 * 1000);
        let date = `${day.getFullYear()}-${ day.getMonth() + 1 }-${day.getDate()}`;

        let formatedDay = `${date}-${day.getDate()} | ${day.toLocaleDateString("ar", {
          weekday: "long",
        })}`;

        appendedDays.push({ value: date,label: formatedDay });
      }

      this.availableDays = appendedDays;
    },
  },
  data() {
    return {
      day: {
        val: "",
        isValid: true,
      },
      availableDays: [],
      from: {
        val: "",
        isValid: true,
      },
      to: {
        val: "",
        isValid: true,
      },
    };
  },
};
</script>

<style scoped>
select,
input {
  height: 60px;
  border-radius: 4px;
  border: 1px solid ;
}
[type="time"] {
  position: relative;
  padding: 10px;
  overflow: hidden;
}
[type="time"]::-webkit-calendar-picker-indicator {
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background: url(/images/time-icon-2.svg) right center;
  background-size: 30px;
  background-repeat: no-repeat;
  background-position: calc(100% - 30px) 48%;
  cursor: pointer;
}
.dismiss-btn {
  border: 1px solid #ccc;
  background: transparent;
}
</style>