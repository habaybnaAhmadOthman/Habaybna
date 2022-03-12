
<template>
    <div class="p-side-0-p courses-filter" v-if="filters.length > 0">
        <div class="relative mb-35">
            <div class="courses-categories-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div v-for="(category, index) of filters" :key="index" :index="index" class="swiper-slide">
                        <li class="">
                            <input
                                @change="setFilter"
                                type="checkbox"
                                :id="category.id"
                                :value="category.val"
                            /><label class="center gray radius-60 font-18" :for="category.id">{{category.val}}</label>
                        </li>
                    </div>
                </div>
                <div class="swiper-button-next categories-filter-next"></div>
                <div class="swiper-button-prev categories-filter-prev"></div>
            </div>
        </div>
    </div>
</template>
<script>
import 'swiper/swiper-bundle.css'
export default {
  emits: ['change-filter'],
  data(){
    return {
      filters: []
    }
  },
  created(){
      this.getCategories();
  },
  methods:{
    async getCategories(){
        const categories = await this.$store.dispatch('courses/getCategories');
        let temp = []
        if (categories) {
            categories.forEach((category)=>{
                // this.filters[category.id] = {id:category.id,val: category.title}
                temp.push({id:category.id,val: category.title,isChecked: false})
            });
            this.filters = temp;
            setTimeout(()=>{
                this.initSwiper();
            },1000)
        }
    },
    setFilter(e) {
    //   const inputID = e.target.id;
      const isActive = e.target.checked;
      const index = +e.target.parentNode.parentNode.getAttribute('index');
      this.filters[index].isChecked = isActive;
    //   const updateFilters = {
    //     ...this.filters,
    //     [inputID] : isActive
    //   }
    //   this.filters = updateFilters;
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
li label {
    display: inline-block;
        padding: 11px 23px;
    white-space: nowrap;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all 0.3s;
    min-width: 110px;
    cursor: pointer;
    border: 1px solid #780d93;
}

li input[type="checkbox"]:checked + label {
    background-color: #660066;
    color: #fff!important;
    transition: all 0.2s;
}

li input[type="checkbox"] {
    display: absolute;
}
li input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

@media (max-width: 767px) {
    li label[data-v-3023a41f] {
        padding: 4px 14px;
        min-width: auto;
    }
}
</style>
