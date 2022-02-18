<template>
    <div class="related-courses-section">
        <h6 class="title-line font-27 mb-40">دورة ذات صلة</h6>
        
        <div class="list" v-if="appendedCourses.length > 0">
            <VueSlickCarousel :arrows="true" :dots="false" v-bind="sliderSettings">
                <CourseCard v-for="(course, index) in appendedCourses" :course="course" :key="index"></CourseCard>
            </VueSlickCarousel>
        </div>
    </div>
</template>

<script>
    import CourseCard from '../../views/onlinecourses/Course_Card.vue'
    import VueSlickCarousel from 'vue-slick-carousel'
  import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
  import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
    export default {
        components:{CourseCard,VueSlickCarousel},
        data:()=>({
            appendedCourses: [],
            sliderSettings: {
                "dots": false,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 3,
                "slidesToScroll": 3,
                "touchThreshold": 5,
                "rtl": true,
            }
        }),
        created(){
            this.getCourses();
        },
        methods: {
            async getCourses(){
                this.appendedCourses = await this.$store.dispatch('courses/getAllCourses');
            }
        }
    }
</script>

<style>
.slick-slide {
    padding: 0 10px!important;
}
.slick-list {
    margin: 0 -10px!important;
    padding-bottom: 10px!important;
}
.slick-next {
    background: url(/images/arrow-right-color.svg) no-repeat!important;    
    right: -60px;
}
.slick-prev {
    background: url(/images/arrow-left-color.svg) no-repeat!important;
    left: -60px;
}
.slick-next,.slick-prev {
    background-size: 100% 100%!important;
    width: 32px;
    height: 52px;
}
.slick-next:before,.slick-prev:before {
    content: none;
}
</style>