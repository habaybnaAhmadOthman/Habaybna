<template>
    <div class="course-page mt-50 pb-100">
        <Banner></Banner>
        <div class="container">
            <div class="d-flex structure flex-wrap space-between">
                <CourseInfo></CourseInfo>
                <CourseDetails></CourseDetails>
                <AboutCoach></AboutCoach>
            </div>
        </div>
        <ContactUs></ContactUs>
        <Reviews></Reviews>
    </div>
</template>

<script>
// import LandingSection from "../views/homepage/LandingSection.vue";
// import HabaybnaLibrary from "../views/homepage/HabaybnaLibrary.vue";
// import HabaybnaDirectory from "../views/homepage/HabaybnaDirectory.vue";
import Banner from "../views/coursepage/Banner.vue";
import CourseInfo from "../views/coursepage/CourseInfo.vue";
import CourseDetails from "../views/coursepage/CourseDetails.vue";
import AboutCoach from "../views/coursepage/AboutCoach.vue";
import ContactUs from "../views/coursepage/ContactUs.vue";
import Reviews from "../views/coursepage/Reviews.vue";
export default {
    components: { CourseInfo,Banner,CourseDetails,AboutCoach,ContactUs,Reviews}
};
</script>
