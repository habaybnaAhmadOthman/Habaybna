<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <div class="container">
            <ArticleBanner :is_liked="is_liked" :id="ID" @open-share-modal="showShareDialog" :image="mainImage" :created_at="created_at"></ArticleBanner>
            <ArticleContent v-if="isDataReady" :tags="tags" :title="title" :description="description" :author="author"></ArticleContent>
            <!-- <div class="mt-50">
                <AboutSpecialists :title="'بواسطة'" v-if="specialists" :specialists="specialists" :mo-title="true"></AboutSpecialists>
            </div> -->
            
            <div class="mt-60" v-if="isDataReady && relatedArticles.length > 0">
                <RelatedContent :data="relatedArticles"></RelatedContent>    
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
    import ArticleBanner from '../../views/library/ArticleBanner.vue'
    import ArticleContent from '../../views/library/ArticleContent.vue'
    import RelatedContent from '../../views/library/RelatedContent.vue'
    import AboutSpecialists from "../../views/coursepage/AboutSpecialists.vue";
    import TheFooter from '../../layouts/TheFooter.vue'
    import ShareArticleModal from '../../views/coursepage/ShareCourseModal.vue'
    export default {
        props: ['article'],
        components: { TheHeader,ArticleBanner,ArticleContent,AboutSpecialists,RelatedContent,TheFooter,ShareArticleModal},
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
            fixEmbedLinks(str){
                const startFrom =  str.indexOf('<figure');
                const endFrom =  str.indexOf('</oembed></figure>') + 18;
                if (startFrom > -1) {
                    const embedLinkTag = str.slice(startFrom,endFrom);
                    let urlOnly = embedLinkTag.slice(embedLinkTag.indexOf(`url="`) + 5)
                    const videoUrl = urlOnly.slice(0,urlOnly.indexOf(`"`)).replace('https://youtu.be/','https://www.youtube.com/embed/');
                    
                    str = str.replace(embedLinkTag,`<iframe width="560" height="315" src="${videoUrl}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`);
                    return this.fixEmbedLinks(str)
                }
                return str
            },
            async getPageData(){
                try {
                    let data = await this.$store.dispatch('content/getArticle',{title: this.article.split('-').join(' ')});
                    const {article} = data
                    this.author  = article.author;
                    this.description = this.fixEmbedLinks(article.content);
                    this.mainImage = article.cover_photo;
                    this.created_at = article.created_at;
                    this.is_liked = article.is_liked;
                    this.tags = article.intrests;
                    this.title = article.title;
                    this.ID = article.id;
                    if (data.relatedArticle && Object.keys(data.relatedArticle).length > 0) {
                        const relatedArr = []
                        for (const key in data.relatedArticle) {
                            data.relatedArticle[key].map(related=>{
                                if (related.article) {
                                    relatedArr.push ({
                                        id: related.article_id,
                                        title: related.article.title,
                                        created_at: related.article.created_at,
                                        cover_photo: related.article.cover_photo,
                                        without_like:true
                                    })
                                }
                            })
                        }
                        this.relatedArticles = relatedArr
                    }
                    this.isDataReady = true
                } catch(err) {
                    this.$router.push({name: 'errorPage'})
                }
            },
            showShareDialog() {
                this.showShareModal = !this.showShareModal;
            },
        },
        mounted(){
            console.log(this.$router.currentRoute)
            this.getPageData();
        },
        beforeRouteLeave (to, from,next) {
            const params = to.query;
            if (to.name == 'library' && params.newFilters && params.hasOwnProperty('filters')) {
                localStorage.setItem('new_filters','1');
                if (params.filters)
                    localStorage.setItem('prev_filters',params.filters)
                else
                    localStorage.removeItem('prev_filters')
            }
            next()
        },
    }
</script>

<style scoped>

</style>