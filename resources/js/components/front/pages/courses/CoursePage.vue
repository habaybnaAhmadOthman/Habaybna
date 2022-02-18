<template>
    <div class="course-page">
         <button id="show-modal" @click="loginModal = true">Show Modal</button>
         
        <Banner :videoSrc="trailerSrc" :is-full="false"></Banner>
        <div class="container page-info">
            <CourseInfo :course-name="courseName" :specialist-name="specialistName" description="courseDescription" :lectures="lectures"></CourseInfo>
            
            <ContentTable class="pt-20"></ContentTable>

            <AboutSpecialists :specialistID="1"></AboutSpecialists>
            <div class="mt-60">
                <RelatedCourses></RelatedCourses>
            </div>
        </div>
        <div class="mt-30">
            <CombaniesBanner></CombaniesBanner>
        </div>
        <CoursesFeatures></CoursesFeatures>

        <TheFooter></TheFooter>
        
    </div>
</template>

<script>
import Banner from "../../views/coursepage/Banner.vue";
import CourseInfo from "../../views/coursepage/CourseInfo.vue";
import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
import ContentTable from "../../views/coursepage/ContentTable.vue";
import RelatedCourses from "../../views/coursepage/RelatedCourses.vue";
import CoursesFeatures from '../../views/onlinecourses/CoursesFeatures.vue'


import CombaniesBanner from '../../layouts/CompaniesBanner.vue'
import TheFooter from '../../layouts/TheFooter.vue'
export default {
    components: { 
        CourseInfo,ContentTable,Banner,AboutSpecialists,RelatedCourses,CombaniesBanner,CoursesFeatures,TheFooter
    },
    props: ['course'],
    data() {
        return {
            trailerSrc: null,
            courseName: '',
            specialistName: '',
            courseDescription: '',
            lectures: []
        }
    },
    created(){
        this.getCourseDetails()
    },
    methods: {
        async getCourseDetails(){
            try {
                const data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                this.trailerSrc = data.trailerSrc;
                this.courseName = data.courseName;
                this.specialistName  = data.specialistName;
                this.courseDescription  = data.courseDescription;
                this.lectures   = data.lectures;
            } catch (e){
                console.log(e);
            }
        },
    }
};
</script>
<style scoped>

</style>