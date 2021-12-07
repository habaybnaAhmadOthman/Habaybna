<template>
    <div class="course-details pt-10">
        <p class="font-50 main-color center">USD 100</p>
        <router-link class="btn white font-30 w-100 d-block center subscribe-now" to="">اشــتــرك الآن</router-link>
        <div class="coupon-box radius-12 mt-15 d-flex align-center space-between">
            <span class="white font-15 ml-30">هل لديك قسيمة خصم؟ استخدمه الآن</span>
            <div class="coupon-link"></div>
        </div>
        <div class="mt-25">
            <p class="font-14 d-flex align-center mb-5"><img class="ml-10" src="/images/siteImgs/header/logo.png" alt="" width="18" height="31"> 3 ساعات تدريب مسجلة بجودة عالية</p>
            <p class="font-14 d-flex align-center"><img class="ml-10" src="/images/siteImgs/header/logo.png" alt="" width="24" height="22"> شهادة حضور بعد الإنتهاء </p>
        </div>
        <div class="social-platforms d-flex align-center mt-20">
            <span class="ml-10">شارك</span>
            <div class="social-box d-flex">
                <router-link class="d-flex" to=""><img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="36" height="36"></router-link>
                <router-link class="d-flex" to=""><img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="36" height="36"></router-link>
                <router-link class="d-flex" to=""><img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="36" height="36"></router-link>
                <router-link class="d-flex" to=""><img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="36" height="36"></router-link>
                <router-link class="d-flex" to=""><img src="/images/siteImgs/header/logo.png" alt="" width="36" height="36"></router-link>
            </div>
        </div>

        <div class="course-review d-flex align-center mt-30">
            <p class="font-14 ml-20">تقييم <span>( <span>5</span> )</span> مستخدمين</p>
            <div class="review-stars d-flex">
                <img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="34" height="30">
                <img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="34" height="30">
                <img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="34" height="30">
                <img class="ml-5" src="/images/siteImgs/header/logo.png" alt="" width="34" height="30">
                <img src="/images/siteImgs/header/logo.png" alt="" width="34" height="30">
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            
        }
    },
    methods: {
        
    }
}
</script>
<style scoped>

.subscribe-now {
    padding:4px;
}
.coupon-box {
    background:#FE7307;
    box-shadow: 0px 3px 6px #00000029;
    padding-right: 20px;
}
.coupon-link {
    background-image: url(/images/siteImgs/header/logo.png);
    background-size: 100% 100%;
    width: 60px;
    height: 60px;
}
</style>