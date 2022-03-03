<template>
    <div class="course-page">
        <TheHeader></TheHeader>
        <Banner :videoSrc="trailerSrc" :videosCount="videosCount" :courseLength="courseLength" :banner-title="courseName"></Banner>
        <div class="container page-info">
            <CourseInfo :course-name="courseName" :description="courseDescription" :whatShouldLearn="whatShouldLearn"></CourseInfo>
            
            <ContentTable :rows="videosList" type="course" :title="'محتوى الدورة التدريبية'" :lectures="lectures" class="pt-20"></ContentTable>

            <AboutSpecialists v-if="specialists" :specialists="specialists"></AboutSpecialists>
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
import TheHeader from '../../layouts/header/TheHeader.vue'
export default {
    components: { 
        CourseInfo,ContentTable,Banner,AboutSpecialists,RelatedCourses,CombaniesBanner,CoursesFeatures,TheFooter,TheHeader
    },
    props: ['course'],
    data() {
        return {
            trailerSrc: null,
            courseName: '',
            specialists: '',
            courseDescription: '',
            whatShouldLearn: '',
            courseLength: null,
            videosCount: null,
            videosList: null,
            lectures: []
        }
    },
    created(){
        this.getCourseDetails()
    },
    methods: {
        async getCourseDetails(){
            try {
                let data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                if (!data) { 
                    await this.$store.dispatch('courses/getAllCourses');
                    data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                }
                console.log(data);
                this.$store.commit('courses/setCourse',data);
                
                this.trailerSrc = data.promo_video;
                this.courseName = data.title;
                this.courseLength = +data.course_length.split(':')[0]
                this.specialists  = data.providers;
                this.courseDescription  = data.description;
                this.whatShouldLearn  = data.what_should_learn;
                this.videosList  = data.videos_title_length;
                this.videosCount  = data.videos_count;
            } catch (e){
                console.log(e);
            }
        },
    }
};
</script>
<style scoped>

</style>