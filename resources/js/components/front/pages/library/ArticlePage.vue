<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <ArticleBanner></ArticleBanner>
            <ArticleContent></ArticleContent>
            <div class="mt-50">
                <AboutSpecialists :title="'بواسطة'" v-if="specialists" :specialists="specialists" :mo-title="true"></AboutSpecialists>
            </div>
            <div class="mt-60">
                <RelatedCourses :title="`دورات تدريب ذات صلة`" v-if="isDataReady"></RelatedCourses>
            </div>
        </div>
        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
    import ArticleBanner from '../../views/library/ArticleBanner.vue'
    import ArticleContent from '../../views/library/ArticleContent.vue'
    import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
    import RelatedCourses from "../../views/coursepage/RelatedCourses.vue";
    import TheFooter from '../../layouts/TheFooter.vue'
    export default {
        components: { TheHeader,ArticleBanner,ArticleContent,AboutSpecialists,RelatedCourses,TheFooter},
        data(){
            return {
                specialists:null,
                isDataReady:false,
            }
        },
        methods: { 
            async getPageData(){
                let data = await this.$store.dispatch('courses/getCourseDetails','فيصلي');
                this.specialists  = data.providers;
                this.isDataReady = true
            }
        },
        mounted(){
            this.getPageData();
        }
    }
</script>

<style scoped>

</style>