<template>
    <section class="">
        <div class="swiper" :options="swiperOption">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="lib-items">
                        1
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="lib-items">
                        2
                    </div>
                </div>
            </div>
            <div class="swiper-pagination" slot="pagination"></div>
            <div class="arrows">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>
</template>

<script>
import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import "swiper/css/swiper.css";
export default {
    props: ["library"],
    data() {
        return {
            Swiper,
            SwiperSlide,
            swiperOption: {
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true
                }
            }
        };
    }
};
</script>
