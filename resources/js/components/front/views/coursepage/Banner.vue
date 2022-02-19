<template>
    <!-- <div class="banner relative overflow-hidden radius-12">
        
        <div class="fav-box relative">
            <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-add.svg" class="add pointer"> 
            <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-added-offer.svg" class="remove pointer">
        </div>
    </div> -->
    <div class="banner relative">
        <div class="container h-100">
            <div class="d-flex h-100">
                <div class="d-flex align-center box h-100 relative w-70">
                    <h1 class="font-50 white bold pre-line">{{bannerTitle}}</h1>
                    <div class="d-flex details white font-20">
                        <p class="d-flex align-center ml-20"><img class="ml-10" src="/images/time-icon.svg" width="31" height="31" alt="">١٢ ساعة</p>
                        <p class="d-flex align-center ml-20"><img class="ml-10" src="/images/video-svgrepo.svg" width="39" height="34" alt="">٨ دروس</p>
                        <p class="d-flex align-center"><img class="ml-10" src="/images/share-icon.svg" width="34" height="36" alt="">مشاركة</p>
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
    props: ['videoSrc', 'bannerTitle'],
    components: {CoboneCard}
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






/* .banner {
    height:415px;
}
.banner:after  {
    content: '';
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0.98;
    pointer-events: none;
    background: rgb(0 0 0 / 20%);
    pointer-events: none;
} */
.vjs_video_3-dimensions {
    height: 100%;
}
</style>
<style>
.vjs-big-play-button {
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 0;
    bottom: 0;
}

</style>