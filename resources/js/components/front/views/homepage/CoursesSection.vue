<template>
  <section class="learn-section pt-50 pb-50">
    <Banner></Banner>
    <div class="container-fluid h-100">
      <Categories @change-filter="setFilters"></Categories>
      <template v-if="appendedCourses.length">
        <Courses :filtered-courses="appendedCourses"></Courses>
      </template>
    </div>
  </section>
</template>
<script>
import Categories from './CoursesSection_Categories.vue'
import Courses from './CoursesSection_Cards.vue'
import Banner from './CoursesSection_Banner.vue'
export default {
  components: {Categories,Courses,Banner},
  data(){
    return {
      activeFilters: [],
      atLeastOneSelected: false,
      appendedCourses: []
    }
  },
  created(){
    this.getCourses();
  },
  methods:{
    filteredCourses() {
      self = this;
      self.atLeastOneSelected = false;
      const courses = this.$store.getters['courses/courses'];

      const updatedList =  courses.filter(course=>{
        for (let index = 0; index < this.activeFilters.length; index++) {
          let isChecked =  this.activeFilters[index].isChecked;
          
          // check if user select one category at least
          if (isChecked) {
            self.atLeastOneSelected = true;
          }
          if ( isChecked && course.category.includes(this.activeFilters[index].id)) {
            return true;
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
      await this.$store.dispatch('courses/getAllCourses');
      this.filteredCourses()
    }
  }
}
</script>

<style scoped>


</style>
