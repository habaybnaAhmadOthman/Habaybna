<template>
    <div class="course-page mt-50 pb-100">
        <Banner :videoSrc="trailerSrc"></Banner>
        <div class="container">
            <div class="d-flex structure flex-wrap space-between">
                <CourseProgress></CourseProgress>
                <CourseInfo :course-name="courseName" :specialist-name="specialistName" :documents="documents" description="description" :lectures="lectures"></CourseInfo>
                <VideoDescription :lectureInfo="lectureInfo"></VideoDescription>
                <AboutSpecialist :specialistID="1"></AboutSpecialist>
            </div>
        </div>
        <ContactUs></ContactUs>
    </div>
</template>

<script>
import Banner from "../../views/coursepage/Banner.vue";
import CourseProgress from "../../views/coursepage/CourseVideo_Progress.vue";
import VideoDescription from "../../views/coursepage/VideoDescription.vue";
import CourseInfo from "../../views/coursepage/CourseInfo.vue";
import CourseDetails from "../../views/coursepage/CourseDetails.vue";
import AboutSpecialist from "../../views/coursepage/AboutSpecialist.vue";
import ContactUs from "../../views/coursepage/ContactUs.vue";
import Reviews from "../../views/coursepage/Reviews.vue";
export default {
    components: { CourseInfo,Banner,CourseDetails,AboutSpecialist,ContactUs,Reviews,CourseProgress,VideoDescription},
    props: ['course'],
    data() {
        return {
            trailerSrc: null,
            courseName: '',
            specialistName: '',
            courseDescription: '',
            lectureInfo: '',
            documents: [],
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
                this.documents  = data.documents;
                this.lectures   = data.lectures;
                this.lectureInfo   = data.lectureInfo;
            } catch (e){
                console.log(e);
            }
        },
    }
};
</script>
