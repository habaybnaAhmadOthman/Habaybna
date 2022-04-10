<template>
    <footer class="main-footer bg-gray-2 pt-30 pb-30">
        <div class="container">
                <div class="d-flex footer-row flex-wrap-p p-side-12-p">
                    <div class="d-flex w-70 flex-wrap-p w-100-p">
                        <div class="hab-library footer-col">
                            <h6 class="black bold font-20 mb-20">مكتبة حبايبنا</h6>
                            <ul>
                                <li>
                                    <router-link to="/">الفيديوهات</router-link>
                                </li>
                                <li>
                                    <router-link to="/">المقالات</router-link>
                                </li>
                                <li>
                                    <router-link to="/">مقدمي المحتوى</router-link>
                                </li>
                                <li>
                                    <router-link to="/">شارك معنا</router-link>
                                </li>
                            </ul>
                        </div>
                        <div class="hab-dectionary footer-col">
                            <router-link to="/">
                                <h6 class="black bold font-20 mb-20">دليل حبايبنا</h6>
                            </router-link>
                        </div>
                        <div class="hab-ask-exp footer-col">
                            <router-link to="/">
                                <h6 class="black bold font-20 mb-20">إسأل الأخصائيين</h6>
                            </router-link>
                        </div>
                        <div class="hab-ask-exp footer-col">
                            <router-link to="/">
                                <h6 class="black bold font-20 mb-20">الدورات</h6>
                            </router-link>
                        </div>
                        <div class="hab-ask-exp footer-col">
                            <h6 class="black bold font-20 mb-20">من نحن</h6>
                            <ul>
                                <li>
                                    <router-link to="/">عن حبايبنا</router-link>
                                </li>
                                <li>
                                    <router-link to="/">التغطية الإعلامية</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="left-side-info w-30 pr-30 w-100-p">
                        <h6 class="black bold font-20 mb-20">المشاركة معنا</h6>
                        <p class="black font-16 mb-10">هل ترغب بالمشاركة في منصة حبايبنا؟</p>
                        <p class="font-15"> هل ترغب بأن تساهم بتجربتك أو خبرتك في مجال الإعاقات الذهنية والتطورية؟ هل تود أن تترك أثر مستدام قد يغير حياة طفل ذو إعاقة ذهنية  وحياة عائلة بأكملها وأن تكون جزء جميل من حبايبنا.نت؟</p>
                        <div class="mt-10 mb-10">
                            <router-link class="black font-16 bold" to="/">إعرف المزيد</router-link>
                        </div>
                        <div class="d-flex align-center">
                            <img src="/images/mastercard.svg">
                            <img src="/images/visa-logo.svg" class="mr-10">
                        </div>
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
    color: #000;
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
    }
}
</style>