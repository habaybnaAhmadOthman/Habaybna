<template>
    <div class="course-page">
        <TheHeader></TheHeader>
    <CommunityBar></CommunityBar>


        <Banner
        @open-share-modal="showShareDialog"
        :videoSrc="trailerSrc" :videosCount="videosCount" :courseLength="courseLength" :banner-title="courseName"
        ></Banner>
        <div class="container page-info">
            <div class="mo p-side-12-p mt-40">
                <TabsToggle :tabs="mobileTabs"></TabsToggle>
            </div>
            <div tab-name="about" mo >
                <CourseInfo  :course-name="courseName" :description="courseDescription" :whatShouldLearn="whatShouldLearn"></CourseInfo>
            </div>
            <div tab-name="table" mo class="active">
                <ContentTable  :rows="videosList" type="course" :title="'محتوى الدورة التدريبية'" class="pt-20"></ContentTable>
            </div>
            <div tab-name="coaches" mo class="mt-50 pt-10 mt-20-p pt-0-p">
                <AboutSpecialists :title="'عن المدربين'" v-if="specialists" :specialists="specialists"></AboutSpecialists>
            </div>
            <div class="mt-60">
                <RelatedCourses :title="`دورة ذات صلة`" v-if="isDataReady"></RelatedCourses>
            </div>
            <div class="mt-60" v-if="isDataReady && relatedArticles.length > 0">
                <RelatedContent :data="relatedArticles"></RelatedContent>
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
            :description="courseDescription | stripHTML"
            portal="course-share"
        ></ShareCourseModal>
        <!-- <ShareCourseModal
            :show="showShareModal"
            @close-share-modal="showShareDialog"
            :courseName="courseName"
            :description="courseDescription | stripHTML"
            :hashTags="'hashTags'"
            :quote="'quote'"
            :twitterUser="'twitterUser'"
        ></ShareCourseModal> -->

        <!-- showed when user came from payment gateway -->
        <info-modal
          :show="infoModal.show"
          :title="infoModal.title"
          @close="closeInfoModal"
          :description="infoModal.description"
          :success="infoModal.status"
          :fixed="infoModal.isFixed"
        >
        <button v-if="infoModal.isFixed" @click="goToClassRoom" class="btn">مشاهدة</button>
        </info-modal>

        <TheFooter></TheFooter>
        <portal-target name="cobone-modal"></portal-target>
        <portal-target name="cobone-card"></portal-target>
        <portal-target name="course-share"></portal-target>
    </div>
</template>

<script>
import Banner from "../../views/coursepage/Banner.vue";
import CommunityBar from "../../layouts/habaybnacommunity/CommunityBar.vue";

import CourseInfo from "../../views/coursepage/CourseInfo.vue";
import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
import ContentTable from "../../views/coursepage/ContentTable.vue";
import RelatedCourses from "../../views/coursepage/RelatedCourses.vue";
import CoursesFeatures from '../../views/onlinecourses/CoursesFeatures.vue'
import ShareCourseModal from '../../views/coursepage/ShareCourseModal.vue'
import RelatedContent from '../../views/library/RelatedContent.vue'
import CombaniesBanner from '../../layouts/CompaniesBanner.vue'
import TheFooter from '../../layouts/TheFooter.vue'
import TheHeader from '../../layouts/header/TheHeader.vue'
import TabsToggle from '../../layouts/TabsToggle.vue'
import infoModalMixin from '../../mixins/infoModal'
import { vueVimeoPlayer } from 'vue-vimeo-player'
export default {
    props: ['course'],
    mixins: [infoModalMixin],
    components: {
        CourseInfo,ContentTable,Banner,AboutSpecialists,RelatedContent,RelatedCourses,CombaniesBanner,CoursesFeatures,TheFooter,TheHeader,
        ShareCourseModal,TabsToggle,CommunityBar,
        vueVimeoPlayer
    },
    data() {
        return {
            trailerSrc: null,
            categories: [],
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
            relatedArticles: [],
            isPurchased: false,
            mobileTabs: [
                {
                    title: 'عن الدورة' ,
                    name: 'about',
                    active: false
                },
                {
                    title: 'الحلقات' ,
                    name: 'table',
                    active: true
                },
                {
                    title: 'المدربين' ,
                    name: 'coaches',
                    active: false
                },
            ]
        }
    },
    created() {
        this.getCourseDetails()
    },
    mounted(){
        this.getActiveTabOnMobile()
    },
    computed: {
        isLoggedIn(){
            return this.$store.getters["user/isLoggedIn"];
        }
    },
    methods: {
        getActiveTabOnMobile(){
            if (!this.isLoggedIn) {
                let activeTab = 'about'
                this.mobileTabs.map((tab)=>{
                    if (tab.name == activeTab) {
                        tab.active = true
                    } else
                        tab.active = false
                })
                this.toggletab(activeTab)
            }

        },
        toggletab(tabName) {
            document.querySelector(".tabs-toggle .active").classList.remove("active");
            document.querySelector(".tabs-toggle [tab-toggle='"+tabName+"']").classList.add("active");
            document.querySelectorAll("[tab-name]").forEach((tab)=>{
                tab.classList.remove('active')
            });
            document.querySelectorAll("[tab-name='"+ tabName +"']").forEach((tab)=>{
                tab.classList.add('active')
            });
        },
        async getCourseDetails(){
            try {
                this.isFromPaymentPage()
                let data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                if (!data && this.isLoggedIn) {
                    data = await this.$store.dispatch('courses/getCourseDetails',this.course);
                }
                data.categories.map((c)=>this.categories.push(c.id));
                this.courseID = data.id;
                this.trailerSrc = data.promo_video;
                this.coverPhoto = data.cover_photo;
                this.courseName = data.title;
                this.courseLength = data.course_length
                this.specialists  = data.providers;
                this.courseDescription  = data.description;
                this.whatShouldLearn  = data.what_should_learn;
                this.videosList  = data.videos_title_length;
                this.videosCount  = data.videos_count;

                this.isDataReady = true;
                // show related courses section
                const resp = (await this.$store.dispatch(`content/getContent`,{page:1,filters: this.categories})).data
                resp.map(related=>{
                    this.relatedArticles.push ({
                        id: related.id,
                        title: related.title,
                        created_at: related.created_at,
                        cover_photo: related.cover_photo,
                        without_like:true
                    })
                })

            } catch (e){
                console.log(e);
            }
        },
        showShareDialog() {
            this.showShareModal = !this.showShareModal;
        },
        async isFromPaymentPage(){
            if (this.$route.query.payment) {
                if (this.$route.query.payment == 'true') {
                    this.infoModal.isFixed = true;
                    await this.$store.dispatch('courses/getAllCourses')
                    this.setInfoModal('يمكنك الآن مشاهدة الدورة','لقد أتممت عملية الشراء بنجاح' ,true,true,true)
                    this.showWatchCourseDialog()
                } else {
                    await this.setInfoModal('حصل خطأ في عملية الشراء','يرجى التأكد من المعلومات والمحاولة مرة أخرى' ,false,false,true)
                }
            }
        },
        async goToClassRoom(){
            const courseLectures = await this.$store.dispatch('courses/getCourseLectures',{
                courseID: this.courseID
            })
            this.$router.replace(`/courses/${this.courseName.split(' ').join('-')}/${courseLectures[0].title.split(' ').join('-')}`)
        },
        showWatchCourseDialog(){
            this.infoModal.show = true
        },

    },
    metaInfo() {
        return {
            title: `${this.courseName}`,
            meta: [
                { property: 'og:title', content: this.courseName},
                { name: 'description', content:  this.courseDescription},
                { property: 'og:description', content: this.courseDescription},
                // {property: 'twitter:image:src', content: this.coverPhoto},
                {property: 'twitter:card', content: 'summary'},
                {property: 'og:url', content: 'https://habaybna.net/'},
                // {property: 'og:image', content: this.coverPhoto }
            ]
        }
    }
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
