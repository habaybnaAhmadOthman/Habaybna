<template>
    <div>
        <LandingSection></LandingSection>
        <HabaybnaLibrary></HabaybnaLibrary>
    </div>
</template>

<script>
import LandingSection from "./../views/homepage/LandingSection.vue";
import HabaybnaLibrary from "./../views/homepage/HabaybnaLibrary.vue";
export default {
    components: { LandingSection, HabaybnaLibrary }
};
</script>
