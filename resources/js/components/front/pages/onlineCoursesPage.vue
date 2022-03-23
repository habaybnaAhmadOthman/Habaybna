<template>
    <div>
        <TheHeader></TheHeader>
        <Banner></Banner>
        <section class="learn-section pt-45 pt-20-p">
            <CoursesFeatures></CoursesFeatures>
            <CoursesSection :cardsCount="5" :showMoreCard="true"></CoursesSection>
            
        </section>
        <CombaniesBanner></CombaniesBanner>
        <div class="mt-30">
            <TheFooter></TheFooter>
        </div>
        
    </div>
</template>

<script>
import TheHeader from '../layouts/header/TheHeader.vue';
import Banner from '../views/onlinecourses/CoursesSection_Banner.vue'
import CoursesFeatures from '../views/onlinecourses/CoursesFeatures.vue'
import CombaniesBanner from '../layouts/CompaniesBanner.vue'

import TheFooter from '../layouts/TheFooter.vue';
import CoursesSection from "../views/onlinecourses/CoursesSection.vue";
export default {
    components: { CoursesSection,TheFooter,Banner,CombaniesBanner,CoursesFeatures,TheHeader }
};
</script>