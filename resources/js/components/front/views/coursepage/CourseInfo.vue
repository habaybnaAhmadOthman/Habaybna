<template>
    <div class="about-course">
        <CourseInfoText :header="'نظرة عامة على الدورة'" :description="description"></CourseInfoText>
        <div class="mb-40 what-should-learn">
            <h3 class="title-line font-27 mb-40">ماذا سيتعلم المشاركون</h3>
            <div class="font-27 black-2">
                <h3 class="mb-40">في هذا المساق سوف نتعلم:</h3>
                <div class="d-flex learn-points flex-wrap space-between">
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                    <p>المفاهيم والمصطلحات الأساسية</p>
                </div>
            </div>
        </div>
        
        <!-- <h1 class="title- font-30 main-color">{{courseName}}</h1>
        <h2 class="by main-color font-18 mb-10"><span> بواسطة الاخصائي :</span> <span class="bold">{{specialistName}}</span></h2>
        <p class="desc">{{description}}</p>

        <div class="attached-box mt-15" v-if="documents">
            <p class="font-18 main-color">المرفقات</p>
            <a v-for="(attach,index) in documents" :key="index" class="d-flex align-center gray" download :href="attach.link">
                <img class="ml-10" src="/images/siteImgs/header/logo.png" :alt="attach.title" width="20" height="27">
                {{attach.title}}
            </a>
        </div>

        <div class="course-lectures mt-20">
            <p class="main-color font-26 mb-10">محتوى الدورة التدريبية</p>
            <div class="box" show-more-less :class="{'active': showMore}">
                <div class="to-show" v-for="(lecture,index) in lectures" :key="index">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>{{lecture.title}}</p>
                        <p>{{lecture.time}} دقيقة</p>
                    </div>
                </div>
                <template v-if="lectures.length > 4">
                    <div more @click="showMoreLess" class="btn mt-15" ><span class="d-flex align-center justify-center">أظهر المزيد <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
                    <div less @click="showMoreLess" class="btn mt-15" ><span class="d-flex align-center justify-center">عرض أقل <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
                </template>
            </div>
        </div> -->
    </div>
</template>

<script>
import CourseInfoText from './CourseInfoText.vue'
export default {
    props: ['courseName','description','lectures','documents'],
    data(){
        return {
            showMore: false,
        }
    },
    methods: {
        showMoreLess() {
            this.showMore = !this.showMore
        }
    },
    components: {CourseInfoText}
}
</script>
<style scoped>
.learn-points p {
    width: 45%;
    margin-bottom: 30px;
    position: relative;
    display: flex;
}
.learn-points p:before {
    content:'-';
    margin-left: 5px;
}


[show-more-less] [less], .to-show, [show-more-less].active [more]  {
    display: none;
}
[show-more-less]:not(.active) .to-show:nth-child(-n+4),[show-more-less].active .to-show ,
[show-more-less].active [less]{
    display: block;
}
/* .course-lectures .btn {
    padding:8px;
} */
</style>