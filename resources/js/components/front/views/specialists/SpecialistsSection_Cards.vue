<template>
    <div class="specialists-list-section pb-30 pb-20-p">
        <div class="container">
            <div class="specialists-container">
                <template  v-if="data.length">
                    <ul class="specialists-list p-side-12-p grid-3 grid-1-p gap-20" :class="listClass">
                        <Card v-for="item in data" :key="item.id" :data="item"></Card>
                    </ul>
                    <div class="  w-50 d-flex justify-center m-side-auto  more w-100-p mt-20" v-if="showMoreCard">
                        <router-link to="/all-specialists" class="white-i relative radius-10 shadow flex-all relative next-arrow font-27 font-20-p h-100 d-block show-more-articles bg-blue w-100">إستعراض الأخصائيين</router-link>
                    </div>
                    <div v-if="!showMoreCard && canLoadData" class="load-more container shadow center bg-white radius-12 mt-30 d-flex align-center justify-center pt-30 pb-30 m-side-12-p">
                        <img src="/images/loader.gif" width="50" height="50" alt="loading" >
                    </div>
                </template>
                <h1 v-else class="center yellow ">لا يوجد أخصائيين</h1>
            </div>
        </div>
    </div>
</template>
<script>
import Card from "./HorizontalCard.vue"
export default {
    emits: ["load-more-data"],
    props: ["data","showMoreCard","list-class", "can-load-data","page"],
    components: {Card},
    data(){
        return {
            
        }
    },
    methods:{
        handleScroll(){
            var loadMoreEl = document.querySelector('.load-more');
            if (loadMoreEl && loadMoreEl.getBoundingClientRect().bottom < window.innerHeight && this.canLoadData) {
                const nextPage = this.page + 1
                this.$emit('load-more-data',nextPage)
            }
        },
    },
    mounted() {
        window.addEventListener('scroll',this.handleScroll)
    },
    destroyed(){
        window.removeEventListener('scroll',this.handleScroll)
    }
};
</script>

<style scoped>

.course-box.more {
    position: relative;
    min-height: 324px;
}
.show-more-articles {
    height: 120px;
}
.show-more-articles:before{
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
@media (max-width: 767px) {
    .show-more-articles {
        height: 40px;
    }
    .show-more-articles {
        width: calc(100% - 24px);
    }
}
</style>
