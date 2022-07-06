<template>
  <div class="sesstion-table-box">
    <div class="sessions-table pt-10 table-border">
      <!-- table head -->
      <div class="d-flex align-center space-between pb-10 p-side-15">
        <p class="font-20 gray">جدول المواعيد</p>
        <button @click="toggleAddSessionModal(true)" class="add-new-btn bg-yellow white font-18 radius-60 border-0 p-10 p-side-100 pointer">إضافة وقت جديد</button>
      </div>
      <!-- end table head -->

      <!-- day,time labels -->
      <div class="day-time-labels table-border-b table-border-t  center d-flex">
        <div class="w-60 pt-20 pb-10 table-border-l">
          <p>اليوم</p>
        </div>
        <div class="w-40 pt-20 pb-10">
          <p>الوقت</p>
        </div>
      </div>
      <!-- end day,time labels -->

      <Col></Col>
    </div>
    <div class="mt-40 d-flex flex-end">
      <button class="btn-main">حفظ</button>
    </div>

    
    <AddSession 
    :showModal="isAddNewSessionModal"
    @close="toggleAddSessionModal(false)"></AddSession>
    <portal-target name="add-session-modal"></portal-target>
  </div>
</template>

<script>

import Col from './SessionTableTimes_Col.vue'
import AddSession from './AddSession.vue'
export default {
  components:{Col,AddSession},
  data(){
    return {
      isAddNewSessionModal: true,
    }
  },
  methods: {
    toggleAddSessionModal(status){
      this.isAddNewSessionModal = status
    }
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
</style>