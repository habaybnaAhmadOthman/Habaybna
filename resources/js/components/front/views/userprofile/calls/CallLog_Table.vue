<template>
  <div class="log-table">
    <div class="do">
      <div class="header d-flex bg-gray">
        <div>اليوم</div>
        <div>الوقت</div>
        <div>حالة الطفل</div>
        <div>وضع الطفل</div>
        <div>عمر الطفل عند معرفة حالته</div>
        <div>المشكلة</div>
        <div>رابط المكالمات</div>
        <div>حالة المكالمة</div>
        <div>التوصية</div>
      </div>
    </div>
    <div class="body">
      <TableCol
        v-for="call in data"
        :key="call.id"
        :data="call"
        @add-recommendation="addRecommendation"
        @show-recommendation="toggleUserRecomendationModal"
      ></TableCol>
      <div class="portal-pagination mt-40 mt-40 justify-center d-flex">
        <Pagination
          :data="contentTemp"
          @pagination-change-page="getData"
          :limit="paginationLimit"
        ></Pagination>
      </div>
    </div>

    <!-- add recomendation modal -->
    <RecommendationModal
      :show="recommendationModal.show"
      :callID="recommendationModal.callID"
      :specialistID="specialistInfo.id"
      @loading="isLoading"
      @close="toggleRecomendationModal"
    ></RecommendationModal>

    <!-- user recommendation modal -->
    <normal-modal
      :show="userRecommendationModal.show"
      :fixed="false"
      portal="show-user-recommendation"
      @close="toggleUserRecomendationModal"
      :modalClass="'sticky-header'"
    >
    <div class="user-rec-text">
      <textarea class="font-18 black form-control" v-model="userRecommendationModal.msg"></textarea>
      <button @click="updateUserRecommendation" class="radius-60 main-bg border-0 w-100 mt-30 white font-18 pointer pt-15 pb-15 flex-1">تعديل</button>
    </div>
    </normal-modal>
  </div>
</template>

<script>
import TableCol from "./CallLog_TableCol.vue";
import RecommendationModal from "./CallLog_RecommendationModal.vue";
import NormalModal from "../../../layouts/NormalModal.vue";
import LaravelVuePagination from "laravel-vue-pagination";
export default {
  components: { TableCol, RecommendationModal,NormalModal,Pagination: LaravelVuePagination },
  props: ["filters"],
  data() {
    return {
      data: [],
      currentPage: 1,
      contentTemp: {},
      paginationLimit: 2,
      recommendationModal: {
        show: false,
        callID: null,
      },
      userRecommendationModal:{
        show:false,
        callID: null,
        msg: ''
      }
    };
  },
  methods: {
    async getData(page) {
      this.isLoading(true);
      if (typeof page === "undefined") {
        page = 1;
      }
      try {
        const statuses = {
          "0": 'scheduled',
          "1": 'succeeded',
          "2": 'missed',
        }
        
        this.currentPage = page;
        // call api
        let temp = await this.$store.dispatch('specialist/getSpecialistCallsLog',{
          specialistID: this.specialistInfo.id,
          page: this.currentPage,
          filters: this.filters
        })

        // format data
        this.data = temp.data.map(call=> {
          const obj = {
            id: call.calls_status.appointment_id,
            date: call.appointment,
            callLink: 'http://localhost:8000/profile/my-call-log',
            callStatus: statuses[call.calls_status.status],
            recommendation: '',
            childStatus: '---',
            childAge: null,
            discoveredAge: '---',
            childSituation: '---',
            problem: '---'

          }
          if (call.appointment_child_info && call.appointment_child_info.child_situation) {
            obj.childStatus= call.appointment_child_info.child_status;
            obj.childAge= call.appointment_child_info.age;
            obj.discoveredAge= call.appointment_child_info.discovered_age;
            obj.childSituation= call.appointment_child_info.child_situation;
            obj.problem= call.appointment_child_info.message
          }
          if (call.appointment_child_info && call.appointment_child_info.recommendation) {
            obj.recommendation= call.appointment_child_info.recommendation
          }

          return obj
        } )


      } catch {
        this.$store.commit('alertDialogMsg','حصل خطأ ما');
      }
      this.isLoading(false);
    },
    addRecommendation(callID){
      this.recommendationModal.callID = callID
      this.toggleRecomendationModal();
    },
    toggleRecomendationModal(params) {
      this.recommendationModal.show = !this.recommendationModal.show
      if (params && params.recommendationAdded) {
        this.getData(this.currentPage)
      }
    },
    toggleUserRecomendationModal(userRec) {
      if (typeof userRec !== "undefined" ) {
        this.userRecommendationModal.msg = userRec.msg
        this.userRecommendationModal.callID = userRec.callID
      }
      this.userRecommendationModal.show = !this.userRecommendationModal.show
    },
    updateUserRecommendation(){
      if (this.userRecommendationModal.msg == '') {
        this.$store.commit('alertDialogMsg','يرجى كتابة توصية')
        return ;
      }
      
      this.$store.dispatch('specialist/addRecommendation',{
        callID: this.userRecommendationModal.callID,
        specialistID: this.specialistInfo.id,
        message: this.userRecommendationModal.msg
      })
      this.toggleUserRecomendationModal()
      this.getData(this.currentPage)
    },
    isLoading(status) {
      this.$store.commit("isLoading", status);
    },
    getPaginationLimit(){
      if (this.isMobile)
        this.paginationLimit = 1
    },
  },
  computed: {
    specialistInfo() {
      return this.$store.getters["user/userData"];
    },
    isMobile(){
      return window.matchMedia("(max-width: 677px)").matches
    },
    getUserType(){
      return this.$store.getters['user/userData'].type
    },
    getUserTypeApi(){
      if (this.getUserType == 'parent')
        return ''

      return ''
    }
  },
  mounted() {
    this.getPaginationLimit()
    this.getData();
  },
  watch: {
    filters(o,n) {
      this.getData()
    }
  }
};
</script>

<style scoped>
.log-table {
  overflow-y: auto;
}
.header {
  padding: 23px 0;
}
.header > div {
  flex: 1;
  text-align: center;
  font-weight: bold;
  flex-basis  : 122px;
  flex-grow: 0;
  flex-shrink: 0;
}
.user-rec-text {
  max-height: 70vh;
  overflow-y: auto;
}
.user-rec-text textarea {
  height: 200px!important;
}
@media (max-width: 767px) {
  .log-col > div {
    flex-basis: inherit;
    flex-grow: unset;
    flex-shrink: unset;
  }
}
</style>
