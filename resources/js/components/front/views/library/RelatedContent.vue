<template>
    <div class="related-content-section">
        <h6 class="title-line font-27 mb-40 mb-20-p p-side-12-p">مقالات ذات صلة</h6>
        <div class="list relative">
            <div class="related-content-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper swipe-box-p column-gap-20-p p-side-12-p">
                    <!-- Slides -->
                    <div v-for="(item, index) in appendedData" :key="index" class="swiper-slide w-80-p">
                        <SmallCard @click.native="forceRefresh" :item="item" class="w-100-i" ></SmallCard>
                    </div>
                </div>
                <div class="swiper-button-next related-content-next do"></div>
                <div class="swiper-button-prev related-content-prev do"></div>
            </div>
            
        </div>
    </div>
</template>

<script>
    import SmallCard from '../../layouts/SmallCard.vue'

    export default {
        props: ['data'],
        components:{SmallCard},
        data:()=>({
            appendedData: [],
            desktopSwiper:null
        }),
        created() {
            this.getData();
        },
        methods: {
            async getData(){
                this.appendedData = await this.data
                this.initSwiper()
            },
            initSwiper(){
                    if (!window.matchMedia("(max-width: 677px)").matches) {
                        this.desktopSwiper = new Swiper(".related-content-swiper", {
                            navigation: {
                                nextEl: ".related-content-next",
                                prevEl: ".related-content-prev",
                            },
                            slidesPerView: 3,
                            spaceBetween: 12,
                        });
                    }
            },
            forceRefresh(){
                this.$store.commit("forceRefresh");
            },
        },
        beforeDestroy(){
            if (this.desktopSwiper) {
                document.querySelector('.related-content-swiper') && document.querySelector('.related-content-swiper').remove();
            }
            
        }
    }
</script>
