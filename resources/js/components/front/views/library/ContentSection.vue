<template>
  <div>
    <section class="learn-section mt-20">
      <div class="container p-side-12-p" :class="classList">
        <template v-if="title || !listOnly">
          <h2 class="title-line mb-40 mb-20-p">مكتبة المعلومات</h2>
        </template>
        <template v-if="!listOnly">
          <!-- <CategoryFilterSection @change-filter="setFilters" :api="api"></CategoryFilterSection> -->
          <!-- <Courses :filtered-courses="cardsCountFn" :showMoreCard="showMoreCardFn"></Courses> -->
        </template>
          <ContentList  :filtered-articles="cardsCountFn" :showMoreCard="showMoreCardFn"></ContentList>
          <div class="portal-pagination mt-40 mt-40 justify-center d-flex" v-if="!showMoreCardFn">
            <Pagination
              :data="contentTemp"
              @pagination-change-page="getPageDate"
              :limit="10"
            ></Pagination>
          </div>
      </div>
    </section>


  </div>
</template>
<script>
import ContentList from '../../layouts/SmallCardList.vue'
import CategoryFilterSection from '../../layouts/CategoryFilterSection.vue'
import LaravelVuePagination from "laravel-vue-pagination";
export default {
  props: ['cardsCount','showMoreCard','list-only','title','class-list','list-api','can-remove'],
  computed: {
    cardsCountFn(){
      if (this.cardsCount)
        return this.articles.slice(0,this.cardsCount)
      else
        return this.articles
    },
    showMoreCardFn(){
      if (this.showMoreCard === true)
        return true
      else
        return false
    }
  },
  components: {CategoryFilterSection,ContentList,Pagination: LaravelVuePagination,},
  data(){
    return {
      activeFilters: [],
      atLeastOneSelected: false,
      articles: [],
      contentTemp: {},
      api: 'courses/getCategories',
    }
  },
  created(){
    this.getPageDate()
  },
  methods:{
    filteredContents() {
      self = this;
      self.atLeastOneSelected = false;
      const courses = this.articles;
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
            this.articles = courses;
          } else {
            this.articles = [];
          }
        } else {
          this.articles = updatedList;
        }
      // }
    },
    setFilters(updatedFilters) {
      this.activeFilters = updatedFilters;
      this.filteredContents();
    },
    async getPageDate(page){
        let getDataFrom = 'getContent'
        if (typeof page === "undefined") {
            page = 1;
        }
        this.isLoading(true)
        console.log(this.listApi)
        if (this.listApi)
          getDataFrom = this.listApi
        const resp = await this.$store.dispatch(`content/${getDataFrom}`,{page})
        this.isLoading(false)
        this.contentTemp = resp
        this.articles = resp.data
        this.filteredContents()
    },
    isLoading(status) {
      this.$store.commit('isLoading',status)
    },
  }
}
</script>

<style scoped>
.all-courses-page .title-line {
  margin-bottom: 20px;
}
.two-card .small-card-list{
    gap: 2%;
    row-gap: 15px;
}
</style>
<style>
  .portal-pagination .pagination .page-link {
      position: relative;
      display: block;
      padding: 0.5rem 0.75rem;
      margin-left: -1px;
      line-height: 1.25;
      color: #000;
      background-color: #fff;
      border: 1px solid #dee2e6;
  }
.portal-pagination .page-item.active a{
  z-index: 3;
    color: #fff;
    background-color: #780d93;
    border-color: #780d93;
}
.portal-pagination .pagination {
  display: flex;
}
.portal-pagination .page-item .sr-only{
  display: none;
}
@media (max-width: 767px) {
  .portal-pagination .pagination {
    flex-wrap: wrap;
  }
}
</style>
