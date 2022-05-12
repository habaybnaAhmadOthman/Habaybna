<template>
    <div class="terms-page">
        <TheHeader />
        <div class="container mt-20 p-side-12-p">
            <h2 class="title-line font-27 mb-40">التغطية الإعلامية</h2>
            <h6 class="font-20 black mb-30">
                يمكنكم التعرف أكثر على منصة حبايبنا.نت من خلال زاويتنا
                الإعلامية:
            </h6>
            <div class="media-wrapper">
                <router-link :to="item.url" class="media-content d-flex flex-wrap" v-for="item,index in media" :key="index">
                    <div class="media-img w-100-p justify-center-p">
                        <img
                            :src="item.image"
                            alt="media-img"
                        />
                    </div>
                    <div  class="body1 w-100-p font-20 center-p pt-10">
                        <p>{{item.title}}</p>
                    </div>
                </router-link>
            </div>
        </div>
        <TheFooter />
    </div>
</template>

<script>
import TheHeader from "../layouts/header/TheHeader.vue";

import TheFooter from "../layouts/TheFooter.vue";
export default {
    components: { TheHeader, TheFooter },
    data(){
        return {
            media:[]
        }
    },
    async created(){
        this.media = await this.$store.dispatch('content/getMedia');
    }
};
</script>
<style scoped>
.media-content {
    margin-bottom: 40px;
}
.media-img {
    width: 33.3333333%;
    display: flex;
}
.media-img img{
    max-width: 200px;
}
.body1 {
    width: 33.3333333%;
}

</style>


