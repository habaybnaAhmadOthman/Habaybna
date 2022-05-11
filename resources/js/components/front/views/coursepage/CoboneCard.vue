<template>
    <div class="course-card w-30 radius-10 overflow-hidden bg-white relative w-100-p m-side-12-p trans">
        <figure class="d-flex relative overflow-hidden radius-10 figure-box">
            <!-- favourite -->
            <div v-if="isCourse" @click="addToFavourite" :class="{'active':courseData && courseData.is_favourite}" class="fav-box relative pointer"></div>

            <!-- video player container -->
            <div class="vimeoPlayer video-js main-img w-100"></div>
            
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
                    <button @click="getFreeCourse" class="btn-register-now white-i font-18 font-16-p bold flex-all w-100 pointer">إبدأ التعلم الآن</button>
                </template>
                <template v-else>
                    <button @click="checkLogin" class="btn-register-now white-i font-18 font-16-p mb-20 bold flex-all w-100 pointer mb-10-p">إشترك الآن</button>
                    <CoboneForm @buyCourse="buyCourse" @getPromoCode="setPromoCode" :coursePrice="coboneCoursePrice" :courseID="getCourseID" :courseName="courseData && courseData.title" :isLoggedIn="isLoggedIn" />
                </template>

                <!-- hidden form -->
                <PaymentForm v-if="paymentFormData" :paymentData="paymentFormData" @clearPaymentData="clearPaymentData"></PaymentForm>

                <!-- discount amount -->
                <div v-if="isCourse && courseData" class="d-flex space-between mt-25 align-center w-100 mt-10-p">
                    <template v-if="courseData.discount.has_discount">
                        <span
                            class="gray font-35 before-discount bold"
                            ><template v-if="!courseData.is_free && courseData.price ">{{ courseData.price }} JD</template></span
                        >
                        <span
                            class="bold font-35 main-color"
                            v-if="!courseData.is_free && courseData.discount.discount_price"
                            >{{ courseData.discount.discount_price }} JD</span
                        >
                    </template>
                    <template v-else-if="!courseData.is_free && courseData.price">
                        <span
                            class="main-color font-35 bold d-block w-100 left"
                            ><template>{{ courseData.price }} JD</template></span
                        >
                    </template>
                </div>
            </template>
            <template v-else-if="isCourse && courseData && courseData.isPurchased">
                <button @click="continueWatching" class="btn-register-now white-i font-18 font-16-p mb-20 bold flex-all w-100 pointer mb-10-p">متابعة الدورة</button>
            </template>
            <!-- for lesson page -->
            <LectureOptions v-else-if="!isCourse"></LectureOptions>
        </div>
        <info-modal
          :show="infoModal.show"
          :title="infoModal.title"
          @close="closeInfoModal"
          :description="infoModal.description"
          :success="infoModal.status"
          :fixed="infoModal.isFixed"
          portal="cobone-card"
        >
        <button v-if="infoModal.isFixed" @click="goToClassRoom" class="btn">مشاهدة</button>
        </info-modal>
    </div>
</template>
<script>

    import PaymentForm from './PaymentForm.vue'
    import CoboneForm from './CoboneCard_CoboneForm.vue'
    import DiscountLabel from '../onlinecourses/Card_DiscountLabel.vue'
    import LectureOptions from './CoboneCard_LectureOptions.vue'

    import infoModalMixin from '../../mixins/infoModal'
    import Player from '@vimeo/player'
    export default {
        props: ['videoSrc'],
        mixins: [infoModalMixin],
        components: {PaymentForm,LectureOptions,DiscountLabel,CoboneForm},
        computed: {
            isCourse(){
                return !this.$route.params.lesson ? true : false
            },
            isLoggedIn() {
                return this.$store.getters["user/isLoggedIn"];
            },
            coboneCoursePrice(){
                if (this.courseData && this.courseData.discount.discount_price) {
                    return this.courseData.discount.discount_price
                } else if (this.courseData && this.courseData.price){
                    return this.courseData.price
                }
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
                courseData: null,
                lectureData: null,
                isDataReady: false,
            }
        },
        methods: {
            // ************
            // player methods
            // ************
            initPlayer() {
                // this.videoOptions.sources[0].src =  this.videoSrc
                const self = this
                this.player = new Player( document.querySelector('.vimeoPlayer') , {
                    id: this.videoSrc
                })
                .on("ended", function() {
                        console.log('video ended!')
                        if (!self.isCourse) {
                            self.addVideoAction('isComplete')
                        }
                    })
                this.isDataReady = true
            },
            async addVideoAction(type) {
                var params =  {
                    videoID: this.lectureData.id,
                    courseID: this.lectureData.course_id,
                    type: type // isComplete || progress
                }
                const resp = await this.$store.dispatch('courses/videoAction',params);
            },
             // add css class depend on the # of buttons
            moveCard(){
                if (!window.matchMedia("(max-width: 677px)").matches) {
                    if (document.querySelector(".course-card .box-details") && document.querySelector(".course-card .box-details").offsetHeight < 130) {
                        document.querySelector(".course-card").classList.add('active')
                    }
                } else {
                    document.querySelector(".course-card").classList.remove('active')
                }
            },
            async addToFavourite(event) {
                if (this.isLoggedIn) {
                    event.target.classList.toggle('active')
                    await this.$store.dispatch("courses/addToFavourite",{
                        courseID:this.getCourseID()
                    });
                    
                } else {
                    this.$store.commit('loginModal',true);
                }
                
            },
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
            isLoading(status) {
                this.$store.commit('isLoading',status)
            },
            showWatchCourseDialog(){
                this.infoModal.show = true
            },
            async getFreeCourse(){
                if (this.isLoggedIn) {
                    this.isLoading(true)
                    await this.$store.dispatch('courses/getFreeCourse',{
                        courseID: this.courseData.id
                    })
                    await this.$store.dispatch('courses/getAllCourses')
                    this.infoModal.isFixed = true;
                    this.isLoading(false)
                    this.setInfoModal('يمكنك البدء بالتعلم الآن','لقد أتممت التسجيل بنجاح' ,true,true,true)
                } else {
                    this.$store.commit('loginModal',true);
                }
            },
            async goToClassRoom(){
                const courseLectures = await this.$store.dispatch('courses/getCourseLectures',{
                    courseID: this.courseData.id
                })
                this.$router.replace(`/courses/${this.courseData.title.split(' ').join('-')}/${courseLectures[0].title.split(' ').join('-')}`)
            },
        },
        mounted() {
            this.getCourseData()
            if (!this.isCourse) {
                this.getLectureData()
            }
            this.initPlayer()
            setTimeout(() => {
                this.moveCard()
            },1000)
        },
        beforeDestroy() {
            document.querySelector('.vimeoPlayer').remove();
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
    height: 193px!important;
}

@media (min-width: 768px) {
    .course-card.active {
        top: 50px;
    }
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
        height: 197px!important;
    }
}

</style>
<style>
.video-js {
    height: 193px!important;
}
.video-js iframe {
    width: 100%;
    height: 100%;
}

@media (max-width: 767px) {
    .video-js {
        height: 210px!important;
    }
}
</style>
