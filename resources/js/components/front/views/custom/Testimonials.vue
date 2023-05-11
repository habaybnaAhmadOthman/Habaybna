<template>
    <div class="testimonials-box container p-side-12-p">
        <p class="title-line mb-40 mb-20-p">{{title}}</p>
            <div class="relative inner-arrows p-side-100 p-side-15-p">
                <div :class="`${type}-testimonial-slider`" class="relative my-swiper" dir="rtl">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper p-0">
                        <!-- Slides -->
                        <div v-for="item in slides" :key="item.content" class="swiper-slide w-80-p">
                            <div class="bg-white radius-12 pt-30 p-side-30 pb-30  pt-10-p pb-10-p p-side-15-p testimonial-box">
                                <img class="img-quote mb-20 mb-10-p mt-10-p" src="/images/quote-icon.svg" width="38" height="27">
                                <p class="black bold font-18 font-14-p three-line mb-10-p">{{item.content}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination" :class="`swiper-pagination-${type}`"></div>
                </div>
                <div class="swiper-button-next do" :class="`${type}-testimonial-next`"></div>
                <div class="swiper-button-prev do" :class="`${type}-testimonial-prev`"></div>
            </div>
    </div>
</template>

<script>
    // types => ['call','course','content']
    export default {
        props: ['type','title'],
        methods:{
            initSwiper(){
                // if (!window.matchMedia("(max-width: 677px)").matches) {
                new Swiper(`.${this.type}-testimonial-slider`, {
                    navigation: {
                        nextEl: `.${this.type}-testimonial-next`,
                        prevEl: `.${this.type}-testimonial-prev`,
                    },


                    breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: "auto",
                        spaceBetween: 20,
                        // pagination: this.paginationFn('paginationMo')
                    },
                    // // when window width is >= 480px
                    // 480: {
                    // slidesPerView: 3,
                    // spaceBetween: 10
                    // },
                    // // when window width is >= 640px
                    1000: {
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        // pagination: this.paginationFn('paginationDo')
                    }
                },

                });

                // }
            },
            async getData(){
                const data = (await this.$store.dispatch('content/getTestimonials',{type:this.type}));
                this.slides = data
            }
        },
        mounted() {
            this.getData()
            this.initSwiper();
        },
        data(){
            return {
                slides: []
            }
        }
    }
</script>

<style scoped>
.swiper-slide {
    width: 500px;
}
.testimonial-box {
    min-height: 169px;
}
@media (max-width: 767px) {
    .testimonial-box {
        min-height: 148px;
    }
}
</style>
