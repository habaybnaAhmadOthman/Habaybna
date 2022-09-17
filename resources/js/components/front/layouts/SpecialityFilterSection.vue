
<template>
    <div class="p-side-0-p courses-filter" v-if="filters.length > 0">
        <div class="relative mb-35 mb-20-p">
            <div class="courses-categories-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper swipe-box-p p-0-p column-gap-10-p no-scrollbar-p">
                    <!-- Slides -->
                    <div v-for="(category, index) of filters" :key="index" :index="index" class="swiper-slide">
                        <CategoryFilter @change-filter="setFilter" :id="category.id" :value="category.val" :checked="category.isChecked"></CategoryFilter>
                    </div>
                </div>
                <div class="swiper-button-next categories-filter-next do"></div>
                <div class="swiper-button-prev categories-filter-prev do"></div>
            </div>
        </div>
    </div>
</template>
<script>
import 'swiper/swiper-bundle.css'
import CategoryFilter from './CategoryFilter.vue'
export default {
  emits: ['change-filter'],
  props: ['api','watch-url'],
  components: {CategoryFilter},
  data(){
    return {
      filters: [],
      preFiltersFromURL: []
    }
  },
  created(){
    this.shouldListentToURL()
    this.getCategories();
  },
  methods:{
    shouldListentToURL(){
        if (this.watchUrl && this.watchUrl === true) {
            if(this.$router.currentRoute.query.filters !== undefined) {
                this.preFiltersFromURL = this.$router.currentRoute.query.filters.split(',')
            }
        }
    },
    async getCategories(){
        const categories = await this.$store.dispatch(this.api);
        let temp = []
        if (categories) {
            categories.forEach((category)=>{
                temp.push({id:category.id,val: category.title,isChecked: this.preFiltersFromURL.includes(category.id.toString())})
            });
            this.filters = temp;
            // desktop only
            if (!window.matchMedia("(max-width: 677px)").matches) {
                setTimeout(()=>{
                    this.initSwiper();
                },1000)
            }
        }
    },
    setFilter(filter,index) {
        this.filters[index].isChecked = filter.isChecked;
        this.$emit('change-filter',this.filters)
    },
    initSwiper(){
        var swiper2 = new Swiper(".courses-categories-swiper", {
            navigation: {
                nextEl: ".categories-filter-next",
                prevEl: ".categories-filter-prev",
            },
            slidesPerView: 'auto',
            spaceBetween: 12,
        });
    }
  }
}
</script>

<style scoped>
.courses-filter .swiper-slide{
    width: auto;
}

.categories-filter-prev,.categories-filter-next {
    display: none !important;
}
.courses-categories-swiper.swiper-initialized .categories-filter-next,.courses-categories-swiper.swiper-initialized .categories-filter-prev{
    display: block !important;
}
@media (max-width: 767px) {
    .swiper-wrapper{
        padding-right: 10px!important;
        padding-bottom: 1px!important;
    }
}
</style>
