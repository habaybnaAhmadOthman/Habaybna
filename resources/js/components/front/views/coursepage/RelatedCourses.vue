<template>
    <div class="related-courses-section" v-if="appendedCourses.length > 0">
        <h6 class="title-line font-27 mb-40">دورة ذات صلة</h6>
        
        <div class="list relative">
            <swiper
                :slides-per-view="3"
                :space-between="30"
                :loop="false"
                @swiper="onSwiper"
                @slideChange="onSlideChange"
                class="pb-10"
                :navigation="{ nextEl:'.related-prev', prevEl: '.related-next'}"
            >
            <swiper-slide v-for="(course, index) in appendedCourses" :key="index">
                <CourseCard :course="course" class="w-100-i" ></CourseCard>
            </swiper-slide>
            </swiper>
            <div class="swiper-button-next related-next"></div>
            <div class="swiper-button-prev related-prev"></div>
        </div>
    </div>
</template>

<script>
    import { Navigation, Pagination } from 'swiper'

    import { SwiperCore, Swiper, SwiperSlide } from 'swiper-vue2'
    // Import Swiper styles
    import 'swiper/swiper-bundle.css'
    SwiperCore.use([Navigation, Pagination])
    import CourseCard from '../../views/onlinecourses/Course_Card.vue'

    export default {
        components:{CourseCard,Swiper,SwiperSlide},
        props: ['courses'],
        data:()=>({
            appendedCourses: []
        }),
        created(){
            this.getCourses();
        },
        methods: {
            async getCourses() {
                if (!this.courses) {
                    await this.$store.dispatch('courses/getAllCourses');
                }

                this.appendedCourses = await this.$store.dispatch('courses/getRelatedCourses');
            },
            onSwiper (swiper) {
                // console.log(swiper)
            },
            onSlideChange () {
                // console.log('slide change')
            }
        }
    }
</script>

<style>
.swiper-button-prev,.swiper-button-next {
    background-size: 100% 100%!important;
    width: 32px;
    height: 52px;
}
.swiper-button-prev:after,.swiper-button-next:after {
    content: none;
}
.swiper-button-next {
    background: url(/images/arrow-right-color.svg) no-repeat!important;    
    right: -60px;
}
.swiper-button-prev {
    background: url(/images/arrow-left-color.svg) no-repeat!important;
    left: -60px;
}
</style>