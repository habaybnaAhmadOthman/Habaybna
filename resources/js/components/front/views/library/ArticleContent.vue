<template>
    <div class="">
        <div class="box mt-30 flex-wrap-p p-side-12-p">
            <div class=" content w-100-p">
                <h1 class="font-40 bold black font-28-p">{{title}}</h1>
                <div class="author-box bold mb-20 mt-10 d-flex align-center">
                    <!-- <img src="/images/test.jpg" class="object-fit rounded" width="40" height="40"> -->
                    <div class="mr-10">
                        <p class="font-14 main-color">{{author}}</p>
                        <p class="font-14 main-color">اختصاصية علاج طبيعي</p>
                    </div>
                </div>
                <div class="font-20 black-2 font-18-p pre-line li-auto" v-html="description"></div>
                <div class="tags mt-30 d-flex flex-wrap align-center" v-if="tags">
                    <p class="bold ml-20">السمات: </p>
                    <div class="gap-10 d-flex flex-wrap">
                        <Tag v-for="tag in tags.split('|')" :key="tag" :value="tag"></Tag>
                    </div>   
                </div>
            </div>
            <!-- <div class="left-side-col w-100-p mt-20-p">
                <div class="floating-ads">
                    <div class="shadow-2 radius-10 ad-box bg-yellow p-10 mpu">
                        ad 1 
                    </div>
                    <div class="shadow-2 radius-10 ad-box bg-soft p-10 mt-15 mpu">
                        ad 2
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
    import Tag from '../../layouts/Tag.vue'
    export default {
        props: ['title','author','description','tags'],
        components: {
            Tag,
        },
    }
</script>

<style scoped>
.main-img {
    max-height: 700px;
}
.floating-ads {
    position: sticky;
    top: 10px;
}
@media (max-width: 767px) { 

}
</style>