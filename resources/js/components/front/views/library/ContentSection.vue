<template>
  <div>
    <section class="learn-section mt-20">
      <div class="container p-side-12-p" :class="classList">
        <template v-if="title || !listOnly">
          <h2 class="title-line mb-40 mb-20-p">مكتبة حبايبنا</h2>
        </template>
        <template v-if="!listOnly">
          <CategoryFilterSection :watch-url="true" @change-filter="setFilters" :api="api"></CategoryFilterSection>
          <!-- <Courses :filtered-courses="cardsCountFn" :showMoreCard="showMoreCardFn"></Courses> -->
        </template>
          <ContentList :current-page="currentPage" class-list="grid-2 grid-1-p" :filtered-articles="cardsCountFn" :showMoreCard="showMoreCardFn"></ContentList>
          <div class="portal-pagination mt-40 mt-40 justify-center d-flex" v-if="!showMoreCardFn">
            <Pagination
              :data="contentTemp"
              @pagination-change-page="getPageDate"
              :limit="paginationLimit"
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
  props: ['cardsCount','showMoreCard','list-only','title','class-list','list-api','can-remove','save-current-page'],
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
    },
    isMobile(){
      return window.matchMedia("(max-width: 677px)").matches
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
      paginationLimit: 2,
      currentPage: null
    }
  },
  created() {
    this.getPaginationLimit()
    this.loadFiltersFromURL()
    this.getPageDate()
  },
  methods:{
    getPaginationLimit(){
      if (this.isMobile)
        this.paginationLimit = 1
    },
    loadFiltersFromURL(){
      const queryFilters = this.$router.currentRoute.query.filters
      if (queryFilters)
        this.activeFilters = queryFilters.split(',')
    },
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
      this.activeFilters = []
      updatedFilters.filter((filter)=> {
        if (filter.isChecked)
          this.activeFilters.push(filter.id)
      })
      this.getPageDate();
    },
    async getPageDate(page){
        let getDataFrom = 'getContent'
        if (typeof page === "undefined") {
            page = 1;
            if (localStorage.getItem('prev_page')) {
              page = localStorage.getItem('prev_page');
              localStorage.removeItem('prev_page')
            }
        }

        if (localStorage.getItem('prev_filters')) {
          this.activeFilters = localStorage.getItem('prev_filters');
          localStorage.removeItem('prev_filters')
        }
        this.currentPage = page
        this.isLoading(true)
        if (this.listApi)
          getDataFrom = this.listApi
        const resp = await this.$store.dispatch(`content/${getDataFrom}`,{page,filters: this.activeFilters})
        this.isLoading(false)
        this.contentTemp = resp
        this.articles = resp.data
        this.filteredContents();
        this.updateURL();
    },
    updateURL(){
      if(!this.listOnly) {
        const query = Object.assign({}, this.$route.query);
        query.page = this.currentPage.toString()
        let isSameURL = true;
        if (this.activeFilters.length > 0) {
          query.filters = this.activeFilters.toString()
          if (query.filters != this.$router.currentRoute.query.filters) {
            isSameURL = false
          }
        } else {
          if (query.hasOwnProperty('filters')) {
            isSameURL = false
            delete query.filters;
          }
        }


        if (this.$router.currentRoute.query.page !== undefined) {
          if (this.$router.currentRoute.query.page != query.page)
            isSameURL = false
        } else {
          isSameURL = false
        }


        if (!isSameURL) {
          this.$router.replace({ query });

        }
      }
    },
    isLoading(status) {
      this.$store.commit('isLoading',status)
    },
  },
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
