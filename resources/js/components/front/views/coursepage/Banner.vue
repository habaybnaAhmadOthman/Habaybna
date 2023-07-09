<template>
    <div class="banner relative">
        <div class="container h-100">
            <div class="d-flex flex-wrap-p h-100">
                <div class="d-flex banner-mo align-center box h-100 relative w-70 w-100-p p-side-12-p flex-wrap-p pt-25-p">
                    <div class="w-100 mb-25-p">
                        <p class="yellow font-13-p bold-p mb-10-p">{{headTitle}}</p>
                        <h1 class="font-40 white bold pre-line font-18-p">{{bannerTitle}}</h1>
                    </div>
                    <div class="d-flex details white font-20 pb-10 w-100-p space-between">
                        <p class="d-flex align-center icon ml-20 m-0-p"><img class="ml-10" src="/images/time-icon.svg" width="31" height="31" alt=""><span class="ml-5">{{ getTime }}</span></p>
                        <p class="d-flex align-center icon ml-20 m-0-p" v-if="!isLectureFn"><img class="ml-10 video" src="/images/video-svgrepo.svg" width="39" height="34" alt="">{{videosCount}} حلقة</p>
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
        getTime(){
            if (typeof this.courseLength != 'number') {
                return `${this.courseLength} دقيقة`
            }
            var hms = new Date(this.courseLength * 1000).toISOString().substr(11, 8);
            let str = ''
            const hours = +hms.split(':')[0];
            const minutes = +hms.split(':')[1];
            if (hours > 0) {
                str += `${hours} ساعة`
                if (minutes > 0) {
                    str += `، ${minutes} دقائق`
                }
            } else {
                if (minutes > 0) {
                    str += `${minutes} دقيقة`
                } else {
                    str += `${+hms.split(':')[2]} ثواني`
                }
            }
            return str
        },
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
        font-size: 15px;
    }
    .details .icon img{
        width: 19px;
        height: auto;
    }
    .banner-mo {
        background-image: url(/images/course-details-mo.svg);
        background-position: -4vw center;
        background-size: cover;
        background-repeat: no-repeat;
        background-color: #823175;
    }
    .video {
        width: 22px!important;
        height: auto!important;
    }
    .share {
        width: 20px!important;
        height: auto!important;
    }
    .course-card {
        top:auto;
        margin-top: 20px;
    }
}
</style>
