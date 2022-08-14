<template>
  <div class="sesstion-table-box">
    <div class="sessions-table pt-10 table-border">
      <!-- table head -->
      <div class="d-flex align-center space-between pb-10 p-side-15 p-side-0-p">
        <p class="font-20 gray font-16-p bold-p">جدول المواعيد</p>
        <button @click="toggleAddSessionModal(true)" class="add-new-btn bg-yellow white font-18 radius-60 border-0 p-10 p-side-100 pointer">إضافة وقت جديد</button>
      </div>
      <!-- end table head -->

      <!-- day,time labels #desktop -->
      <div class="do">
        <div class="day-time-labels table-border-b table-border-t  center d-flex">
          <div class="w-60 pt-20 pb-10 table-border-l">
            <p>اليوم</p>
          </div>
          <div class="w-40 pt-20 pb-10">
            <p>الوقت</p>
          </div>
        </div>
      </div>
      <!-- end day,time labels -->

      <!-- desktop records -->
      <div class="do">
        <transition-group name="list" tag="ul" class="table-added-cols">
            <Col @remove="removeCol" v-for="(interval) in intervals" :key="interval.id" :data="interval"></Col>
        </transition-group>
      </div>

      <!-- mobile records -->
      <div class="mo">
        <transition-group name="list" tag="ul" class="table-added-cols-mo d-flex flex-column gap-15">
          <ColMobile @remove-interval="removeCol" @remove-day="removeDayWithIntervals" v-for="day in mobileDaysInterval" :key="day[0].id" :day="day"></ColMobile>
        </transition-group>
      </div>

    </div>
    <div class="mt-40 d-flex flex-end">
      <button class="btn-main" @click="saveAppointments">حفظ</button>
    </div>


    <AddSession
    :tableIntervals="intervals"
    :showModal="isAddNewSessionModal"
    :unavailableIntervals="unavailableIntervalsArr"
    @add-new-session="addNewSessionFn"
    @close="toggleAddSessionModal(false)"></AddSession>
    <portal-target name="add-session-modal"></portal-target>
  </div>
</template>

<script>

import Col from './SessionTableTimes_Col.vue'
import ColMobile from './SessionTableTimes_ColMobile.vue'
import AddSession from './AddSession.vue'
export default {
  components:{Col,AddSession,ColMobile},
  mounted(){
    this.getAppointments()
  },
  data(){
    return {
      isAddNewSessionModal: false,
      mobileDaysInterval: {}, // just for draw data
      intervals: [],
      alreadySavedIntervals: [],
      unavailableIntervalsArr:[],
      specialistData:null
    }
  },
  computed:{
    slug(){
      var url = this.specialistData.firstName.split(' ').join('-')
      if (this.specialistData.lastName)
          url += `-${this.specialistData.lastName.split(' ').join('-')}`
      url += `--${this.specialistData.id}`
      return `${url}`
    },
    specialistInfo(){
      return this.$store.getters['user/userData'];
    }
  },
  methods: {
    async saveAppointments(){
      const saveThoseIntervalsOnly = this.intervals.filter(int=>{
        if (!this.alreadySavedIntervals.includes(int.val))
          return int
      }).map(interval=>interval.val)

      if (saveThoseIntervalsOnly.length > 0) {
        this.isLoading(true)
        await this.$store.dispatch('specialist/setAppointments',saveThoseIntervalsOnly)
        this.isLoading(false)
        this.forceRefresh()
      } else {
        this.$store.commit('alertDialogMsg','لا يوجد ما يمكن إضافته');
      }


    },
    async getAppointments(){
      const today = new Date(new Date().toISOString()).getTime();
      this.specialistData = this.specialistInfo;
      this.unavailableIntervalsArr = []
      const data = await this.$store.dispatch('specialist/getAppointments',this.slug);
      this.intervals = data.filter((apt)=>{
        let appointment = new Date(apt.appointment).getTime();
        if (appointment > today) {
          if (apt.is_booked) {
            this.unavailableIntervalsArr.push(apt.appointment)
          } else
            return apt
        }
      }).map(int=>{
        return {
            val: int.appointment,
            id: int.id
        }}
      )

      // when you want to save new intervals , execlude this obj
      this.alreadySavedIntervals = [...this.intervals].map(int=>int.val)
      this.sortIntervals()
    },
    toggleAddSessionModal(status){
      this.isAddNewSessionModal = status
    },
    sortIntervals(){
      this.intervals = this.intervals.sort((a,b) => new Date(a.val).getTime() - new Date(b.val).getTime());
      this.fillMobileTable()
    },
    addNewSessionFn(intervals){
      this.intervals.push(...intervals);
      this.sortIntervals()
    },
    fillMobileTable() {
      var day = ''
      const daysObj = {}
      this.intervals.map(interval=> {
        day = interval.val.slice(0,10)
        // if the day not exist in mobile object => then add it
        if (!daysObj.hasOwnProperty(day)) {
          daysObj[day] = []
        }
        // add interval to the targeted day in mobile object (mobileDaysInterval)
        daysObj[day].push(interval)
      })
      this.mobileDaysInterval = daysObj
    },
    removeCol(colID,isFromDB){
      this.intervals = this.intervals.filter((int)=> int.id != colID);
      if (isFromDB) {
        this.$store.dispatch('specialist/removeInterval',{
          id: colID,
          specialistID: this.specialistData.id
        })
      }

      this.sortIntervals();
    },
    removeDayWithIntervals(dayDate){
      // this.intervals = this.intervals.filter((time)=> !time.startsWith(dayDate));
      // this.sortIntervals()
    },
    isLoading(status) {
        this.$store.commit('isLoading',status)
    },
    forceRefresh(){
      this.$store.commit("forceRefresh");
    },
  }
};
</script>

<style scoped>
.table-border {
  border: 1px solid #F2F2F2;
}
.table-border-t {
  border-top: 1px solid #F2F2F2;
}
.table-border-b {
  border-bottom: 1px solid #F2F2F2;
}
.table-border-l {
  border-left: 1px solid #F2F2F2;
}
.btn-main {
  width: 183px;
  height: 51px;
}
.list-move,
.list-enter-active,
.list-leave-active {
  transition:all 0.3s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(-50px);
}
.list-leave-active {
  position: absolute;
}
@media (max-width: 767px) {
  .add-new-btn {
    padding: 5px 20px;
    font-size: 15px;
  }
}
</style>
