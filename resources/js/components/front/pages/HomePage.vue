<template>
    <div>
        <LandingSection></LandingSection>
        <CoursesSection></CoursesSection>
        <HabaybnaLibrary></HabaybnaLibrary>
        <HabaybnaDirectory></HabaybnaDirectory>
    </div>
</template>

<script>
import LandingSection from "./../views/homepage/LandingSection.vue";
import HabaybnaLibrary from "./../views/homepage/HabaybnaLibrary.vue";
import HabaybnaDirectory from "./../views/homepage/HabaybnaDirectory.vue";
import CoursesSection from "../views/homepage/CoursesSection.vue";
export default {
    components: { LandingSection, HabaybnaLibrary,HabaybnaDirectory,CoursesSection }
};
</script>
