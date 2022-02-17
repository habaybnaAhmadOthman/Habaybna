<template>
    <div class="related-courses-section">
        <h6 class="title-line font-27 mb-40">دورة ذات صلة</h6>
        <div class="list" v-if="appendedCourses.length > 0">
            <CourseCard v-for="(course, index) in appendedCourses" :course="course" :key="index"></CourseCard>
        </div>
    </div>
</template>

<script>
    import CourseCard from '../../views/onlinecourses/Course_Card.vue'
    export default {
        components:{CourseCard},
        data:()=>({
            appendedCourses: [],
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

<style scoped>

</style>