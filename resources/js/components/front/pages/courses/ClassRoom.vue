<template>
    <div class="video-page">
        <TheHeader></TheHeader>
        <Banner :courseLength="videoLength" :lectureNumber="lectureNumber" :bannerTitle="lectureName" :videoSrc="lectureSrc" :is-lecture="true"></Banner>
        <div class="container">
            <div class="under-banner mt-0-p-i">
                <div class="mo p-side-12-p mt-20-p">
                    <TabsToggle :tabs="mobileTabs"></TabsToggle>
                </div>
                <div tab-name="about" mo class="active p-side-12-p">
                    <CourseInfoText v-if="isDataReady" :header="'لمحة عن الدرس'" :description="description"></CourseInfoText>
                </div>
                <div tab-name="table" mo>
                    <ContentTable v-if="isDataReady" :currentVideo="currentLecture" :rows="videosList" type="lecture" :title="'محتوى الدورة التدريبية'" class="pt-20"></ContentTable>
                </div>
                <div tab-name="coaches" mo class="mt-50 pt-10 mt-20-p pt-0-p">
                    <AboutSpecialists :title="'عن المدربين'" v-if="specialists" :specialists="specialists"></AboutSpecialists>
                </div>
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
import TabsToggle from '../../layouts/TabsToggle.vue'

import TheFooter from '../../layouts/TheFooter.vue'
import TheHeader from '../../layouts/header/TheHeader.vue'
export default {
    components: { Banner,AboutSpecialists,CourseInfoText,ContentTable,TheFooter,TheHeader,TabsToggle},
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
            currentLecture: null,
            mobileTabs: [
                {
                    title: 'عن الدورة' ,
                    name: 'about'
                },
                {
                    title: 'الدروس' ,
                    name: 'table'
                },
                {
                    title: 'المدربين' ,
                    name: 'coaches'
                },
            ]
        }
    },
    created(){
        this.getCourseDetails()
    },
    methods: {
        async getCourseDetails(){
            try {
                let courseData = await this.$store.dispatch('courses/getMyCourseData',this.course);
                const courseLectures = await this.$store.dispatch('courses/getCourseLectures',{
                    courseID: courseData.id
                })
                
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