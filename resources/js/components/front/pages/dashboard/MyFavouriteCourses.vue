<template>
    <UserProfileContent>
        <template #page-header>
            <h1>الكورسات المفضلة</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50 pt-25-p">
                <div class="">
                    <div class="">
                        <CoursesList @updateFavouriteCoursesList="getCourses" :with-favourite="true" :filtered-courses="courseTemp" :showMoreCard="false" ></CoursesList>
                    </div>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../views/userprofile/UserProfile_Content.vue";
import CoursesList from '../../views/userprofile/mycourses/CoursesList.vue'
export default {    
    components: {UserProfileContent,CoursesList},
    data(){
        return {
            courseTemp: []
        }
    },
    created(){
        this.getCourses();
    },
    methods:{
        async getCourses() {
            this.courseTemp = await this.$store.dispatch('courses/getMyFavourites');
        }
    }
};
</script>

