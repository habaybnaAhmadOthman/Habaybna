<template>
    <div class="training-courses-section pb-30 pb-20-p">
        <div class="container">
            <div class="courses-container">
                <template v-if="filteredCourses.length">
                    <div class="courses-list d-flex flex-wrap">
                        <CourseCard v-for="(course, index) in filteredCourses" :course="course" :key="index"></CourseCard>
                        <div class="course-box shadow w-31 radius-10 more main-bg w-100-p" v-if="showMoreCard">
                            <router-link to="/all-courses" class="white-i font-23 h-100 d-block w-100">اكتشف المزيد</router-link>
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
