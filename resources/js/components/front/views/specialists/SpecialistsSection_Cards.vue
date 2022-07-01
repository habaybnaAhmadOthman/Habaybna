<template>
    <div class="specialists-list-section pb-30 pb-20-p">
        <div class="container">
            <div class="specialists-container">
                <!-- <template v-if="filteredCourses.length">
                    <div class="courses-list d-flex flex-wrap p-side-12-p" :class="listClass">
                        <SpecialistCard v-for="(course, index) in filteredCourses" :course="course" :key="index"></SpecialistCard>
                        <div class="course-box shadow w-31 radius-10 more main-bg w-100-p do" v-if="showMoreCard">
                            <router-link to="/all-courses" class="white-i font-23 h-100 d-block w-100">اكتشف المزيد</router-link>
                        </div>
                    </div>
                </template>
                <div v-else class="w-100 center">
                    <h2 class="font-32 main-color bold">لا يوجد أخصائيين</h2>
                </div> -->
                <ul class="specialists-list flex-wrap-p d-flex flex-wrap p-side-12-p wrap space-between list-gap" :class="listClass">
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <Card class="w-32 w-100-p"></Card>
                    <div class="show-more-articles bg-blue relative shadow w-50 d-flex justify-center m-side-auto radius-10 more w-100-p" v-if="showMoreCard">
                        <router-link to="/all-specialists" class="white-i flex-all relative next-arrow font-27 font-20-p h-100 d-block w-100">إستعراض الأخصائيين</router-link>
                    </div>
                </ul>
                <div v-if="!showMoreCard && canLoadMore" class="load-more container shadow center bg-white radius-12 mt-30 d-flex align-center justify-center pt-30 pb-30">
                    <img src="/images/loader.gif" width="50" height="50" alt="loading" >
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Card from "./HorizontalCard.vue"
export default {
    props: ["filteredCourses","showMoreCard","list-class"],
    components: {Card},
    data(){
        return {
            canLoadMore:true,
        }
    },
    methods:{
        handleScroll(){
            var loadMoreEl = document.querySelector('.load-more');
            if (loadMoreEl && loadMoreEl.getBoundingClientRect().bottom < window.innerHeight && this.canLoadMore) {
                this.canLoadMore = false;
                setTimeout(() =>{
                    this.canLoadMore = true
                },2000)
            }
        },
    },
    mounted() {
        window.addEventListener('scroll',this.handleScroll)
    },
    destroyed(){
        window.removeEventListener('scroll',this.handleScroll)
    }
};
</script>

<style scoped>
.list-gap {
    row-gap: 20px;
}

.course-box.more {
    position: relative;
    min-height: 324px;
}
.show-more-articles {
    height: 120px;
}
.show-more-articles:before {
        content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url(/images/more-courses.png);
    mix-blend-mode: soft-light;
    position: absolute;
    pointer-events: none;
    background-position: top;
}
.next-arrow:after {
    content: '';
    background: url(/images/right-arrow-white.png) no-repeat;
    background-size: 15px 24px;
    background-position: center;
    width: 15px;
    height: 24px;
    position: absolute;
    left: 40px;
    top: 0;
    bottom: 0;
    margin: auto;
    transform: rotate(180deg);
}
@media (max-width: 767px) {
    .show-more-articles {
        height: 40px;
    }
}
</style>
