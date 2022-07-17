<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <ArticleBanner :is_liked="is_liked" :id="ID" @open-share-modal="showShareDialog" :image="mainImage" :created_at="created_at"></ArticleBanner>
            <ArticleContent v-if="isDataReady" :tags="tags" :title="title" :description="description" :author="author"></ArticleContent>
            <!-- <div class="mt-50">
                <AboutSpecialists :title="'بواسطة'" v-if="specialists" :specialists="specialists" :mo-title="true"></AboutSpecialists>
            </div> -->
            <div class="mt-60" v-if="relatedArticles.length > 0">
                <div class="grid-2 gap2 grid-1-p">
                    <SmallCard v-for="(item) in relatedArticles" :key="item.id" :item="item"></SmallCard>
                </div>
            </div>
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
    import SmallCard from '../../layouts/SmallCard.vue'
    import ArticleBanner from '../../views/library/ArticleBanner.vue'
    import ArticleContent from '../../views/library/ArticleContent.vue'
    import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
    import TheFooter from '../../layouts/TheFooter.vue'
    import ShareArticleModal from '../../views/coursepage/ShareCourseModal.vue'
    export default {
        props: ['article'],
        components: { TheHeader,ArticleBanner,ArticleContent,AboutSpecialists,SmallCard,TheFooter,ShareArticleModal},
        data(){
            return {
                author: {},
                description: null,
                mainImage: null,
                created_at: null,
                title: null,
                tags: null,
                showShareModal: false,
                isDataReady:false,
                is_liked: false,
                ID: null,
                relatedArticles: []
            }
        },
        methods: { 
            async getPageData(){
                let data = await this.$store.dispatch('content/getArticle',{title: this.article.split('-').join(' ')});
                const {article} = data
                this.author  = article.author;
                this.description = article.content;
                this.mainImage = article.cover_photo;
                this.created_at = article.created_at;
                this.is_liked = article.is_liked;
                this.tags = article.intrests;
                this.title = article.title;
                this.ID = article.id;
                if (data.relatedArticle && Object.keys(data.relatedArticle).length > 0) {
                    this.relatedArticles = data.relatedArticle[Object.keys(data.relatedArticle)[0]].slice(0,4).map(related=>{
                        return {
                            id: related.article_id,
                            title: related.article.title,
                            created_at: related.article.created_at,
                            image: related.article.cover_photo,
                            without_like:true
                        }
                    })
                }
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