<template>
    <div class="relative inner-arrows p-side-100 p-side-15-p">
        <div :class="selector" class="relative my-swiper" dir="rtl">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper p-0">
                <!-- Slides -->
                <a @click="goToLink(item.url)" v-for="item,index in data" :key="index" class="swiper-slide">
                    <div class="w-100-i fig d-flex align-center relative">
                        <img :src="item.image" :alt="item.title" class="w-100-i">
                        <span class="tip two-line">{{item.title}}</span>
                    </div>
                </a>
            </div>
            <div class="swiper-pagination" :class="`swiper-pagination-${this.selector}`"></div>
        </div>
        <div class="swiper-button-next do" :class="`${arrowSelector}-next`"></div>
        <div class="swiper-button-prev do" :class="`${arrowSelector}-prev`"></div>
    </div>
</template>

<script>
    export default {
        props: ['data','selector','arrow-selector','slides-per-view','spaceBetween','auto-play','autoplay-delay'
        ,'mobile-per-view','spaceBetweenMobile','pagination-mo','pagination-do'],
        methods:{
            initSwiper(){
                // if (!window.matchMedia("(max-width: 677px)").matches) {
                new Swiper(`.${this.selector}`, {
                    navigation: {
                        nextEl: `.${this.arrowSelector}-next`,
                        prevEl: `.${this.arrowSelector}-prev`,
                    },

                    autoplay: this.autoPlayFn,

                    breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: this.mobilePerView,
                        spaceBetween: this.spaceBetweenMobile,
                        pagination: this.paginationFn('paginationMo')
                    },
                    // // when window width is >= 480px
                    // 480: {
                    // slidesPerView: 3,
                    // spaceBetween: 10
                    // },
                    // // when window width is >= 640px
                    1000: {
                        slidesPerView: this.slidesPerView,
                        spaceBetween: this.spaceBetween,
                        pagination: this.paginationFn('paginationDo')
                    }
                },

                });

                // }
            },
            paginationFn(device){
                if (this[device]) {
                    return {
                        el: `.swiper-pagination-${this.selector}`,
                        clickable: false,
                    }
                } else {
                    return false
                }
            },
            goToLink(url){
                if(url === null)
                    return
                    window.open(url, '_blank')
            }
        },
        computed:{
            autoPlayFn(){
                if (this.autoPlay) {
                    return  {
                        delay: this.autoplayDelay || 2500,
                        disableOnInteraction: false,
                    }
                } else {
                    return false
                }
            },
        },
        mounted(){
            this.initSwiper()
        },

    }
</script>

<style scoped>
.swiper-pagination {
    position: initial;
    margin-top: 10px;
}
.fig {
    height: 100px;
}
.fig img{
    max-height: 100%;
    object-fit: contain;
}
.tip {
    position: absolute;
    right: 0;
    top: 20%;
    left: 0;
    margin: auto;
    max-width: 100%;
    background: rgb(120 13 147 / 50%);
    border-radius: 8px;
    color: #fff;
    text-align: center;
    opacity: 0;
    transition: .3s;
}
.fig:hover .tip {
    opacity: 1;
    top: 0;
}
</style>
<style>
.inner-arrows .swiper-button-next {
    left: 0!important;
    right: auto;
}
.inner-arrows .swiper-button-prev {
    left: auto;
    right: 0!important;
}
.swiper-pagination-bullet-active {
    background: #823175;
}

</style>
