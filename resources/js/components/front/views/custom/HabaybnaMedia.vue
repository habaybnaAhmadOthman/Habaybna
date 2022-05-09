<template>
    <div class="media-section">
        <div class="container p-side-12-p">
            <h2 class="title-line mb-40 mb-20-p">حبايبنا في الإعلام</h2>
            <Slider :selector="'media-swiper'" :arrow-selector="'media'" :slides-per-view="5" 
            :spaceBetween="50" :auto-play="true" :autoplay-delay="2500" 
            :mobile-per-view="3" :spaceBetweenMobile="20"
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
