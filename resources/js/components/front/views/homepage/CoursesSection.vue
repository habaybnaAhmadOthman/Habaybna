<template>
  <section class="learn-section pt-50 pb-50">
    <div class="container-fluid h-100">
      <Categories @change-filter="setFilters"></Categories>
      <Courses :filtered-courses="filteredCourses"></Courses>
    </div>
  </section>
</template>
<script>
import Categories from './CoursesSection_Categories.vue'
import Courses from './CoursesSection_Cards.vue'
export default {
  components: {Categories,Courses},
  data(){
    return {
      activeFilters: {
        v1: false,
        v2: false,
        v3: false,
        v4: false,
        v5: false,
        v6: false,
        v7: false
      },
      atLeastOneSelected: false
    }
  },
  computed: {
    filteredCourses() {
      self = this;
      self.atLeastOneFilterSelected = false;
      const courses = this.$store.getters['courses/courses'];
      const updatedList =  courses.filter(course=>{
        for (let index = 0; index < Object.keys(this.activeFilters).length; index++) {
          let filter =  Object.keys(this.activeFilters)[index];
          // check if user select one category at least
          
          if (this.activeFilters[filter]) {
            self.atLeastOneFilterSelected = true;
          }
          if ( this.activeFilters[filter] && filter == course.category) {
            return true;
          }
        }
      });
      
      if (updatedList.length < 1) {
        if (!self.atLeastOneFilterSelected) {
          return courses
        } else {
          return [];
        }
      } else {
        return updatedList
      }
    }
  },
  methods:{
    setFilters(updatedFilters){
      this.activeFilters = updatedFilters;
    }
  }
}
</script>

<style scoped>


</style>
