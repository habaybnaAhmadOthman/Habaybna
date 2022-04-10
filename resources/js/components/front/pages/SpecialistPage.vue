<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <div class="pt-50 pt-20-p">
                <h1 class="title-line mb-40 mb-20-p">مقدمي المحتوى</h1>
                <div class="bg-white box shadow radius-10 p-side-30">
                    <div class="d-flex">
                        <figure class="rounded overflow-hidden shadow d-flex ml-30 avatar-box">
                            <img class="object-fit" src="/images/test.jpg" width="240" height="240" alt="" >
                        </figure>
                        <div class="pt-30">
                            <h1 class="main-color font-30 bold mb-10">سعاد الدميري</h1>
                            <h2 class="yellow bold font-24 mb-10">اختصاصية علاج طبيعي</h2>
                            <h3 class="font-22">عمان - الأردن</h3>
                        </div>
                    </div>

                    <div class="mt-50">
                        <TabsToggle :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="about" all class="active">
                            <div class="font-24 black-2">اختصاصية العلاج الطبيعي في مجال الأطفال. التحقت بمعهد المهن الطبية المساعدة بعمان عام ١٩٨٦ وحصلت على الدبلوم ثم التحقت بالجامعة الأردنية كلية علوم التأهيل ودرست بكالوريس علاج طبيعي. وكان تقديرها إمتياز وأخذت خبرات عديدة من ألمانيا وأميركا والسعودية بالإضافة للأردن. تبقي نفسها مستجدة بالبحث عن المعلومة الجديدة</div>
                        </div>
                        <div tab-name="courses" all>
                            <SpecialistCourses v-if="isDataReady" :filtered-courses="courses"></SpecialistCourses>
                        </div>
                        <div tab-name="articles" all>
                            <Articles :list-only="true"></Articles>
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
</style>