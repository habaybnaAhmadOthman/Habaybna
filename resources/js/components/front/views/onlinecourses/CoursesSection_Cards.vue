<template>
    <div class="training-courses-section pb-30 pb-20-p">
        <div class="container">
            <div class="courses-container">
                <template v-if="filteredCourses.length">
                    <div class="courses-list d-flex flex-wrap p-side-12-p">
                        <CourseCard v-for="(course, index) in filteredCourses" :course="course" :key="index"></CourseCard>
                        <div class="course-box shadow w-31 radius-10 more main-bg w-100-p do" v-if="showMoreCard">
                            <router-link to="/all-courses" class="white-i font-23 h-100 d-block w-100">اكتشف المزيد</router-link>
                        </div>
                    </div>
                    <div class="mo p-side-12-p mt-10-p" v-if="showMoreCard">
                        <div class="shadow w-31 radius-10 more main-bg w-100-p">
                            <router-link to="/all-courses" class="btn center font-20 h-100 d-block w-100 next-arrow">اكتشف المزيد من الدورات</router-link>
                        </div>
                    </div>
                </template>
                <div v-else class="w-100 center">
                    <h2 class="font-32 main-color bold">لا يوجد كورسات في هذه الفئة</h2>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CourseCard from "./Course_Card.vue"
export default {
    props: ["filteredCourses","showMoreCard"],
    components: {CourseCard}
};
</script>

<style scoped>
.courses-list {
    column-gap: 39px;
    row-gap: 40px;
}
[tab-name="courses"] .courses-list {
    column-gap: 37px;
}
.course-box.more {
    position: relative;
    min-height: 324px;
}
.course-box.more::before {
    content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url(/images/more-courses.png);
    background-size: 100% 100%;
    mix-blend-mode: soft-light;
    position: absolute;
    pointer-events: none;
}
.course-box.more a {
    display: flex;
    align-items: end;
    padding:32px;
}
@media (max-width: 767px) {
    .courses-list {
        row-gap: 20px;
    }
    .homepage .courses-list {
        width: 100%;
        overflow-x: scroll!important;
        white-space: nowrap;
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 10px;
        column-gap: 20px;
    }
    .homepage .courses-list > *{
        min-width: 280px;
    }
    .course-box.more {
        min-height: 202px;
    }
    .course-box.more::before {
        background-image: url(/images/more-courses-mo.png); 
    }
    .course-box.more a {
        padding: 30px;
    }
}
</style>
