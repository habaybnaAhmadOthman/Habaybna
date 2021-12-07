<template>
  <section class="learn-section pt-50 pb-50">
    <Banner></Banner>
    <div class="container-fluid h-100">
      <Categories @change-filter="setFilters"></Categories>
      <template v-if="filteredCourses.length">
        <Courses :filtered-courses="filteredCourses"></Courses>
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
      cc: []
    }
  },
  computed: {
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
          self.cc = courses;
          return courses
        } else {
          self.cc = []
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
