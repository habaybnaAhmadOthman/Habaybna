<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <div class="pt-50 pt-20-p">
                <h2 class="black-2 center font-23 font-27 mb-20-p mb-40 p-side-12-p yellow">الملف الشخصي</h2>
                <div class="bg-white m-side-12-p box shadow radius-10 p-side-30 p-side-12-p">
                    <div class="d-flex flex-wrap-p justify-center-p">
                        <figure class="rounded overflow-hidden shadow d-flex ml-30 avatar-box m-0-p bg-white">
                            <img class="object-fit" :src="specialistInfo.avatar | defaultAvatar" width="240" height="240" alt="" >
                        </figure>
                        <div class="pt-30 w-100-p center-p">
                            <h1 class="black-2 bold center-p font-20 font-30 mb-10">{{specialistName}}</h1>
                            <h2 class="black-2 bold font-20 font-24 mb-10">{{specialistInfo.specialization}}</h2>
                            <p class="align-center bold d-flex font-14-p font-20 pointer yellow mt-15" @click="showShareDialog"><img class="ml-10 share-img" src="/images/share-color.svg" width="34" height="36" alt="" > مشاركة</p>
                        </div>
                    </div>

                    <div class="mt-50">
                        <TabsToggle :class="'gap-10 font-14-mo btn-bg-mo'" :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="book" all class="active">
                            <Book v-if="isDataReady" :specialistData="specialistInfo" :data="appointments"></Book>
                        </div>
                        <div tab-name="about" all class="active">
                            <div class="font-24 black-2 font-18-p">{{specialistInfo.bio}}</div>
                        </div>
                        <div tab-name="courses" all >
                            <div class="grid-3 gap2 grid-1-p" v-if="isDataReady && courses.length > 0">
                                <CourseCard :class="'w-100-i'" v-for="(course, index) in courses" :course="course" :key="index"></CourseCard>
                            </div>
                            <p class="font-24 black-2 font-18-p" v-else>لا يوجد دورات</p>
                        </div>
                        <div tab-name="articles" all>
                            <div v-if="isDataReady && articles.length > 0" class="grid-2 gap2 grid-1-p">
                                <SmallCard v-for="(item) in articles" :key="item.id" :item="item"></SmallCard>
                            </div>
                            <p class="font-24 black-2 font-18-p" v-else>لا يوجد مقالات</p>
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
        <ShareModal
            :show="showShareModal"
            @close-share-modal="showShareDialog"
            :courseName="specialistName"
            :description="specialistName | stripHTML"
            portal="specialist-share"
        ></ShareModal>
        <portal-target name="specialist-share"></portal-target>
        <portal-target name="cobone-modal"></portal-target>
        <portal-target name="questionaire-modal"></portal-target>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
    import TabsToggle from '../../layouts/TabsToggle.vue'
    import Book from '../../views/specialists/Book.vue'
    import QuestionaireModal from '../../views/specialists/QuestionaireModal.vue'
    // import AboutSection from '../../views/specialists/AboutSection.vue'
    import TheFooter from '../../layouts/TheFooter.vue'
    import infoModalMixin from '../../mixins/infoModal'

    import SmallCard from '../../layouts/SmallCard.vue'
    import CourseCard from '../../views/onlinecourses/Course_Card.vue'
    import ShareModal from '../../views/coursepage/ShareCourseModal.vue'

    export default {
        props: ['specialist'],
        mixins: [infoModalMixin],
        components: { TheHeader,SmallCard,CourseCard,ShareModal,TabsToggle,Book,QuestionaireModal,TheFooter},
        data(){
            return {

                appointments:[],
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
                articles: [],
                isDataReady: false,
                specialistInfo: {
                    firstName: '',
                    lastName: '',
                    specialization: '',
                    bio: '',
                    avatar: ''
                },
                isDataReady: false,
                querstionaireModal: {
                    show:false
                },
                showShareModal: false,
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters["user/isLoggedIn"];
            },
            specialistName(){
                return this.specialistInfo.firstName + ' ' + this.specialistInfo.lastName
            },
        },
        methods: {
            isLoading(status) {
                this.$store.commit('isLoading',status)
            },
            showShareDialog() {
                this.showShareModal = !this.showShareModal;
            },
            async getSpecialistData() {
                this.isLoading(true)
                try {
                    const data = await this.$store.dispatch(`specialist/getSpecialistDetails`,this.specialist);
                   
                    if (data.specialist.courses && data.specialist.courses.length > 0) {
                        this.courses = data.specialist.courses.map((item)=>{
                            const obj = item.course
                            const course = {
                                is_favourite:obj.is_favourite,
                                title: obj.courseTitle,
                                course_length: obj.course_length,
                                id: obj.id,
                                is_free: obj.is_free,
                                cover_photo: obj.cover_photo,
                                is_liked: obj.is_liked,
                                price: obj.price
                            }
                            if (+obj.discount && +obj.discount > 0) {
                                course.discount = {
                                    has_discount: true,
                                    discount_value: obj.discount+ '%',
                                    discount_price: obj.price - (obj.price * (obj.discount/100))
                                }
                            } else {
                                course.discount = {
                                    has_discount: false,
                                    discount_value: 0,
                                    discount_price: null
                                }
                            }
                            return course
                        })
    
                    }
                    if (data.specialist.articles && data.specialist.articles.length > 0) {
                        this.articles = data.specialist.articles.map((article)=>{
                            return {
                                ...article,
                                without_like:true
                            }
                        });
                    }
                    if (this.articles.length > 0) {
                        const specialistData = this.articles[0].author
                        this.specialistInfo.firstName = specialistData.firstName
                        this.specialistInfo.lastName = specialistData.lastName
                        this.specialistInfo.specialization = specialistData.specialization
                        this.specialistInfo.avatar = specialistData.avatar
                        this.specialistInfo.bio = specialistData.disorders_work_with
                        this.specialistInfo.id = specialistData.user_id                        
                    }
                    // appointments
                    if (data.specialist.appintment && Object.keys(data.specialist.appintment).length > 0) {
                        const appt = []
                        for (const i in data.specialist.appintment ) {
                            appt.push(data.specialist.appintment[i])
                        }
                        this.appointments = appt
                    } 
                } catch (err) {
                    console.log(err)
                }
                
                this.isLoading(false)
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
            },
            
        },
        async mounted(){
            this.getActiveTab();
            await this.getSpecialistData();
            this.isFromPaymentPage()
        },
        beforeRouteEnter(to, from, next) {
            if (from.params.course)
                localStorage.setItem('active_tab','courses')
            next((vm) => {
                vm.prevRoute = from;
            });
        },
        filters: {
            defaultAvatar: function (avatar) {
                if (avatar == 'default.jpg') return '/images/avatars/default.jpg'
                return avatar
            }
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