<template>
    <UserProfileContent>
        <template #page-header>
            <h1>المقالات المفضلة</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50">
                <div class="">
                    <div class="">
                        <!-- <Articles :class-list="'two-card p-side-10'" :list-only="true" /> -->
                        <Articles :list-api="'getLikedArticles'" :class-list="'two-card p-side-10'" :list-only="true" />
                    </div>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../views/userprofile/UserProfile_Content.vue";
import Articles from '../../views/library/ContentSection.vue'
export default {    
    components: {UserProfileContent,Articles},
    data(){
        return {
            
        }
    },
    created(){
        
    },
    methods:{

    }
};
</script>

