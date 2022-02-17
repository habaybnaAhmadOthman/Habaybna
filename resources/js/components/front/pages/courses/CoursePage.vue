<template>
    <div class="course-page mt-50 pb-100">
        <Banner :videoSrc="trailerSrc" :is-full="false"></Banner>
        <div class="container page-info">
            <CourseInfo :course-name="courseName" :specialist-name="specialistName" description="courseDescription" :lectures="lectures"></CourseInfo>
            
            <ContentTable class="pt-20"></ContentTable>

            <AboutSpecialists :specialistID="1"></AboutSpecialists>

            <RelatedCourses></RelatedCourses>

        </div>


        <div class="container">
            <div class="d-flex structure flex-wrap space-between">
                <div class="w-68">
                    <ContactUs></ContactUs>
                    <Reviews></Reviews>
                </div>
                <CourseDetails></CourseDetails>
            </div>
        </div>
        
    </div>
</template>

<script>
import Banner from "../../views/coursepage/Banner.vue";
import CourseInfo from "../../views/coursepage/CourseInfo.vue";
import CourseDetails from "../../views/coursepage/CourseDetails.vue";
import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
import ContactUs from "../../views/coursepage/ContactUs.vue";
import ContentTable from "../../views/coursepage/ContentTable.vue";
import RelatedCourses from "../../views/coursepage/RelatedCourses.vue";
import Reviews from "../../views/coursepage/Reviews.vue";
export default {
    components: { CourseInfo,ContentTable,Banner,CourseDetails,AboutSpecialists,ContactUs,Reviews,RelatedCourses},
    props: ['course'],
    data() {
        return {
            trailerSrc: null,
            courseName: '',
            specialistName: '',
            courseDescription: '',
            lectures: [],
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
.page-info {
    margin-top: 150px;
}
</style>