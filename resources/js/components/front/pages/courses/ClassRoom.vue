<template>
    <div class="video-page">
        <TheHeader></TheHeader>
        <Banner :courseLength="videoLength" :lectureNumber="lectureNumber" :bannerTitle="lectureName" :videoSrc="lectureSrc" :is-lecture="true"></Banner>
        <div class="container">
            <div class="under-banner">
                <CourseInfoText v-if="isDataReady" :header="'لمحة عن الدرس'" :description="description"></CourseInfoText>
                <ContentTable v-if="isDataReady" :currentVideo="currentLecture" :rows="videosList" type="lecture" :title="'محتوى الدورة التدريبية'" class="pt-20"></ContentTable>
                <AboutSpecialists v-if="specialists" :specialists="specialists"></AboutSpecialists>
            </div>
        </div>
        <div class="page-footer">
            <TheFooter></TheFooter>
        </div>
        
    </div>
</template>

<script>
import Banner from "../../views/coursepage/Banner.vue";
import CourseInfoText from "../../views/coursepage/CourseInfoText.vue";
import ContentTable from "../../views/coursepage/ContentTable.vue";
import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";

import TheFooter from '../../layouts/TheFooter.vue'
import TheHeader from '../../layouts/header/TheHeader.vue'
export default {
    components: { Banner,AboutSpecialists,CourseInfoText,ContentTable,TheFooter,TheHeader},
    props: ['course','lesson'],
    data() {
        return {
            lectureSrc: null,
            lectureName: '',
            description: '',
            videoLength: '',
            videosList: null,
            isDataReady: false,
            lectureNumber: '',
            specialists: '',
            currentLecture: null
        }
    },
    created(){
        this.getCourseDetails()
    },
    methods: {
        async getCourseDetails(){
            try {
                let courseLectures = await this.$store.getters['courses/courseLectures'];
                let courseData = await this.$store.getters['courses/course'];
                // check course info
                if (!courseData) {
                    courseData = await this.$store.dispatch('courses/getCourseDetails',this.course);
                }
                // check lectures
                if (courseLectures.length == 0) {
                    courseLectures = await this.$store.dispatch('courses/getCourseLectures',{courseID:courseData.id});
                }
                let {lectureData,lectureIndex}  = this.getLectureDetails(courseLectures)
                if ( lectureData) {
                    this.lectureNumber = lectureIndex + 1
                    lectureData.index = lectureIndex
                }
                this.$store.commit('courses/currentLecture',lectureData)
                this.currentLecture = lectureData

                this.lectureSrc = lectureData.url;
                this.lectureName = lectureData.title;
                this.description = lectureData.description;
                this.videoLength = lectureData.length;
                
                this.specialists  = courseData.providers;
                this.videosList  = courseLectures;
                this.isDataReady = true;
            } catch (e){
                console.log(e);
            }
        },
        getLectureNumber(arr){
            const lessonName = this.lesson.split('-').join(' ');
            return arr.findIndex(x=> x.title == lessonName)
        },
        getLectureDetails(allLectures) {
            const lectureIndex =  this.getLectureNumber(allLectures);
            const lectureData = allLectures[lectureIndex];
            return {lectureData,lectureIndex}
        }
    }
};
</script>
<style scoped>
.page-footer {
    margin-top: 120px;
}
.under-banner {
    margin-top: 150px;
}
</style>