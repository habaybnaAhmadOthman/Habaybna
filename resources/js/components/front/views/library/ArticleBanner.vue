<template>
    <div class="banner mt-15 mt-0-p">
        <!-- <img class="w-100 main-img object-fit radius-10" :src="image" width="100%"> -->
        <!-- <iframe border="0" v-else-if="type == 'Video'" width="100%" class="w-100" controls :src="youtubeVideo"></iframe> -->
        <div class="d-flex space-between mt-15 align-center p-side-12-p">
            <div>
                <p v-if="created_at" class="font-18 bold gray font-16-p">تم النشر : <span class="">{{created_at.slice(0,10)}}</span></p>
            </div>
            <div class="d-flex">
                <div class="fav-box relative pointer shadow-2 ml-25" :class="{'active':is_liked}" @click="addToFavourite($event,id)"></div>
                <p class="align-center bold d-flex font-14-p font-20 pointer yellow" @click="openShareModal"><img class="ml-10 share-img" src="/images/share-color.svg" width="25" height="27" alt="" > مشاركة</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        emits: ['open-share-modal'],
        props: ['image','created_at','is_liked','id'],
        methods: {
            openShareModal(){
                this.$emit('open-share-modal')
            },
            async addToFavourite(event,id) {
                if (this.isLoggedIn) {
                    event.target.classList.toggle("active");
                    await this.$store.dispatch("content/addToFavourite", {id});
                } else {
                    this.$store.commit("loginModal", true);
                }
            },
        },
        computed: {
            // youtubeVideo(){
            //     if (this.video) {
            //         return 'https://www.youtube.com/embed/' + this.video.slice(this.video.lastIndexOf('/')+1)
            //     } return ''
            // },
            isLoggedIn() {
                return this.$store.getters["user/isLoggedIn"];
            },
        },
    }
</script>

<style scoped>
.main-img {
    max-height: 700px;
}
.fav-box {
    background-color: rgb(255 255 255);
    border-radius: 50%;
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
iframe {
    height: auto;
    width: 100%;
    height: 500px;
}
@media (max-width: 767px) {
    .share-img {
        width: 24px;
    }
    .main-img {
        height: calc(100vw * .625);
        border-radius: 0;
    }
    .fav-box {
        width: 33px;
        height: 33px;
    }
    iframe {
        height: auto;
        min-height: auto;
    }
}
</style>
