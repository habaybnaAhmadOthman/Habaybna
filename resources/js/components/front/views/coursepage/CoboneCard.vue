<template>
    <div class="course-card w-30 radius-10 overflow-hidden bg-white relative w-100-p m-side-12-p">
        <figure class="d-flex relative overflow-hidden radius-10 figure-box">
            <!-- <button @click="addVideoAction('isComplete')">Complete</button> -->
            <!-- favourite -->
            <div v-if="isCourse" class="fav-box relative pointer"></div>
            
            <!-- video player container -->
            <video ref="videoPlayer" class="video-js main-img w-100"></video>
            
            <!-- discount label -->
            <template v-if="isCourse && courseData && !courseData.isPurchased">
                <DiscountLabel class="course-discount" :is-free="courseData.is_free" 
                :hasDiscount="courseData.discount.has_discount" 
                :discountValue="courseData.discount.discount_value" />
            </template>

        </figure>
        <div class="d-flex box-details flex-wrap" :class="{'course-options':isCourse }">
            <!-- for course page -->
            <template v-if="isCourse && courseData && !courseData.isPurchased">
                <template v-if="courseData.is_free">
                    <button @click="getFreeCourse" class="btn-register-now white-i font-18 font-16-p mb-20 bold flex-all w-100 pointer mb-10-p">إبدأ التعلم الآن</button>
                </template>
                <template v-else>
                    <button @click="checkLogin" class="btn-register-now white-i font-18 font-16-p mb-20 bold flex-all w-100 pointer mb-10-p">إشترك الآن</button>
                    <CoboneForm @buyCourse="buyCourse" @getPromoCode="setPromoCode" :coursePrice="courseData && courseData.price" :courseID="getCourseID" :courseName="courseData && courseData.title" :isLoggedIn="isLoggedIn" />
                </template>
                
                <!-- hidden form -->
                <PaymentForm v-if="paymentFormData" :paymentData="paymentFormData" @clearPaymentData="clearPaymentData"></PaymentForm>

                <!-- discount amount -->
                <div v-if="isCourse && courseData" class="d-flex space-between mt-25 align-center w-100 mt-10-p">
                    <span
                        class="gray font-35 before-discount bold"
                        ><template v-if="!courseData.is_free && courseData.price ">{{ courseData.price }} JD</template></span
                    >
                    <span
                        class="bold font-35 main-color"
                        v-if="!courseData.is_free && courseData.discount.discount_price"
                        >{{ courseData.discount.discount_price }} JD</span
                    >
                </div>
            </template>
            <template v-else-if="isCourse && courseData && courseData.isPurchased">
                <button @click="continueWatching" class="btn-register-now white-i font-18 font-16-p mb-20 bold flex-all w-100 pointer mb-10-p">متابعة</button>
            </template>
            <!-- for lesson page -->
            <LectureOptions v-else-if="!isCourse"></LectureOptions>
        </div>
    </div>
</template>

<script>
    import videojs from 'video.js';
    import 'video.js/dist/video-js.css'

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
                videoOptions: {
                    muted: false,
                    autoplay: false,
                    controls: true,
                    sources: [
                        {
                            src:
                                "https://cms.habaybna.net/sites/default/files/2021-10/IEP%20Teaser%20%281%29.mp4",
                            type: "video/mp4"
                        }
                    ],
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                },
                courseData: null,
                lectureData: null,
            }
        },
        methods: {
            getLectureData(){
                this.lectureData = this.$store.getters["courses/currentLecture"];
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
            continueWatching() {
                var goToLectureNumber = this.courseData.course_progress.findIndex(c => c.is_complete == 0);
                const goToLecture = this.courseData.videos_title_length[goToLectureNumber].lesson_title.split(' ').join('-')
                this.$router.push(`/courses/${this.courseData.title.split(' ').join('-')}/${goToLecture}`)
            },
            async getFreeCourse(){
                const freeCourse = await this.$store.dispatch('courses/getFreeCourse',{
                    courseID: this.courseData.id
                })
            },
            // ************
            // player methods
            // ************
            initPlayer() {
                this.videoOptions.sources[0].src =  this.videoSrc
                this.player = videojs(this.$refs.videoPlayer, this.videoOptions, function onPlayerReady() {
                    console.log('onPlayerReady', this);
                })
                // player events fired only for LESSONS
                if (!this.isCourse)
                    this.addPlayerEvents()
            },
            addPlayerEvents(){
                this.player.on('ready', function() {
                    // this.addClass('my-example');
                });
                this.player.on('ended', function() {
                    this.addVideoAction('isComplete')
                });
            },
            addVideoAction(type) {
                var params =  {
                    videoID: this.lectureData.id,
                    courseID: this.lectureData.course_id,
                    type: type // isComplete || progress
                }
                this.$store.dispatch('courses/videoAction',params)
            },
            getLectureProgress(){
                this.lectureData.progress = ''
                if (this.courseData.course_progress && this.courseData.course_progress && this.courseData.course_progress[this.lectureData.index]) {
                    this.lectureData.progress = this.courseData.course_progress[this.lectureData.index].in_progress
                }
            }
        },
        mounted() {
            this.getCourseData()
            if (!this.isCourse) {
                this.getLectureData()
                // this.getLectureProgress()
            }
            this.initPlayer()
        },
        beforeDestroy() {
            if (this.player) {
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
.figure-box,.video-js {
    height: 222px!important;
}
@media (max-width: 767px) {
    .btn-register-now {
        height: 50px;
    }
    .video-box {
        height: 216px;
    }
    .course-options {
        padding: 10px 16px 10px 16px;
    }
    .course-card {
        z-index: 0;
    }
    .figure-box,.video-js {
        height: 210px!important;
    }
}

</style>
<style>
.video-js {
    height: 222px!important;
}
.vjs-big-play-button {
    top: 0!important;
    left: 0!important;
    right: 0!important;
    bottom: 0!important;
    background-image:  url(/images/play-icon.svg)!important;
    background-repeat: no-repeat!important;
    background-size: 84px 84px!important;
    background-position: center center!important;
    border: none !important;
    box-shadow: none !important;
    height: 84px!important;
    width: 84px!important;
    margin: auto!important;
}
.video-js .vjs-big-play-button {
    background-color:transparent !important;
}
.vjs-big-play-button:before, .video-js .vjs-big-play-button .vjs-icon-placeholder:before {
    content: ""!important;
    display: none;
}
@media (max-width: 767px) {
    .video-js {
        height: 210px!important;
    }
}
</style>