<template>
    <div class="training-courses-section pb-30">
        <div class="p-side-15">
            <div class="courses-container">
                <template v-if="filteredCourses.length">
                    <div class="courses-list d-flex flex-wrap">
                        <CourseCard v-for="(course, index) in filteredCourses" :course="course" :key="index"></CourseCard>
                    </div>
                </template>
                <div v-else class="w-100 center">
                    <h2 class="font-32 main-color bold">لا يوجد كورسات</h2>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CourseCard from "./CourseCard.vue"
export default {
    props: ["filteredCourses","showMoreCard"],
    components: {CourseCard}
};
</script>

<style scoped>
.courses-list {
    column-gap: 40px;
    row-gap: 40px;
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

@media (max-width: 767px) {
    .courses-list {
        row-gap: 20px;
    }
}
</style>
