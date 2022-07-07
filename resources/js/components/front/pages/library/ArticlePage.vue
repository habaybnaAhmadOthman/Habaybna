<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <ArticleBanner @open-share-modal="showShareDialog" :image="mainImage" :date="date"></ArticleBanner>
            <ArticleContent :tags="tags" :title="title" :description="description" :author="author"></ArticleContent>
            <!-- <div class="mt-50">
                <AboutSpecialists :title="'بواسطة'" v-if="specialists" :specialists="specialists" :mo-title="true"></AboutSpecialists>
            </div> -->
            <!-- <div class="mt-60">
                <RelatedCourses :title="`دورات تدريب ذات صلة`" v-if="isDataReady"></RelatedCourses>
            </div> -->
        </div>
        <TheFooter></TheFooter>
        <ShareArticleModal
            :show="showShareModal"
            @close-share-modal="showShareDialog"
            :courseName="title"
            :description="description | stripHTML"
            portal="article-share"
        ></ShareArticleModal>
        <portal-target name="article-share"></portal-target>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
    import ArticleBanner from '../../views/library/ArticleBanner.vue'
    import ArticleContent from '../../views/library/ArticleContent.vue'
    import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
    import RelatedCourses from "../../views/coursepage/RelatedCourses.vue";
    import TheFooter from '../../layouts/TheFooter.vue'
    import ShareArticleModal from '../../views/coursepage/ShareCourseModal.vue'
    export default {
        props: ['article'],
        components: { TheHeader,ArticleBanner,ArticleContent,AboutSpecialists,RelatedCourses,TheFooter,ShareArticleModal},
        data(){
            return {
                author: {},
                description: null,
                mainImage: null,
                date: null,
                title: null,
                tags: null,
                showShareModal: false,
                isDataReady:false,
            }
        },
        methods: { 
            async getPageData(){
                let data = await this.$store.dispatch('content/getArticle',{title: this.article.split('-').join(' ')});
                this.author  = data.author;
                this.description = data.content;
                this.mainImage = data.cover_photo;
                this.date = data.created_at;
                this.tags = data.intrests;
                this.title = data.title;
                this.isDataReady = true
                console.log(data)
            },
            showShareDialog() {
                this.showShareModal = !this.showShareModal;
            },
        },
        mounted(){
            this.getPageData();
        }
    }
</script>

<style scoped>

</style>