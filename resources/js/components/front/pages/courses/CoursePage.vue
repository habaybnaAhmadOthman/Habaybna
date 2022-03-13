<template>
    <div class="course-page">
        <TheHeader></TheHeader>
        <Banner 
        @open-share-modal="showShareDialog"
        :videoSrc="trailerSrc" :videosCount="videosCount" :courseLength="courseLength" :banner-title="courseName"
        @user-bought-course="showWatchCourseDialog"
        ></Banner>
        <div class="container page-info">
            <CourseInfo :course-name="courseName" :description="courseDescription" :whatShouldLearn="whatShouldLearn"></CourseInfo>
            
            <ContentTable :rows="videosList" type="course" :title="'محتوى الدورة التدريبية'" :lectures="lectures" class="pt-20"></ContentTable>

            <AboutSpecialists v-if="specialists" :specialists="specialists"></AboutSpecialists>
            <div class="mt-60">
                <RelatedCourses v-if="isDataReady"></RelatedCourses>
            </div>
        </div>
        <div class="mt-30">
            <CombaniesBanner></CombaniesBanner>
        </div>
        <CoursesFeatures></CoursesFeatures>

        <ShareCourseModal
            :show="showShareModal"
            @close-share-modal="showShareDialog"
            :courseName="courseName"
            :description="courseDescription"
            :hashTags="'hashTags'"
            :quote="'quote'"
            :twitterUser="'twitterUser'"
        ></ShareCourseModal>
        <!-- showed when user came from payment gateway -->
        <info-modal
          :show="infoModal.show"
          :title="infoModal.title"
          @close="closeInfoModal"
          :description="infoModal.description"
          :success="infoModal.status"
          :fixed="infoModal.isFixed"
        >
        <button @click="goToClassRoom" class="btn">مشاهدة</button>
        </info-modal>

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
import ShareCourseModal from '../../views/coursepage/ShareCourseModal.vue'

import CombaniesBanner from '../../layouts/CompaniesBanner.vue'
import TheFooter from '../../layouts/TheFooter.vue'
import TheHeader from '../../layouts/header/TheHeader.vue'
import infoModalMixin from '../../mixins/infoModal'
export default {
    props: ['course'],
    mixins: [infoModalMixin],
    components: { 
        CourseInfo,ContentTable,Banner,AboutSpecialists,RelatedCourses,CombaniesBanner,CoursesFeatures,TheFooter,TheHeader,
        ShareCourseModal
    },
    data() {
        return {
            trailerSrc: null,
            courseName: '',
            specialists: '',
            courseDescription: '',
            coverPhoto: '',
            whatShouldLearn: '',
            courseLength: null,
            videosCount: null,
            videosList: null,
            lectures: [],
            showShareModal: false,
            isDataReady: false,
            
        }
    },
    created() {
        this.getCourseDetails()
    },
    methods: {
        async getCourseDetails(){
            try {
                this.isFromPaymentPage()
                let data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                if (!data) { 
                    await this.$store.dispatch('courses/getAllCourses');
                    data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                }
                
                this.$store.commit('courses/setCourse',data);
                this.courseID = data.id;
                this.trailerSrc = data.promo_video;
                this.coverPhoto = data.cover_photo;
                this.courseName = data.title;
                this.courseLength = +data.course_length.split(':')[0]
                this.specialists  = data.providers;
                this.courseDescription  = data.description;
                this.whatShouldLearn  = data.what_should_learn;
                this.videosList  = data.videos_title_length;
                this.videosCount  = data.videos_count;

                // show related courses section
                this.isDataReady = true;
                
            } catch (e){
                console.log(e);
            }
        },
        showShareDialog() {
            this.showShareModal = !this.showShareModal;
        },
        isFromPaymentPage(){
            if (this.$route.query.payment) {
                if (this.$route.query.payment == 'true') {
                    this.infoModal.isFixed = true;
                } else {
                    this.setInfoModal('حصل خطأ في عملية الشراء','يرجى التأكد من المعلومات والمحاولة مرة أخرى' ,false,false)
                }
                this.showWatchCourseDialog()
            }
        },
        goToClassRoom(){
            this.$store.dispatch('courses/getCourseLectures',{
                courseID: this.courseID
            })
        },
        showWatchCourseDialog(){
            this.infoModal.show = true
        },

    },
    metaInfo() {
        return {
            title: `${this.courseName}`,
            meta: [
                // { name: 'description', content: 'Connect and follow ' + this.userData.name + ' on Epiloge - ' + this.userData.tagline},
                // { property: 'og:title', content: this.userData.name + ' - Epiloge'},
                // { property: 'og:site_name', content: 'Epiloge'},
                // { property: 'og:description', content: 'Connect and follow ' + this.userData.name + ' on Epiloge - ' + this.userData.tagline},
                // {property: 'og:type', content: 'profile'},
                // {property: 'og:url', content: 'https://epiloge.com/@' + this.userData.username},
                {property: 'og:image', content: this.coverPhoto }
            ]
        }
    },
};
</script>
<style scoped>
.btn {
    width: 340px;
    font-size: 18px;
    font-weight: bold;
    height: 60px;
    border-radius: 25px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>