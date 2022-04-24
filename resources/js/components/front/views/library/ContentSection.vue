<template>
  <div>
    <section class="learn-section mt-20">
      <div class="container p-side-12-p">
        <template v-if="title || !listOnly">
          <h2 class="title-line mb-40 mb-20-p">المقالات</h2>
        </template>
        <template v-if="!listOnly">
          <CategoryFilterSection @change-filter="setFilters" :api="api"></CategoryFilterSection>
          <!-- <Courses :filtered-courses="cardsCountFn" :showMoreCard="showMoreCardFn"></Courses> -->
        </template>
          <ContentList :filtered-articles="cardsCountFn" :showMoreCard="showMoreCardFn"></ContentList>
      </div>
    </section>
    
    
  </div>
</template>
<script>
// import Courses from './CoursesSection_Cards.vue'
import ContentList from '../../layouts/SmallCardList.vue'
import CategoryFilterSection from '../../layouts/CategoryFilterSection.vue'
export default {
  props: ['cardsCount','showMoreCard','list-only','title'],
  computed: {
    cardsCountFn(){
      if (this.cardsCount)
        return this.appendedCourses.slice(0,this.cardsCount)
      else
        return this.appendedCourses
    },
    showMoreCardFn(){
      if (this.showMoreCard === true)
        return true
      else
        return false
    }
  },
  components: {CategoryFilterSection,ContentList},
  data(){
    return {
      activeFilters: [],
      atLeastOneSelected: false,
      appendedCourses: [],
      courseTemp: [],
      api: 'courses/getCategories'
    }
  },
  created(){
    this.getCourses();
  },
  methods:{
    filteredCourses() {
      self = this;
      self.atLeastOneSelected = false;
      const courses = this.courseTemp;
      // if (courses) {
        const updatedList =  courses.filter(course=>{
          for (let index = 0; index < this.activeFilters.length; index++) {
            let isChecked =  this.activeFilters[index].isChecked;

            // check if user select one category at least
            if (isChecked) {
              self.atLeastOneSelected = true;
            }
            if ( isChecked ) {
              let selected = course.categories.filter(cat=>{
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
            this.appendedCourses = courses;
          } else {
            this.appendedCourses = [];
          }
        } else {
          this.appendedCourses = updatedList;
        }
      // }
    },
    setFilters(updatedFilters) {
      this.activeFilters = updatedFilters;
      this.filteredCourses();
    },
    async getCourses() {
      const allCourses = await this.$store.getters['courses/courses']
      if ( allCourses.length > 0) {
        this.courseTemp = allCourses
      } else {
        this.courseTemp = await this.$store.dispatch('courses/getAllCourses');
      }
      this.filteredCourses()
    }
  }
}
</script>

<style scoped>
.all-courses-page .title-line {
  margin-bottom: 20px;
}
</style>
