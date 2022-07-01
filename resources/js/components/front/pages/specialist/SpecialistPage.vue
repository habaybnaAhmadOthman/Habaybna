<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <div class="pt-50 pt-20-p">
                <h2 class="black-2 center font-23 font-27 mb-20-p mb-40 p-side-12-p yellow">الملف الشخصي</h2>
                <div class="bg-white m-side-12-p box shadow radius-10 p-side-30 p-side-12-p">
                    <div class="d-flex flex-wrap-p justify-center-p">
                        <figure class="rounded overflow-hidden shadow d-flex ml-30 avatar-box m-0-p bg-white">
                            <img class="object-fit" src="/images/big-logo.png" width="240" height="240" alt="" >
                        </figure>
                        <div class="pt-30 w-100-p center-p">
                            <h1 class="black-2 bold center-p font-20 font-30 mb-10">فريق التحرير</h1>
                            <h2 class="black-2 bold font-20 font-24 mb-10">منصة حبايبنا.نت</h2>
                        </div>
                    </div>

                    <div class="mt-50">
                        <TabsToggle :class="'gap-10 font-14-mo btn-bg-mo'" :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="book" all class="active">
                            <Book></Book>
                        </div>
                        <div tab-name="about" all>
                            <AboutSection></AboutSection>
                        </div>
                        <div tab-name="courses" all>
                            <SpecialistCourses :list-class="'p-0-p'" v-if="isDataReady" :filtered-courses="courses"></SpecialistCourses>
                        </div>
                        <div tab-name="articles" all>
                            <Articles :class-list="'p-0-p'" :list-only="true"></Articles>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <TheFooter></TheFooter>

        <!-- this modal open when the payment process complete (success,error) -->
        <info-modal
          :show="infoModal.show"
          :title="infoModal.title"
          @close="closeInfoModal"
          @afterClose="openQuestionaireModal"
          :description="infoModal.description"
          :success="infoModal.status"
          :fixed="infoModal.isFixed"
        >
        </info-modal>

        <!-- 
            quertionaire modal
            ** this modal show when the user came from the payment gateway 
            ** -- when success payment modal closed
         -->
        <QuestionaireModal 
            :show="querstionaireModal.show" 
            @close="isQuestionaireModal(false)"
        >
        </QuestionaireModal>
        <portal-target name="cobone-modal"></portal-target>
        <portal-target name="questionaire-modal"></portal-target>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
    import TabsToggle from '../../layouts/TabsToggle.vue'
    import SpecialistCourses from '../../views/onlinecourses/CoursesSection_Cards.vue'
    import Articles from '../../views/library/ContentSection.vue'
    import Book from '../../views/specialists/Book.vue'
    import QuestionaireModal from '../../views/specialists/QuestionaireModal.vue'
    import AboutSection from '../../views/specialists/AboutSection.vue'
    import TheFooter from '../../layouts/TheFooter.vue'
    import infoModalMixin from '../../mixins/infoModal'
    export default {
        mixins: [infoModalMixin],
        components: { TheHeader,TabsToggle,SpecialistCourses,Articles,Book,AboutSection,QuestionaireModal,TheFooter},
        data(){
            return {
                tabs: [
                    {
                        title: 'المواعيد<br class="mo"> المتاحة' ,
                        name: 'book',
                        active: true
                    },
                    {
                        title: 'نبذة<br class="mo"> تعريفية' ,
                        name: 'about',
                        active: false
                    },
                    {
                        title: 'الدورات <br class="mo">التدريبية' ,
                        name: 'courses',
                        active: false
                    },
                    {
                        title: 'الفيديوهات <br class="mo">والمقالات' ,
                        name: 'articles',
                        active: false
                    },
                ],
                courses: [],
                isDataReady: false,
                querstionaireModal: {
                    show:false
                }
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters["user/isLoggedIn"];
            }
        },
        methods: {
            async getCourses() {
                const allCourses = await this.$store.getters['courses/courses']
                if ( allCourses.length > 0 ) {
                    this.courses = allCourses
                } else {
                    this.courses = await this.$store.dispatch('courses/getAllCourses');
                }
                this.isDataReady = true
            },
            getActiveTab(){
                let activeTab = localStorage.getItem('active_tab')
                if (activeTab) {
                    this.tabs.map((tab)=>{
                        if (tab.name == activeTab) {
                            tab.active = true
                        } else
                            tab.active = false
                    })
                    this.toggletab(activeTab)
                    localStorage.removeItem('active_tab');
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
            isFromPaymentPage(){
                if (this.$route.query.payment) {
                    if (this.$route.query.payment == 'true') {
                        this.infoModal.isFixed = true;
                        this.setInfoModal('تم إرسال رابط المكالمة الى بريدك الإلكتروني','لقد أتممت عملية الشراء بنجاح' ,true,false,true)
                    } else {
                        this.setInfoModal('حصل خطأ في عملية الشراء','يرجى التأكد من المعلومات والمحاولة مرة أخرى' ,false,false,true)
                    }
                }
            },
            openQuestionaireModal(){
                if (this.$route.query.payment == 'true') {
                    this.isQuestionaireModal(true)
                }
            },
            isQuestionaireModal(status){
                this.querstionaireModal.show = status
            }
        },
        async mounted(){
            this.getActiveTab();
            await this.getCourses();
            this.isFromPaymentPage()
        },
        beforeRouteEnter(to, from, next) {
            if (from.params.course)
                localStorage.setItem('active_tab','courses')
            next((vm) => {
                vm.prevRoute = from;
            });
        },
    }
</script>

<style scoped>
.avatar-box {
    margin-top: -60px;
}
.box {
    margin-top: 100px;
}

@media (max-width: 767px) {
    .avatar-box img{
        width: 150px;
        height: 150px;
    }
}
</style>