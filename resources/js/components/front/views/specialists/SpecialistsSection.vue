<template>
  <div>
    <section class="specialists-section-con mt-20-p">
      <div class="container">
        <template  v-if="showTitle">
          <h2 class="font-26 bold main-color p-side-12-p center mb-30">تعرف على الأخصائيين</h2>
        </template>
        <CategoryFilterSection v-if="!showMoreCardFn" @change-filter="setFilters" :api="api"></CategoryFilterSection>
        <template>
          <SpecialistsCards @load-more-data="getData" :page="currentPage" :can-load-data="canLoadData" v-if="isDataReady" :data="cardsCountFn" :showMoreCard="showMoreCardFn"></SpecialistsCards>
        </template>
      </div>
    </section>
    
    
  </div>
</template>
<script>
import SpecialistsCards from './SpecialistsSection_Cards.vue'
import CategoryFilterSection from '../../layouts/CategoryFilterSection.vue'
export default {
  props: ['cardsCount','showMoreCard','list-only','show-title'],
  computed: {
    cardsCountFn(){
      if (this.cardsCount) {
        return this.shuffle(this.specialistTemp).slice(0,this.cardsCount)
      } else
        return this.specialistTemp
    },
    showMoreCardFn(){
      if (this.showMoreCard === true)
        return true
      else
        return false
    }
  },
  components: {SpecialistsCards,CategoryFilterSection},
  data(){
    return {
      activeFilters: [],
      atLeastOneSelected: false,
      specialistTemp: [],
      isDataReady: false,
      canLoadData: true,
      api: 'courses/getCategories',
      currentPage: 1,
      selectedFilters: []
    }
  },
  created(){
    this.getData();
  },
  methods:{
    shuffle(a) {
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    },
    setFilters(updatedFilters) {
      this.selectedFilters = updatedFilters.filter((fl)=>fl.isChecked).map((chkd)=>chkd.id)
      this.getData();
    },
    async getData(page) {
      this.canLoadData = false
      if (typeof page === "undefined") {
        page = 1;
        this.specialistTemp = []
      }
      this.currentPage = page
      
      const loadedSpecialists =  (await this.$store.dispatch('specialist/getSpecialistsList',{page: this.currentPage,filters: this.selectedFilters})).data.map((sp)=>{
        return {
          avatar: sp.specialist.avatar,
          firstName: sp.specialist.firstName ,
          lastName: sp.specialist.lastName,
          specialization: sp.specialist.specialization,
          id: sp.specialist.user_id
        }
      });
      if (loadedSpecialists.length > 0) {
        this.specialistTemp.push(...loadedSpecialists)
        this.canLoadData = true
      }
      this.isDataReady = true
    }
  }
}
</script>

<style scoped>
.all-courses-page .title-line {
  margin-bottom: 20px;
}
</style>
