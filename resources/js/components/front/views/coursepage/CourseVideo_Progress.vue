<template>
    <div class="course-progress-controls pt-20 w-100 mb-15">
        <div class="d-flex box space-between">
            <div class="controls d-flex align-center">
                <router-link class="d-flex align-center btn-white ml-25" to="/"><img width="21" height="22" src="https://www.arabiaweather.com/farms/assets/images/favourite-add.svg" class="next ml-5"> الدرس التالي </router-link>
                <router-link class="d-flex align-center btn-white" to="/"><img width="21" height="22" src="https://www.arabiaweather.com/farms/assets/images/favourite-added-offer.svg" class="prev ml-5"> الدرس السابق </router-link>
            </div>
            <div class="progress-box d-flex align-center w-40">
                <span class="progress-bar flex-1 relative ltr ml-20"><span class="current main-bg d-block h-100 radius-12 w-50"></span></span>
                <span class="status main-color font-24">50%</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            showMore: false,
        }
    },
    methods: {
        showMoreLess() {
            this.showMore = !this.showMore
        }
    }
}
</script>
<style scoped>
[show-more-less] [less], .to-show, [show-more-less].active [more]  {
    display: none;
}
[show-more-less]:not(.active) .to-show:nth-child(-n+4),[show-more-less].active .to-show ,
[show-more-less].active [less]{
    display: block;
}
.course-lectures .btn {
    padding:8px;
}
.btn-white {
    background:#fff;
    color:#7C267C;
    transition: all 0.3s;
    border: 1px solid #7C267C;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 12px;
    padding: 3px 10px 3px 10px;
}
.progress-bar {
    border: 2px solid #707070;
    border-radius: 27px;
    height:14px;
}
</style>