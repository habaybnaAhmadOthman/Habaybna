<template>
    <div class="homepage">
        <TheHeader></TheHeader>
        <LandingSection></LandingSection>
        <div class="mt-50">
            <IconsSection></IconsSection>
        </div>
        <div class="mt-50">
            <CoursesSection :cardsCount="5" :showMoreCard="true"></CoursesSection>
        </div>
        <Articles :cardsCount="5" :showMoreCard="true" :title="true" :list-only="true"></Articles>
        <div class="mt-50">
            <HabaybnaMedia></HabaybnaMedia>
        </div>
        <div class="mt-50">
            <ContactUS></ContactUS>
        </div>
        <div class="mt-50">
            <!-- <Partners></Partners> -->
        </div>
        <TheFooter></TheFooter>
    </div>
</template>

<script>
import TheHeader from '../layouts/header/TheHeader.vue';
import TheFooter from '../layouts/TheFooter.vue';
import LandingSection from "../views/homepage/LandingSection.vue";
import IconsSection from "../views/homepage/iconsSection.vue";
import CoursesSection from "../views/onlinecourses/CoursesSection.vue";
import Articles from '../views/library/ContentSection.vue'
import HabaybnaMedia from '../views/custom/HabaybnaMedia.vue'
import ContactUS from '../views/custom/ContactUS.vue'
import Partners from '../views/custom/Partners.vue'
export default {
    components: { LandingSection,IconsSection, Articles,CoursesSection,TheHeader,Partners ,HabaybnaMedia,ContactUS,TheFooter}
};
</script>
