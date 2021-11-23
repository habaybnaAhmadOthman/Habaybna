<template>
    <div>
        
        <LandingSection></LandingSection>
        <router-link to='/signup'>register</router-link>
        <button type='button' class='btn' @click="logout">تسجيل خروج</button>
        <HabaybnaLibrary></HabaybnaLibrary>
        <HabaybnaDirectory></HabaybnaDirectory>
    </div>
</template>

<script>
import LandingSection from "./../views/homepage/LandingSection.vue";
import HabaybnaLibrary from "./../views/homepage/HabaybnaLibrary.vue";
import HabaybnaDirectory from "./../views/homepage/HabaybnaDirectory.vue";
export default {
    components: { LandingSection, HabaybnaLibrary,HabaybnaDirectory },
    methods: { 
        async logout(){
            await this.$store.dispatch("user/logout");
            this.$router.replace("/");
        }
    }
};
</script>
