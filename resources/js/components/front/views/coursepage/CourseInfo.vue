<template>
    <div class="about-course pt-20 w-50">
        <h1 class="title- font-30 main-color">الخطة التربوية الفردية (الجزء الثاني)</h1>
        <h2 class="by main-color font-18 mb-10"><span> بواسطة الاخصائي :</span> <span class="bold">أحمد حمدان</span></h2>
        <p class="desc">في هذا الجزء من المساق سيتم استعراض أهم الأسس في مجال اختبارات الذكاء عند تصميم الخطة التربوية الفردية للأطفال ذوي الاضطرابات النمائية</p>
        <div class="course-lectures mt-20">
            <p class="main-color font-26 mb-10">محتوى الدورة التدريبية</p>
            <div class="box" show-more-less :class="{'active': showMore}">
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                <div class="to-show">
                    <div class="lecture d-flex space-between gray font-14">
                        <p>الخطة التربوية</p>
                        <p>10 دقيقة</p>
                    </div>
                </div>
                
                <div more @click="showMoreLess" class="btn mt-15" ><span class="d-flex align-center justify-center">أظهر المزيد <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
                <div less @click="showMoreLess" class="btn mt-15" ><span class="d-flex align-center justify-center">عرض أقل <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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