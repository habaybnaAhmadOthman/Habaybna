<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <div class="pt-50 pt-20-p">
                <h1 class="title-line mb-40 mb-20-p p-side-12-p">مقدمي المحتوى</h1>
                <div class="bg-white m-side-12-p box shadow radius-10 p-side-30 p-side-12-p">
                    <div class="d-flex flex-wrap-p justify-center-p">
                        <figure class="rounded overflow-hidden shadow d-flex ml-30 avatar-box m-0-p">
                            <img class="object-fit" src="/images/test.jpg" width="240" height="240" alt="" >
                        </figure>
                        <div class="pt-30 w-100-p center-p">
                            <h1 class="main-color center-p font-30 bold mb-10">سعاد الدميري</h1>
                            <h2 class="yellow bold font-24 mb-10">اختصاصية علاج طبيعي</h2>
                            <h3 class="font-22">عمان - الأردن</h3>
                        </div>
                    </div>

                    <div class="mt-50">
                        <TabsToggle :class="'swipe-box-p gap-10'"  :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="about" all class="active">
                            <div class="font-24 black-2 font-18-p">اختصاصية العلاج الطبيعي في مجال الأطفال. التحقت بمعهد المهن الطبية المساعدة بعمان عام ١٩٨٦ وحصلت على الدبلوم ثم التحقت بالجامعة الأردنية كلية علوم التأهيل ودرست بكالوريس علاج طبيعي. وكان تقديرها إمتياز وأخذت خبرات عديدة من ألمانيا وأميركا والسعودية بالإضافة للأردن. تبقي نفسها مستجدة بالبحث عن المعلومة الجديدة</div>
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
    </div>
</template>

<script>
    import TheHeader from '../layouts/header/TheHeader.vue'
    import TabsToggle from '../layouts/TabsToggle.vue'
    import SpecialistCourses from '../views/onlinecourses/CoursesSection_Cards.vue'
    import Articles from '../views/library/ContentSection.vue'
    import TheFooter from '../layouts/TheFooter.vue'
    export default {
        components: { TheHeader,TabsToggle,SpecialistCourses,Articles,TheFooter},
        data(){
            return {
                tabs: [
                    {
                        title: 'نبذة تعريفية' ,
                        name: 'about'
                    },
                    {
                        title: 'الدورات التدريبية' ,
                        name: 'courses'
                    },
                    {
                        title: 'الفيديوهات والمقالات' ,
                        name: 'articles'
                    },
                ],
                courses: [],
                isDataReady: false,
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
            }
        },
        mounted(){
            this.getCourses()
        }
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