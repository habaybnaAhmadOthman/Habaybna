<template>
    <div class="banner relative">
        <div class="container h-100">
            <div class="d-flex flex-wrap-p h-100">
                <div class="d-flex banner-mo align-center box h-100 relative w-70 w-100-p p-side-12-p flex-wrap-p pt-25-p">
                    <div class="w-100 mb-25-p">
                        <p class="yellow font-18-p bold-p mb-10-p">{{headTitle}}</p>
                        <h1 class="font-50 white bold pre-line font-20-p">{{bannerTitle}}</h1>
                    </div>
                    <div class="d-flex details white font-20 pb-10 w-100-p">
                        <p class="d-flex align-center icon ml-20"><img class="ml-10" src="/images/time-icon.svg" width="31" height="31" alt=""><span class="ml-5">{{courseLength}}</span> <span v-if="!isLectureFn">ساعة</span> <span v-else>دقائق</span></p>
                        <p class="d-flex align-center icon ml-20" v-if="!isLectureFn"><img class="ml-10 video" src="/images/video-svgrepo.svg" width="39" height="34" alt="">{{videosCount}} دروس</p>
                        <p class="d-flex align-center icon pointer" v-if="!isLectureFn" @click="openShareModal"><img class="ml-10 share" src="/images/share-icon.svg" width="34" height="36" alt="">مشاركة</p>
                    </div>
                </div>
                
                <CoboneCard v-if="videoSrc" :videoSrc="videoSrc"></CoboneCard>
            </div>
        </div>
    </div>
</template>
<script>
import CoboneCard from './CoboneCard.vue'

export default {
    emits: ['open-share-modal'],
    props: ['videoSrc', 'bannerTitle','videosCount','courseLength','is-lecture','lectureNumber'],
    components: {CoboneCard},
    methods: {
        openShareModal(){
            this.$emit('open-share-modal')
        },
    },
    computed: {
        // get yellowed header 
        headTitle(){
            if (this.isLectureFn)
                return 'الدرس ' + this.lectureNumber
            else
                return 'دورة التدريب الرقمية'
        },
        isLectureFn(){
            if (this.isLecture && this.isLecture == true)
                return true

            return false;
        }
    },
    mounted(){
        
    }
}
</script>

<style scoped>
.banner {
    height:502px;
    background-image: url(/images/course-details.png);
    background-position: center;
    background-size: contain;
    background-repeat: no-repeat;
    background-color: #823175;
}
.details {
    position: absolute;
    bottom: 42px;
    left: 60px;
}
@media (max-width: 767px) {
    .banner {
        height:auto;
        background:none;
    }
    .details {
        position: unset;
        justify-content: space-between;
    }
    .details .icon {
        font-size: 18px;
    }
    .details .icon img{
        width: 25px;
        height: 25px;
    }
    .banner-mo {
        background-image: url(/images/course-details-mo.svg);
        background-position: -4vw center;
        background-size: cover;
        background-repeat: no-repeat;
        background-color: #823175;
    }
    .video {
        width: 33px!important;
        height: 28px!important;
    }
    .share {
        width: 28px!important;
        height: 30px!important;
    }
    .course-card {
        top:auto;
        margin-top: 20px;
    }
}
</style>
