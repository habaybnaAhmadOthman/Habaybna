<template>
    <div class="course-card w-30 radius-10 overflow-hidden bg-white relative">
        <figure class="d-flex relative overflow-hidden radius-10 figure-box">
            
            <!-- favourite -->
            <div v-if="isCourse" class="fav-box relative pointer"></div>
            
            <!-- video player container -->
            <div class="art-app w-100 video-box"></div>
            
            <!-- discount label -->
            <template v-if="isCourse && courseData">
                <DiscountLabel class="course-discount" :is-free="courseData.is_free" 
                :hasDiscount="courseData.discount.has_discount" 
                :discountValue="courseData.discount.discount_value" />
            </template>

        </figure>
        <div class="d-flex box-details flex-wrap" :class="{'course-options':isCourse}">
            <!-- for course page -->
            <template v-if="isCourse">
                <button @click="checkLogin" class="btn-register-now white-i font-18 mb-20 bold flex-all w-100 pointer">إشترك الآن</button>
                <CoboneForm @buyCourse="buyCourse" @getPromoCode="setPromoCode" :coursePrice="courseData && courseData.price" :courseID="getCourseID" :courseName="courseData && courseData.title" :isLoggedIn="isLoggedIn" />
                
                <!-- hidden form -->
                <PaymentForm v-if="paymentFormData" :paymentData="paymentFormData" @clearPaymentData="clearPaymentData"></PaymentForm>

                <!-- discount amount -->
                <div v-if="isCourse && courseData" class="d-flex space-between mt-25 align-center w-100">
                    <span
                        class="gray font-35 before-discount bold"
                        ><template v-if="!courseData.is_free && courseData.discount.discount_price">{{ courseData.discount.discount_price }} JD</template></span
                    >
                    <span
                        class="bold font-35 main-color"
                        v-if="!courseData.is_free && courseData.price"
                        >{{ courseData.price }} JD</span
                    >
                </div>
            </template>
            <!-- for lesson page -->
            <LectureOptions v-else-if="!isCourse"></LectureOptions>
        </div>
    </div>
</template>

<script>
    import PaymentForm from './PaymentForm.vue'
    import CoboneForm from './CoboneCard_CoboneForm.vue'
    import DiscountLabel from '../onlinecourses/Card_DiscountLabel.vue'
    import LectureOptions from './CoboneCard_LectureOptions.vue'
    export default {
        props: ['videoSrc'],
        components: {PaymentForm,LectureOptions,DiscountLabel,CoboneForm},
        computed: {
            isCourse(){
                return !this.$route.params.lesson ? true : false
            },
            isLoggedIn() {
                return this.$store.getters["user/isLoggedIn"];
            },
        },
        data() {
            return {
                paymentFormData:null,
                hasPromoCode: {
                    id: ''
                },
                showPaymentForm: false,
                player: null,
                videoSource: null,
                courseData: null,
                lectureData: null,
            }
        },
        methods: {
            getLectureData(){
                this.lectureData = this.$store.getters["courses/currentLecture"];
                console.log(this.lectureData)
            },
            setPromoCode(id){
                this.hasPromoCode.id = id;
            },
            checkLogin(){
                if (this.isLoggedIn) {
                    this.buyCourse();
                } else {
                    this.$store.commit('loginModal',true);
                }
            },
            clearPaymentData(){
                this.paymentFormData = null
            },
            async buyCourse(){
                this.isLoading(true)
                try {
                    const resp = await this.$store.dispatch('courses/buyCourse',{
                        courseID:this.getCourseID(),
                        hasPromoCode:this.hasPromoCode
                    });
                    this.paymentFormData = resp.SmartRouteParams

                } catch (error) {
                    this.$store.commit('alertDialogMsg',error.message);
                }
                this.isLoading(false)
            },
            getCourseID(){
                return this.$store.getters["courses/course"].id
            },
            getCourseData(){
                this.courseData =  this.$store.getters["courses/course"]
            },
            isLoading(status) {
                this.$store.commit('isLoading',status)
            },
            async beforeVideoInit(){
                if (this.isCourse) {
                    
                } else {

                }
            },
            initPlayer() {
                const Artplayer = require('artplayer');
                this.player = new Artplayer({
                    container: '.art-app',
                    playbackRate: true,
                    setting: true,
                    url: this.videoSrc,
                    // url: 'https://test.habaybna.ps/storage/videos/promoVideo/coursePromoVideo-261944810_331247015097629_6572692877204065541_n.mp4',
                    theme: '#632F63',
                    // isLive: true,
                    // playsInline: true,
                    fullscreen: true,
                    hotkey: false,
                    miniProgressBar: true,
                    icons: {
                        indicator: '<img width="16" heigth="16" src="/images/indicator-video.svg">',
                    },
                });
                this.player.on('ready', () => {
                    // art.switchUrl(this.videoSrc, '');
                    // this.player.seek = 4;
                });
                this.player.on('pause', () => {
                    this.$store.dispatch('courses/videoAction',{
                        videoID: this.lectureData.id,
                        courseID: this.lectureData.course_id,
                        inProgress: this.player.currentTime,
                        type: 'progress'
                    })
                });
            },
            async initVideoPlayer() {
                await this.beforeVideoInit()
                this.initPlayer()
            }
        },
        async mounted() {
            if (this.isCourse)
                this.getCourseData()
            else 
                this.getLectureData()
            this.initVideoPlayer()
        },
        beforeDestroy() {
            if (this.player) {
                document.querySelector('.art-app').remove();
                // this.player.destroy()
            }
        }
    }
</script>

<style scoped>
.btn-register-now {
    background:#632F63;
    border-radius: 25px;
    height: 60px;
    border: 0;
}
.box-details {
    padding: 20px 20px 40px 20px;
}
.course-options {
    padding: 20px 20px 8px 20px;
}
.course-card {
    box-shadow: 0px 3px 6px #00000029;
    align-self: end;
    top: 170px;
}

.fav-box {
    position: absolute;
    background-color: rgb(255 255 255 / 90%);
    border-radius: 50%;
    left: 11px;
    top: 14px;
    width: 44px;
    height: 44px;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: .3s;
    z-index: 10;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
.figure-box .play-icon {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 55px;
    height: 55px;
    margin: auto;
}
.video-box {
    height: 321px;
}
.before-discount {
    position: relative;
    top: 1px;
}
.before-discount:after {
    content: '';
    position: absolute;
    left: -4px;
    top: -3px;
    bottom: 0;
    margin: auto;
    width: 108%;
    height: 1px;
    background: red;
}
</style>
<style>
.art-video-player .art-bottom .art-progress {
    pointer-events: none !important;
}
.art-video-player .art-mask .art-state {
    top: 0;
    left: 0;
    right: 0!important;
    bottom: 0!important;
    background-image: url(/images/play-icon.svg)!important;
    background-repeat: no-repeat!important;
    background-size: 84px 84px!important;
    background-position: center center!important;
    border: none !important;
    box-shadow: none !important;
    height: 84px!important;
    width: 84px!important;
    opacity: 1!important;
    margin: auto;
}
.art-video-player .art-mask .art-state svg {
    display: none !important;
}

</style>
