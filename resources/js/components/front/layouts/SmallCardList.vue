<template>
    <div class="small-card-list d-flex flex-wrap gap-20" :class="classList">
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <div class="show-more-articles bg-blue relative shadow w-31 radius-10 more w-100-p" v-if="showMoreCard">
            <router-link to="/library" class="white-i flex-all relative next-arrow font-27 h-100 d-block w-100">اكتشف المزيد</router-link>
        </div>
    </div>
</template>

<script>
import SmallCard from './SmallCard.vue'
export default {
    props: ['filtered-articles','showMoreCard','class-list'],
    components: {SmallCard},
    mounted(){
        console.log(this.showMoreCard)
    }
};
</script>

<style scoped>

.show-more-articles:before {
        content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url(/images/more-courses.png);
    mix-blend-mode: soft-light;
    position: absolute;
    pointer-events: none;
    background-position: top;
}
.next-arrow:after {
    content: '';
    background: url(/images/right-arrow-white.png) no-repeat;
    background-size: 15px 24px;
    background-position: center;
    width: 15px;
    height: 24px;
    position: absolute;
    left: 40px;
    top: 0;
    bottom: 0;
    margin: auto;
    transform: rotate(180deg);
}
</style>
