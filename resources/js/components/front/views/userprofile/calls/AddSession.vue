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

        <div class="d-flex gap-20 first-row flex-wrap-p">
          <div
            class="form-group w-100 mb-20 w-100-p mb-0-p"
            :class="{ invalid: !from.isValid }"
          >
            <label>الوقت من</label>
            <div class="relative d-flex gap-10">
              <select class="w-100" v-model="from.time">
                <option v-for="item in time" :key="item" :value="item">{{ item | formatTime }}</option>
              </select>
              <select class="am-pm" v-model="from.amPm">
                <option value="am">AM</option>
                <option value="pm">PM</option>
              </select>
              
            </div>
            <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
          </div>
          <div
            class="form-group w-100 mb-20 w-100-p"
            :class="{ invalid: !to.isValid }"
          >
            <label>الوقت إلى</label>
            <div class="relative d-flex gap-10">
              <select class="w-100" v-model="to.time">
                <option v-for="item in time" :key="item" :value="item">{{ item | formatTime }}</option>
              </select>
              <select class="am-pm" v-model="to.amPm">
                <option value="am">AM</option>
                <option value="pm">PM</option>
              </select>
              
            </div>
            <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
          </div>
        </div>
      </form>
      <div class="d-flex gap-20 mt-10-p btns-box">
        <button @click="clear" class="radius-60 gray dismiss-btn pointer flex-1">إلغاء</button>
        <button @click="submitForm(true)" class="radius-60 main-bg border-0 white font-18 pointer pt-15 pb-15 flex-1">إضافة</button>
        <button @click="submitForm(false)" class="radius-60 main-bg border-0 white font-18 pointer pt-15 pb-15 flex-1">إضافة موعد جديد</button>
      </div>
    </div>
  </normal-modal>
</template>

<script>
import NormalModal from "../../../layouts/NormalModal.vue";
export default {
  emits: ["close","add-new-session"],
  props: ["showModal","tableIntervals", "unavailableIntervals"],
  components: { NormalModal },
  created() {
    this.appendAvailableDays_DropDown();
  },
  methods: {
    submitForm(shouldCloseModal){
      var intervals = this.prepareIntervals();
      if (intervals.length > 0) {
        this.$emit('add-new-session',intervals);
        if (shouldCloseModal)
          this.closeModal();
      }
    },
    generateID(){
      return Math.random().toString(36).substr(2)
    },
    clear(){
      this.day.val=  "";
      this.day.isValid = true;
      this.from.time = ""
      this.from.amPm = "pm";
      this.from.isValid = true
      this.to.time = ""
      this.to.amPm = "pm";
      this.to.isValid = true
      this.closeModal()
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
      var intervalsVals = [...this.tableIntervals].map(int=> int.val).concat(this.unavailableIntervals);
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
          // if (!self.tableIntervals.includes(newInterval))
          //   intervals.push(newInterval)
          if (!intervalsVals.includes(newInterval))
            intervals.push({val: newInterval,id: `no-${self.generateID()}`})

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
        if (self.from.time == '' || self.from.amPm == '') {
          self.from.isValid = false;
        }
        if (self.to.time == '' || self.to.amPm == '') {
          self.to.isValid = false;
        }
        if (!self.day.isValid || !self.from.isValid || !self.to.isValid)
          return false;

        return true;
      }

      function prepareFromTo(self) {
        
        if (self.from.amPm == 'pm') {
          fromHour = +self.from.time.split(':')[0] + 12;
        } else
          fromHour = +self.from.time.split(':')[0];
        if (self.to.amPm == 'pm') {
          toHour = +self.to.time.split(':')[0] + 12;
        } else
          toHour = +self.to.time.split(':')[0];

        fromMinutes = +self.from.time.split(':')[1];
        toMinutes = +self.to.time.split(':')[1];
        fromDate = new Date(self.day.val);
        toDate = new Date(self.day.val);
        
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
      for (let i = 1; i <= 7; i++) {
        let day = new Date(today.getTime() + i * 24 * 60 * 60 * 1000);
        let date = `${day.getFullYear()}-${("0" + (day.getMonth() + 1)).slice(-2)}-${("0" + day.getDate()).slice(-2)}`;

        let formatedDay = `${date} | ${day.toLocaleDateString("ar", {
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
        time: "",
        amPm: "pm",
        isValid: true,
      },
      to: {
        time: "",
        amPm: "pm",
        isValid: true,
      },
      time: [
        '00:00',
        '00:30',
        '01:00',
        '01:30',
        '02:00',
        '02:30',
        '03:00',
        '03:30',
        '04:00',
        '04:30',
        '05:00',
        '05:30',
        '06:00',
        '06:30',
        '07:00',
        '07:30',
        '08:00',
        '08:30',
        '09:00',
        '09:30',
        '10:00',
        '10:30',
        '11:00',
        '11:30'
      ],
    };
  },
  filters: {
      formatTime: function (time) {
        let buffer
          if (time.startsWith('00')) {
            buffer = time.split(':')[0]
            buffer = '12' + ':' + time.split(':')[1];
            return buffer
          }
          return time
      }
  }
};
</script>

<style scoped>
select,
input {
  height: 60px;
  border-radius: 8px;
  border: 1px solid #b2b2b2;
  font-size: 18px;
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
@media (max-width: 767px) {
  .first-row {
    gap: 15px;
  }
  .form-group {
    margin-bottom: 15px!important;
}
.mb-0-p {
    margin-bottom: 0 !important;
}
select,input {
  height: 50px;
}
.btns-box {
  gap: 10px;
}
.btns-box > button {
  font-size: 13px;
  padding: 8px 3px;
}
}
</style>