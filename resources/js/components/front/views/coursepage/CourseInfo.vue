<template>
    <div class="about-course pt-20 w-50">
        <h1 class="title- font-30 main-color">{{courseName}}</h1>
        <h2 class="by main-color font-18 mb-10"><span> بواسطة الاخصائي :</span> <span class="bold">{{specialistName}}</span></h2>
        <p class="desc">{{courseDescription}}</p>
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
        </div>
    </div>
</template>

<script>
export default {
    props: ['courseName','specialistName','courseDescription','lectures'],
    data(){
        return {
            showMore: false,
        }
    },
    methods: {
        showMoreLess() {
            this.showMore = !this.showMore
        }
    }
}
</script>
<style scoped>
[show-more-less] [less], .to-show, [show-more-less].active [more]  {
    display: none;
}
[show-more-less]:not(.active) .to-show:nth-child(-n+4),[show-more-less].active .to-show ,
[show-more-less].active [less]{
    display: block;
}
.course-lectures .btn {
    padding:8px;
}
</style>