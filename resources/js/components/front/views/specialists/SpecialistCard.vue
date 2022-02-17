<template>
    <div class="specialist-card bg-white shadow pt-20 pb-30 radius-10" :class="{'active':!showMore}">
        <figure class="d-flex center">
            <img src="/images/test.jpg" class="rounded m-side-auto object-fit" width="170" height="170" alt="">
        </figure>
        <div class="details">
            <p class="black-2 mt-20 font-22 bold mb-15 center">محمود الشياب</p>
            <p class="regular font-22 black-2 mb-15 desc">اختصاصي تحليل السلوك تطبيقي المعتمد دوليا -BCBA اختصاصي تحليل السلوك تطبيقي المعتمد دوليا -BCBA اختصاصي تحليل السلوك تطبيقي المعتمد دوليا -BCBA اختصاصي تحليل السلوك تطبيقي المعتمد دوليا -BCBA اختصاصي تحليل السلوك تطبيقي المعتمد دوليا -BCBA</p>
        </div>
        <div class="d-flex flex-end p-side-30">
            <span class="yellow font-20 bold pointer" @click="showMoreFn" v-if="showMore">المزيد</span>
            <span class="yellow font-20 bold pointer" @click="showMoreFn" v-else>أقل</span>
            
        </div>
    </div>
</template>

<script>
    export default {
        data:()=> ({
            showMore: true
        }),
        methods: {
            showMoreFn(){
                this.showMore = !this.showMore
            }
        }
    }
</script>

<style scoped>
.details {
    padding-left: 40px;
    padding-right: 40px;
}
.specialist-card {
    align-self: baseline;
}
.desc {
    max-height: 66px;
    overflow: hidden;
}
.desc {
    max-height: 66px;
    overflow: hidden;
}
.specialist-card.active .desc {
    max-height: inherit;
}
</style>