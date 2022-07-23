<template>
    <UserProfileContent>
        <template #page-header>
            <h1>المقالات المفضلة</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50 pt-25-p">
                <div class="grid-2 gap2 grid-1-p" v-if="articles.length > 0">
                    <SmallCard v-for="(item) in articles" :key="item.id" :item="item"></SmallCard>
                </div>
                <div class="portal-pagination mt-40 mt-40 justify-center d-flex">
                    <Pagination
                    :data="contentTemp"
                    @pagination-change-page="getPageDate"
                    :limit="1"
                    ></Pagination>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../views/userprofile/UserProfile_Content.vue";
import SmallCard from "../../layouts/SmallCard.vue";
import LaravelVuePagination from "laravel-vue-pagination";
export default {    
    components: {UserProfileContent,SmallCard,Pagination: LaravelVuePagination},
    data(){
        return {
            contentTemp: {},
            articles: []
        }
    },
    created(){
        this.getPageDate()
    },
    methods:{
        async getPageDate(page){
            if (typeof page === "undefined") {
                page = 1;
            }
            this.isLoading(true)
            if (this.listApi)
            getDataFrom = this.listApi
            const resp = await this.$store.dispatch(`content/getLikedArticles`,{page})
            this.isLoading(false)
            this.contentTemp = resp
            this.articles = resp.data.map((article)=>{
                const data = article.articles
                return {
                    id: article.article_id,
                    title: data.title,
                    created_at: data.created_at,
                    cover_photo: data.cover_photo,
                    is_liked: true
                }
            });
        },
        isLoading(status) {
            this.$store.commit('isLoading',status)
        },
    }
};
</script>

