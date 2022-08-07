<template>
  <div class="log-table">
    <div class="do">
      <div class="header d-flex bg-gray">
        <div>اليوم</div>
        <div>الوقت</div>
        <div>الطفل</div>
        <div>ولي الأمر</div>
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
      <p class="font-18 black pt-30">{{userRecommendationModal.msg}}</p>
    </div>
    </normal-modal>
  </div>
</template>

<script>
import dumyData from "./data";
import TableCol from "./CallLog_TableCol.vue";
import RecommendationModal from "./CallLog_RecommendationModal.vue";
import NormalModal from "../../../layouts/NormalModal.vue";
export default {
  components: { TableCol, RecommendationModal,NormalModal },
  props: ["filters"],
  data() {
    return {
      data: [],
      currentPage: 1,
      recommendationModal: {
        show: false,
        callID: null,
      },
      userRecommendationModal:{
        show:false,
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
      this.currentPage = page;
      await this.$store.dispatch('specialist/getSpecialistCallsLog',{
        specialistID: this.specialistInfo.id,
        page: this.currentPage,
        filters: this.filters
      })

      this.data = await dumyData;
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
    toggleUserRecomendationModal(msg) {
      if (typeof msg !== "undefined" ) {
        this.userRecommendationModal.msg = msg  
      }
      this.userRecommendationModal.show = !this.userRecommendationModal.show
    },
    isLoading(status) {
      this.$store.commit("isLoading", status);
    },
  },
  computed: {
    specialistInfo() {
      return this.$store.getters["user/userData"];
    },
  },
  mounted() {
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
.header {
  padding: 23px 0;
}
.header > div {
  flex: 1;
  text-align: center;
  font-weight: bold;
}
.user-rec-text {
  max-height: 70vh;
  overflow-y: auto;
}
</style>