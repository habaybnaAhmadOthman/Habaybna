<template>
    <div class="course-card w-30 radius-10 overflow-hidden bg-white relative">
        <figure class="d-flex relative overflow-hidden radius-10 figure-box">
            <div class="fav-box relative pointer"></div>
            <video ref="videoPlayer" class="video-js main-img w-100"></video>
        </figure>
        <div class="d-flex box-details flex-wrap">

            <!-- for course page -->
            <template v-if="isCourse">
                <button @click="checkLogin" class="btn-register-now white-i font-18 mb-20 bold flex-all w-100 pointer">إشترك الآن</button>
                <form @submit.prevent="submitCoubon" class="cobone-form relative d-flex w-100">
                    <input type="text" v-model="promoCode" class="w-80 cobone-input" placeholder="هل لديك كوبون أو قسيمة شرائية استخدمها الآن ؟">
                    <input type="submit" value="" class="apply-cobone w-10 pointer">
                </form>
                <PaymentForm v-if="paymentFormData" :paymentData="paymentFormData" @clearPaymentData="clearPaymentData"></PaymentForm>
            </template>
            <!-- for lesson page -->
            <div v-else class="w-100">
                <router-link class="btn-register-now white-i font-18 bold flex-all w-100 pointer mb-20 next-arrow relative" to="/courses/3/2"> التالي</router-link>
                <router-link class="btn-register-now white-i font-18 bold flex-all w-100 pointer relative prev-arrow" to="/"> السابق</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import videojs from 'video.js';
    import 'video.js/dist/video-js.css'

    import PaymentForm from './PaymentForm.vue'
    export default {
        props: ['videoSrc'],
        components: {PaymentForm},
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
                promoCode: '',
            }
        },
        methods: {
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
                    const resp = await this.$store.dispatch('courses/buyCourse',{courseID:this.getCourseID()});
                    this.paymentFormData = resp.SmartRouteParams

                } catch (error) {
                    this.$store.commit('alertDialogMsg',error.message);
                }
                this.isLoading(false)
            },
            async submitCoubon() {
                if (!this.isLoggedIn) {
                    this.$store.commit('loginModal',true);
                    return false;
                }
                if (this.promoCode == '') {
                    this.$store.commit('alertDialogMsg','يرجى إدخال كود الخصم')
                    return false;
                }
                let checkPromoCode
                this.isLoading(true)
                try {
                    checkPromoCode = await this.$store.dispatch('courses/promoCode',{courseID:this.getCourseID(),promoCode:this.promoCode, usage:'Course'});
                } catch (error) {
                    console.log(error)
                }
                this.isLoading(false)
                var dialogMsg = 'success!'
                if (!checkPromoCode) {
                    dialogMsg = 'We are sorry!'
                }
                this.$store.commit('alertDialogMsg',dialogMsg)
            },
            getCourseID(){
                return this.$store.getters["courses/course"].id
            },
            isLoading(status) {
                this.$store.commit('isLoading',status)
            }
        },
        mounted() {
            this.videoOptions.sources[0].src =  this.videoSrc
            this.player = videojs(this.$refs.videoPlayer, this.videoOptions, function onPlayerReady() {
                console.log('onPlayerReady', this);
            })
            this.player.on('ready', function() {
                // this.addClass('my-example');
            });
            this.player.on('ended', function() {
                console.log('endddd');
            });
            // this.player.controlBar.progressControl.disable()
        },
        beforeDestroy() {
            if (this.player) {
                this.player.dispose()
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
.course-card {
    box-shadow: 0px 3px 6px #00000029;
    align-self: end;
    top: 170px;
}
.cobone-form {
    height: 60px;
}
.cobone-input {
    border: 1px solid #939598;
    border-radius: 0 25px 25px 0;
    color: #939598;
    font-size: 12px;
    padding: 20px 8px;
}
.apply-cobone {
    background-color: #632F63;
    position: relative;
    border-radius: 25px 0 0 25px;
    border: 0;
    width: 20%;
    background-image: url(/images/arrow-left.svg);
    background-repeat: no-repeat;
    background-position: center;
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
    z-index: 1;
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
.video-js {
    height: 250px;
}
.next-arrow:after, .prev-arrow:after {
    content:'';
    background:url(/images/right-arrow-white.png) no-repeat;
    background-size: 15px 24px;
    background-position: center;
    width: 15px;
    height: 24px;
    position: absolute;
    right: 40px;
    top: 0;
    bottom: 0;
    margin: auto;
}
.prev-arrow:after {
    right: auto;
    left: 40px;
    transform: rotate(180deg);
    background:url(/images/arrow-right-color.svg) no-repeat;
    background-size: cover;
}
.prev-arrow {
    background: transparent;
    border: 1px solid #939598;
    color: #363636!important;
}
</style>
<style>
.vjs-big-play-button {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:  url(/images/play-icon.svg)!important;
    background-repeat: no-repeat!important;
    background-size: 84px 84px!important;
    background-position: center center!important;
    border: none !important;
    box-shadow: none !important;
    height: 84px!important;
    width: 84px!important;
}
.video-js .vjs-big-play-button {
    background-color:transparent !important;
}
.vjs-big-play-button:before, .video-js .vjs-big-play-button .vjs-icon-placeholder:before {
    content: ""!important;
    display: none;
}
</style>
