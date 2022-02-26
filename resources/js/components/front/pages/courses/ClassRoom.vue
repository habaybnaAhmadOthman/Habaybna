<template>
    <div class="video-page">
        <TheHeader></TheHeader>
        <Banner :videoSrc="trailerSrc"></Banner>
        <div class="container">
            <CourseInfoText :header="'لمحة عن الدرس'" :description="'في هذا الفيديو يتحدث المختص في العلاج الوظيفي عمر عن '"></CourseInfoText>
            <ContentTable class="pt-20"></ContentTable>
            <AboutSpecialists :specialistID="1"></AboutSpecialists>
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
<style scoped>
.page-footer {
    margin-top: 120px;
}
</style>