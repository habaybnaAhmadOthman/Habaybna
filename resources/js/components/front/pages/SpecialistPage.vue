<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <div class="pt-50 pt-20-p">
                <h2 class="black-2 center font-23 font-27 mb-20-p mb-40 p-side-12-p yellow">الملف الشخصي</h2>
                <div class="bg-white m-side-12-p box shadow radius-10 p-side-30 p-side-12-p">
                    <div class="d-flex flex-wrap-p justify-center-p">
                        <figure class="rounded overflow-hidden shadow d-flex ml-30 avatar-box m-0-p bg-white">
                            <img class="object-fit" :src="specialist.avatar | defaultAvatar" width="240" height="240" alt="" >
                        </figure>
                        <div class="pt-30 w-100-p center-p">
                            <h1 class="black-2 bold center-p font-20 font-30 mb-10">{{specialistName}}</h1>
                            <h2 class="black-2 bold font-20 font-24 mb-10">{{specialistInfo.specialization}}</h2>
                        </div>
                    </div>

                    <div class="mt-50">
                        <TabsToggle :class="'gap-10 font-14-mo btn-bg-mo'"  :tabs="tabs"></TabsToggle>
                    </div>
                    <div class="mt-40 pb-40">
                        <div tab-name="about" all class="active">
                            <div class="font-24 black-2 font-18-p">{{specialistInfo.bio}}</div>
                        </div>
                        <div tab-name="courses" all >
                            <div class="grid-3 gap2 grid-1-p" v-if="isDataReady">
                                <CourseCard :class="'w-100-i'" v-for="(course, index) in courses" :course="course" :key="index"></CourseCard>
                            </div>
                        </div>
                        <div tab-name="articles" all>
                            <div v-if="isDataReady" class="grid-2 gap2 grid-1-p">
                                <SmallCard v-for="(item) in articles" :key="item.id" :item="item"></SmallCard>
                            </div>
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
    import SmallCard from '../layouts/SmallCard.vue'
    import TabsToggle from '../layouts/TabsToggle.vue'
    import CourseCard from '../views/onlinecourses/Course_Card.vue'
    import Articles from '../views/library/ContentSection.vue'
    import TheFooter from '../layouts/TheFooter.vue'
    export default {
        props: ['specialist'],
        components: { TheHeader,TabsToggle,Articles,TheFooter,SmallCard,CourseCard},
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
                articles: [],
                isDataReady: false,
                specialistInfo: {
                    firstName: null,
                    lastName: null,
                    specialization: null,
                    bio: null,
                    avatar: null
                }

            }
        },
        computed: {
            specialistName(){
                return this.specialistInfo.firstName + ' ' + this.specialistInfo.lastName
            }
        },
        methods: {
            async getSpecialistData() {
                const data = await this.$store.dispatch(`specialist/getSpecialistDetails`,this.specialist);
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
                this.articles = data.specialist.articles.map((article)=>{
                    return {
                        ...article,
                        without_like:true
                    }
                });
                if (this.articles.length > 0) {
                    const specialistData = this.articles[0].author
                    this.specialistInfo.firstName = specialistData.firstName
                    this.specialistInfo.lastName = specialistData.lastName
                    this.specialistInfo.specialization = specialistData.specialization
                    this.specialistInfo.avatar = specialistData.avatar
                    this.specialistInfo.bio = specialistData.disorders_work_with
                }
                this.isDataReady = true
            }
        },
        filters: {
            defaultAvatar: function (avatar) {
                if (avatar == 'default.jpg') return '/images/avatars/default.jpg'
                return avatar
            }
        },
        async mounted() {
            await this.getSpecialistData();
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