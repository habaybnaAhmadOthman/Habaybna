<template>
  <div class="book-box" v-if="data.length > 0">
    <p class="font-20 bold main-color mb-20">إختر اليوم</p>
    <div class="d-flex box flex-wrap">
      <RadioTag
        v-for="item in daysWithIntervals"
        :key="item.id"
        :item="item"
        :isDay="true"
        @on-day-select="onDaySelect"
      ></RadioTag>
    </div>

    <!-- start time container -->
    <div class="mt-30" v-if="selectedDay !== null">
      <p class="font-20 bold main-color mb-20">إختر الوقت</p>
      <div class="d-flex box flex-wrap">
        <RadioTag
          v-for="item in daysWithIntervals[selectedDay].intervals"
          :key="item.id"
          :item="item"
          :isDay="false"
          @on-time-select="onTimeSelect"
        ></RadioTag>
      </div>

      <div class="mt-40 d-flex flex-wrap ">
        <div class="d-flex w-38 ml-20 w-100-p m-0-p mb-20-p">
          <CoboneForm @buyAppointment="bookAppointment" @getPromoCode="setPromoCode" :isLoggedIn="isLoggedIn" :specialistID="specialistData.id"></CoboneForm>
          <!-- hidden form -->
          <PaymentForm v-if="paymentFormData" :paymentData="paymentFormData"></PaymentForm>
        </div>
        <button :disabled="canSubmit" @click="checkLogin" class="btn w-100-p">
          إحجز موعدك
        </button>
      </div>
    </div>
    <!-- end time container -->

    <div class="price-box w-50 mt-30 d-flex align-center space-between w-100-p">
        <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> $45</span></p>
        <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> 30 دقيقة</span></p>
    </div>

  </div>
  <div v-else>
    لا يوجد مواعيد متاحة
  </div>
</template>

<script>
import RadioTag from "./Book_RadioTag.vue";
import CoboneForm from "./CoboneForm.vue";
import PaymentForm from '../coursepage/PaymentForm.vue'
export default {
  props: ['specialistData','data'],
  components: { RadioTag,CoboneForm,PaymentForm },
  methods: {
    onDaySelect(id) {
      for (const i in this.daysWithIntervals ) {
          const dayObj = this.daysWithIntervals[i];
          if (dayObj.id == id) {
          // remove selected time from prev selected day
          if (
            !dayObj.selected &&
            this.selectedDay != null &&
            this.selectedTime != null
          ) {
            this.daysWithIntervals[this.selectedDay].intervals[this.selectedTime].selected = false;
            this.selectedTime = null
          }
          dayObj.selected = true;
          this.selectedDay = i;
        } else dayObj.selected = false;

        this.daysWithIntervals[i] = dayObj
      }
    },
    onTimeSelect(id) {
      this.daysWithIntervals[this.selectedDay].intervals.map((item, index) => {
        if (item.id == id) {
          item.selected = true;
          this.selectedTime = index;
        } else item.selected = false;
      });
    },
    isLoading(status) {
        this.$store.commit('isLoading',status)
    },
    setPromoCode(id){
      this.hasPromoCode.id = id;
    },
    checkLogin(){
        if (this.isLoggedIn) {
            this.bookAppointment();
        } else {
            this.$store.commit('loginModal',true);
        }
    },
    async bookAppointment() {
      this.isLoading(true)
      const selectedApt = this.daysWithIntervals[this.selectedDay].intervals[this.selectedTime]
      try {
          const resp = await this.$store.dispatch('specialist/bookAppointment',{
            appointmentID: selectedApt.id,
            slug: this.slug,
            specialistID: this.specialistData.id,
            hasPromoCode:this.hasPromoCode
          });
          this.paymentFormData = resp.SmartRouteParams

      } catch (error) {
          this.$store.commit('alertDialogMsg',error.message);
      }
      
      this.isLoading(false)
      
    },
    getAvailableTimes(){
      const today = new Date(new Date().toISOString()).getTime();
      this.intervals = this.data.filter((apt)=>{
        let appointment = new Date(apt.appointment).getTime();
        if (appointment > today) {
          if (!apt.is_booked)
            return apt
        }
      }).map(int=>{
        return {
            date: int.appointment,
            id: int.id,
            selected: false
        }}
      )
      this.fillDaysData()
    },
    fillDaysData() {
      var day = ''
      const daysObj = {}
      this.intervals.map((interval,index)=> {
        day = interval.date.slice(0,10)
        // if the day not exist in mobile object => then add it
        if (!daysObj.hasOwnProperty(day)) {
          daysObj[day] = {
            selected: false,
            id: index,
            intervals: []
          }
        }
        // add interval to the targeted day in mobile object (mobileDaysInterval)
        daysObj[day].intervals.push(interval)
      })
      this.daysWithIntervals = daysObj
    },
    async buyAppointment(){
        this.isLoading(true)
        try {
            const resp = await this.$store.dispatch('specialist/bookAppointment',{
                courseID:this.getCourseID(),
                hasPromoCode:this.hasPromoCode
            });
            this.paymentFormData = resp.SmartRouteParams

        } catch (error) {
            this.$store.commit('alertDialogMsg',error.message);
        }
        this.isLoading(false)
    },
  },
  computed: {
    canSubmit() {
      console.log(this.selectedDay == null || this.selectedTime == null)
      return this.selectedDay == null || this.selectedTime == null;
    },
    slug(){
      var url = this.specialistData.firstName.split(' ').join('-')
      if (this.specialistData.lastName)
          url += `-${this.specialistData.lastName.split(' ').join('-')}`
      url += `--${this.specialistData.id}`
      return `${url}`
    },
    isLoggedIn() {
      return this.$store.getters["user/isLoggedIn"];
    },
  },
  mounted(){
    this.getAvailableTimes()
  },
  data() {
    return {
      daysWithIntervals: [],
      intervals: [],
      selectedDay: null,
      selectedTime: null,
      // for payment
      paymentFormData:null,
      hasPromoCode: {
          id: ''
      },
    };
  },
};
</script>

<style scoped>
.book-box .box {
  gap: 20px;
}
.btn {
  border-radius: 30px;
  width: 250px;
}
.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}
@media (max-width: 767px) {
    .btn {
      height: 50px;
    }
}
</style>