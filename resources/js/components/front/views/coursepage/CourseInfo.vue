<template>
    <div class="about-course p-side-12-p">
        <CourseInfoText :header="'نظرة عامة على الدورة'" :description="description"></CourseInfoText>
        <div class="mb-40 what-should-learn mt-20 mb-20-p">
            <h3 class="title-line font-27 mb-40 mb-20-p">ماذا سيتعلم المشاركون</h3>
            <div class="font-27 black-2 pt-20 pt-0-p font-20-p" v-html="whatShouldLearn"></div>
        </div>
    </div>
</template>

<script>
import CourseInfoText from './CourseInfoText.vue'
export default {
    props: ['courseName','description','lectures','documents','whatShouldLearn'],
    data(){
        return {
            showMore: false,
        }
    },
    methods: {
        showMoreLess() {
            this.showMore = !this.showMore
        }
    },
    components: {CourseInfoText}
}
</script>
<style scoped>
.learn-points p {
    width: 45%;
    margin-bottom: 30px;
    position: relative;
    display: flex;
}
.learn-points p:before {
    content:'-';
    margin-left: 5px;
}


[show-more-less] [less], .to-show, [show-more-less].active [more]  {
    display: none;
}
[show-more-less]:not(.active) .to-show:nth-child(-n+4),[show-more-less].active .to-show ,
[show-more-less].active [less]{
    display: block;
}
/* .course-lectures .btn {
    padding:8px;
} */
</style>