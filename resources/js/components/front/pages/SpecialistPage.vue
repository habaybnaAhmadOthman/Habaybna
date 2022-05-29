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
                        <TabsToggle :class="'gap-10 font-14-mo btn-bg-mo'"  :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="about" all class="active">
                            <div class="font-24 black-2 font-18-p">منصة عربية تهدف لتقديم محتوى متخصص يهدف إلى تسهيل دمج الأشخاص ذوي التحديات الذهنية في المجتمع العربي.</div>
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
                        title: 'نبذة<br class="mo"> تعريفية' ,
                        name: 'about',
                        active: true
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