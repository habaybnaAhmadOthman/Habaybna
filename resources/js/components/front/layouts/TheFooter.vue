<template>
    <footer class="main-footer pb-30">
        <div class="container">
            <div class="d-flex footer-row flex-wrap-p p-side-12-p">
                <div class="d-flex w-70 flex-wrap-p w-100-p">
                    <div class="hab-library footer-col">
                        <ul>
                            <li>
                                <router-link to="/">الرئيسية</router-link>
                            </li>
                            <li>
                                <router-link to="/online-courses">الدورات الرقمية</router-link>
                            </li>
                            <li>
                                <router-link to="/ask-specialists">الاستشارات مع المختصين</router-link>
                            </li>
                            <li>
                                <router-link to="/library">مكتبة المعلومات</router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="hab-dectionary footer-col">
                        <ul>
                            <!-- <li>
                                <router-link to="/">دليل حبايبنا</router-link>
                            </li> -->
                            <li>
                                <router-link to="/terms-and-conditions">السياسات والأحكام</router-link>
                            </li>
                            <li>
                                <router-link to="/media-coverage">حبايبنا في الاعلام</router-link>
                            </li>
                            <li>
                                <router-link to="/about-habaybna">عن حبايبنا.نت</router-link>
                            </li>
                            <li class="d-flex-p space-between">
                                <router-link to="/">تواصلوا معنا</router-link>
                                <div class="mo">
                                    <div class="d-flex align-center">
                                        <img src="/images/mastercard.svg">
                                        <img src="/images/visa-logo.svg" class="mr-10">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="hab-last footer-col">
                        <ul>
                            <li>
                                <router-link to="/about-habaybna-en">About Habaybna.net</router-link>
                            </li>
                            <li>
                                <router-link to="/">habaybna.net in the media</router-link>
                            </li>
                            <li>
                                <router-link to="/terms-and-conditions-en">TERMS & CONDITIONS</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="left-side-info w-30 pr-30 w-100-p do">
                    <!-- <h6 class="black bold font-20 mb-20">المشاركة معنا</h6>
                    <p class="black font-16 mb-10">هل ترغب بالمشاركة في منصة حبايبنا؟</p>
                    <p class="font-15"> هل ترغب بأن تساهم بتجربتك أو خبرتك في مجال الإعاقات الذهنية والتطورية؟ هل تود أن تترك أثر مستدام قد يغير حياة طفل ذو إعاقة ذهنية  وحياة عائلة بأكملها وأن تكون جزء جميل من حبايبنا.نت؟</p>
                    <div class="mt-10 mb-10">
                        <router-link class="black font-16 bold" to="/">إعرف المزيد</router-link>
                    </div> -->
                    <div class="d-flex align-center">
                        <img src="/images/mastercard.svg">
                        <img src="/images/visa-logo.svg" class="mr-10">
                    </div>
                </div>
            </div>
            <div class="second-row d-flex space-between pt-15 flex-wrap-p justify-center-p p-side-12-p">
                <!-- <div class="langs d-flex align-center">
                    <img src="/images/language-icon.svg">
                    <select class="pointer">
                        <option value="ar" selected>Arabic</option>
                        <option value="en">English</option>
                    </select>
                </div> -->
                <p class="flex-all w-100-p all-rights mt-10-p">كافة الحقوق محفوظة {{new Date().getFullYear()}} حبايبنا.نت</p>
                <div class="socail-links d-flex align-center">
                   <router-link to="https://www.youtube.com/channel/UCldw52FzyIcYgOXASVlFxPA" class="mr-20">
                        <img class="youtube" src="/images/youtube-icon-color.svg" width="43" height="30" alt="">
                   </router-link>
                   <router-link to="https://twitter.com/habaybnadotnet" class="mr-20">
                        <img class="twitter" src="/images/twitter-icon-color.svg" width="37" height="37" alt="">
                   </router-link>
                   <router-link to="https://www.instagram.com/habaybnadotnet/" class="mr-20">
                        <img class="instagram" src="/images/instagram-icon-color.svg" width="37" height="37" alt="">
                   </router-link>
                   <router-link to="https://www.facebook.com/habaybnadotnet" class="mr-20">
                        <img class="facebook" src="/images/facebook-icon-color.svg" width="18" height="36" alt="">
                   </router-link>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
a {
    color: #363636;
    font-size: 16px;
}
li {
    margin-bottom: 10px;
}
.footer-col {
    flex: 1;
}
.left-side-info {
    border-right: 2px solid #c4c4c4;
}
footer {
    margin-top: 60px;
    background:#F2F2F2;
    box-shadow: 0px 3px 6px #00000029;
    padding-top:45px;
}
.footer-row {
    border-bottom: 1px solid #000;
    padding-bottom: 15px;
}
select {
    width: 100px;
    background: transparent;
    border: 0;
}
.socail-links a {
    display: flex;
}
@media (max-width: 767px) {
    .footer-col {
        flex: auto;
        width: 50%;
    }
    .left-side-info {
        padding: 0;
        border: 0;
    }
    footer {
        margin-top: 40px;
        padding-bottom: 60px;
    }
    .all-rights {
        order:3;
    }
    .facebook {
        width: 10px;
        height: 19px;
    }
    .instagram {
        width: 19px;
        height: 19px;
    }
    .twitter {
        width: 19px;
        height: 15px;
    }
    .youtube {
        width: 22px;
        height: 16px;
    }
    footer {
        padding-top: 15px;
    }
    .hab-dectionary {
        order: 3;
    }
}
</style>