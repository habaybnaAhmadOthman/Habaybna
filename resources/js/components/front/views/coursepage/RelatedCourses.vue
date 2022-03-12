<template>
    <div class="related-courses-section" v-if="appendedCourses.length > 0">
        <h6 class="title-line font-27 mb-40">دورة ذات صلة</h6>
        
        <div class="list relative">
            <div class="related-courses-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div v-for="(course, index) in appendedCourses" :key="index" class="swiper-slide">
                        <CourseCard :course="course" class="w-100-i" ></CourseCard>
                    </div>
                </div>
                <div class="swiper-button-next related-next"></div>
                <div class="swiper-button-prev related-prev"></div>
            </div>
            
        </div>
    </div>
</template>

<script>
    import CourseCard from '../../views/onlinecourses/Course_Card.vue'

    export default {
        components:{CourseCard},
        data:()=>({
            appendedCourses: []
        }),
        created() {
            this.getCourses();
        },
        methods: {
            async getCourses(){
                const allCourses = await this.$store.getters['courses/courses']
                if ( allCourses.length > 0) {
                    this.appendedCourses = allCourses
                } else {
                    await this.$store.dispatch('courses/getAllCourses');
                }
                this.appendedCourses = await this.$store.dispatch('courses/getRelatedCourses');
                this.initSwiper()
            },
            initSwiper(){
                 var swiper = new Swiper(".related-courses-swiper", {
                    navigation: {
                        nextEl: ".related-next",
                        prevEl: ".related-prev",
                    },
                    slidesPerView: 3,
                    spaceBetween: 12,
                });
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
    content: none !important;
}
.swiper-button-next {
    background: url(/images/arrow-right-color.svg) no-repeat!important;    
    left: -60px!important;
    transform: rotate(180deg);
}
.swiper-button-prev {
    background: url(/images/arrow-left-color.svg) no-repeat!important;
    right: -60px!important;
    transform: rotate(180deg);
}
.swiper-wrapper {
    padding-bottom: 10px;
}
.my-swiper {
    overflow: hidden !important;
}
.swiper-slide {
    padding: 0 5px;
}
</style>