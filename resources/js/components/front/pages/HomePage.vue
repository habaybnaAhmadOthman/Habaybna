<template>
    <div>
        <TheHeader></TheHeader>
        <LandingSection></LandingSection>
        <CoursesSection></CoursesSection>
        <HabaybnaLibrary></HabaybnaLibrary>
        <HabaybnaDirectory></HabaybnaDirectory>
    </div>
</template>

<script>
import TheHeader from '../layouts/header/TheHeader.vue';
import LandingSection from "../views/homepage/LandingSection.vue";
import HabaybnaLibrary from "../views/homepage/HabaybnaLibrary.vue";
import HabaybnaDirectory from "../views/homepage/HabaybnaDirectory.vue";
import CoursesSection from "../views/onlinecourses/CoursesSection.vue";
export default {
    components: { LandingSection, HabaybnaLibrary,HabaybnaDirectory,CoursesSection,TheHeader }
};
</script>
