<template>
  <div>
    <section class="learn-section bg-gray mt-20-p">
      <div class="container">
        <h2 class="title-line mb-40 mb-20-p p-side-12-p">الدورات التدريبية</h2>
        <CategoryFilterSection v-if="!showMoreCardFn" @change-filter="setFilters" :api="api"></CategoryFilterSection>
        <template >
          <Courses :filtered-courses="cardsCountFn" :showMoreCard="showMoreCardFn"></Courses>
        </template>
      </div>
    </section>
    
    
  </div>
</template>
<script>
import Courses from './CoursesSection_Cards.vue'
import CategoryFilterSection from '../../layouts/CategoryFilterSection.vue'
export default {
  props: ['cardsCount','showMoreCard'],
  computed: {
    cardsCountFn(){
      if (this.cardsCount) {
        return this.shuffle(this.appendedCourses).slice(0,this.cardsCount)
      } else
        return this.appendedCourses
    },
    showMoreCardFn(){
      if (this.showMoreCard === true)
        return true
      else
        return false
    }
  },
  components: {Courses,CategoryFilterSection},
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
    shuffle(a) {
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    },
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
