<template>
    <div class="banner relative overflow-hidden radius-12">
        <video ref="videoPlayer" class="video-js main-img w-100"></video>
        <div class="fav-box relative">
            <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-add.svg" class="add pointer"> 
            <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-added-offer.svg" class="remove pointer">
        </div>
    </div>
</template>
<script>
import videojs from 'video.js';
import 'video.js/dist/video-js.css'
export default {
    props: ['videoSrc','isFull'],
    data() {
        return {
            player: null,
            videoOptions: {
                muted: false,
				autoplay: true,
				controls: true,
				sources: [
					{
						src:
							"https://cms.habaybna.net/sites/default/files/2021-10/IEP%20Teaser%20%281%29.mp4",
						  type: "video/mp4"
					}
				],
                playbackRates: [0.7, 1.0, 1.5, 2.0],
			}
        }
    },
    computed: {
        fullContainer(){
            return !!!this.isFull 
        }
    },
    methods : {

    },
    mounted() {
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
.banner {
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
}
.fav-box .remove {
    position: absolute;
    right: 0;
    top: 0;
    opacity: 0;
    pointer-events: none;
}
.fav-box .add.active ~ .remove {
    opacity: 1;
    pointer-events: initial;
}
.fav-box {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1;
}
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