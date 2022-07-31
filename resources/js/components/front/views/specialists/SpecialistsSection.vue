<template>
  <div>
    <section class="specialists-section-con mt-20-p">
      <div class="container">
        <template  v-if="showTitle">
          <h2 class="font-26 bold main-color p-side-12-p">نقوم بإيصالك للمختص المناسب لك و لأسرتك</h2>
          <p class="font-20 black-2 mb-40 mb-20-p p-side-12-p">يقوم فريق حبايبنا.نت بتوجيهك و مساعدتك للحصول على جلسات مع أخصائيين ئوي كفاءات و خبرات عالية</p>
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
        return this.shuffle(this.appendedSpecialists).slice(0,this.cardsCount)
      } else
        return this.appendedSpecialists
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
      appendedSpecialists: [],
      specialistTemp: [],
      isDataReady: false,
      canLoadData: true,
      api: 'courses/getCategories',
      currentPage: 1
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
    filteredSpecialists() {
      self = this;
      self.atLeastOneSelected = false;
      const specialists = this.specialistTemp;
      // if (specialists) {
        const updatedList =  specialists.filter(user=>{
          for (let index = 0; index < this.activeFilters.length; index++) {
            let isChecked =  this.activeFilters[index].isChecked;

            // check if user select one category at least
            if (isChecked) {
              self.atLeastOneSelected = true;
            }
            if ( isChecked ) {
              let selected = user.categories.filter(cat=>{
                return cat.id == this.activeFilters[index].id
              })
              if (selected.length > 0) {
                return true;
              }
            }
          }
        });
        if (updatedList.length < 1) {
          if (!self.atLeastOneSelected) {
            this.appendedSpecialists = specialists;
          } else {
            this.appendedSpecialists = [];
          }
        } else {
          this.appendedSpecialists = updatedList;
        }
      // }
    },
    setFilters(updatedFilters) {
      this.activeFilters = updatedFilters;
      this.filteredSpecialists();
    },
    getOne() {
      return { 
          avatar: "default.jpg",
          firstName: 'n' + Math.floor(Math.random()* 11),
          id: Math.random(),
          lastName: "الرمحي",
          specialization: "التربية الخاصة"
        }
    },
    async getData(page) {
      this.canLoadData = false
      if (typeof page === "undefined") {
        page = 1;
      }
      this.currentPage = page
      const loadedSpecialists =  (await this.$store.dispatch('specialist/getSpecialistsList',{page: this.currentPage})).data.map((sp)=>{
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
        // this.specialistTemp.push(this.getOne())
        this.filteredSpecialists()
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
