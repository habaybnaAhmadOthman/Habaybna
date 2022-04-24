<template>
    <div class="partners-section">
        <div class="container p-side-12-p">
            <h2 class="title-line mb-40 mb-20-p">شركاء النجاح</h2>
            <p class="black-2 font-24 mb-40 font-18-p mb-20-p">شكرا من القلب لشركاء حبايبنا والداعمين الذين يشتركون معنا في القيم ونعمل سويا لتحقيق أثر مستدام في حياة حبايبنا من ذوي الإعاقات الذهنية</p>
            <Slider :selector="'partners-swiper'" :arrow-selector="'partners'" :slides-per-view="5" :spaceBetween="50" :auto-play="true" :autoplay-delay="2500" :mobile-per-view="3" :spaceBetweenMobile="20"
            :pagination-mo="true" :pagination-do="false"></Slider>
        </div>
    </div>
</template>

<script>
    import Slider from '../../layouts/Slider.vue'
    export default {
        components: {
            Slider
        },
    }
</script>
