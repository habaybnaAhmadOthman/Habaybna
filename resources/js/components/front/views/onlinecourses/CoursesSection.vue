<template>
  <div>
    <section class="learn-section bg-gray">
      <Banner></Banner>
      <div class="container h-100">
        <CoursesFeatures></CoursesFeatures>
        <h2 class="title-line mb-40">الدورات التدريبية</h2>
        <Categories @change-filter="setFilters"></Categories>
        <template v-if="appendedCourses.length">
          <Courses :filtered-courses="appendedCourses"></Courses>
        </template>
      </div>
    </section>
    <CombaniesBanner></CombaniesBanner>
  </div>
</template>
<script>
import Categories from './CoursesSection_Categories.vue'
import Courses from './CoursesSection_Cards.vue'
import Banner from './CoursesSection_Banner.vue'
import CoursesFeatures from './CoursesFeatures.vue'
import CombaniesBanner from '../../layouts/CompaniesBanner.vue'
export default {
  components: {Categories,Courses,Banner,CoursesFeatures,CombaniesBanner},
  data(){
    return {
      activeFilters: [],
      atLeastOneSelected: false,
      appendedCourses: [],
      courseTemp: []
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
      const updatedList =  courses.filter(course=>{
        for (let index = 0; index < this.activeFilters.length; index++) {
          let isChecked =  this.activeFilters[index].isChecked;

          // check if user select one category at least
          if (isChecked) {
            self.atLeastOneSelected = true;
          }
          if ( isChecked ) {
            // .id.includes(this.activeFilters[index].id)
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
    },
    setFilters(updatedFilters){
      this.activeFilters = updatedFilters;
      this.filteredCourses();
    },
    async getCourses(){
      this.courseTemp = await this.$store.dispatch('courses/getAllCourses');
      this.filteredCourses()
    }
  }
}
</script>

<style scoped>


</style>
