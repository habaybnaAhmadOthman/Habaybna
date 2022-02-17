<template>
  <div>
    <section class="learn-section bg-gray">
      <div class="container">
        <h2 class="title-line mb-40">الدورات التدريبية</h2>
        <Categories @change-filter="setFilters"></Categories>
        <template >
          <Courses :filtered-courses="cardsCountFn" :showMoreCard="showMoreCardFn" ></Courses>
        </template>
      </div>
    </section>
    
    
  </div>
</template>
<script>
import Categories from './CoursesSection_Categories.vue'
import Courses from './CoursesSection_Cards.vue'
export default {
  props: ['cardsCount','showMoreCard'],
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
  components: {Categories,Courses},
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
