<template>
    <div class="about-coach p-side-12-p">
        <h3 class="title-line mb-40 do">عن المدربين</h3>
        <!-- desktop -->
        <div class="d-flex specialist-list flex-wrap row-3" v-if="!isMobile">
            <SpecialistCard v-for="specialist in specialists" :key="specialist.user_id" :specialist="specialist"></SpecialistCard>
        </div>
        <!-- mobile -->
        <div class="relative" v-else>
            <div class="coaches-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div v-for="specialist in specialists" :key="specialist.user_id" class="swiper-slide mobile-slide">
                        <SpecialistCard :specialist="specialist"></SpecialistCard>
                    </div>

                </div>
                <div class="swiper-button-next coaches-next mobile-arrow"></div>
                <div class="swiper-button-prev coaches-prev mobile-arrow"></div>
            </div>

        </div>
    </div>
</template>

<script>
import SpecialistCard from '../../views/specialists/SpecialistCard.vue'
export default {
    components: {SpecialistCard},
    props: ['specialistID', 'specialists'],
    data(){
        return {
            name: '',
            speciality: '',
            description: '',
            avatar: ''
        }
    },
    computed: {
        isMobile(){
            return window.matchMedia("(max-width: 677px)").matches
        }
    },
    created(){
        this.getSpecialistDetails()
    },
    methods: {
        async getSpecialistDetails(){
            try {
                const data = await this.$store.dispatch('specialist/getSpecialistDetails',this.specialistID);
                this.name = data.specialistName;
                this.speciality = data.speciality;
                this.description  = data.description;
                this.avatar  = data.avatar;
            } catch (e){
                console.log(e);
            }
            if (this.isMobile){
                this.initSwiper()
            }
        },
        initSwiper(){
            var swiper = new Swiper(".coaches-swiper", {
                navigation: {
                    nextEl: ".coaches-next",
                    prevEl: ".coaches-prev",
                },
                slidesPerView: 1,
                spaceBetween: 12,
            });
        }
    }
}
</script>
<style scoped>
@media (max-width: 767px) {
    .mobile-slide > * {
        width: 80%;
        margin: auto;
    }
    .swiper-button-prev { 
        right: 0px!important;
    }
    .swiper-button-next { 
        left: 0px!important;
    }
}
</style>
<style>
@media (max-width: 767px) {
    .swiper-button-next.mobile-arrow {
        background:url(/images/arrow-left-color-mo.svg) no-repeat!important;
        background-position: center center!important;
    }
    .swiper-button-prev.mobile-arrow {
        background:url(/images/arrow-left-color-mo.svg) no-repeat!important;
        transform: rotate(0);
        background-position: center center!important;
    }
}
</style>