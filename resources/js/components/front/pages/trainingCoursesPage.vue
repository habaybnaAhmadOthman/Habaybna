<template>
    <div>
        <TheHeader></TheHeader>
        <CoursesSection></CoursesSection>
    </div>
</template>

<script>
import TheHeader from '../layouts/header/TheHeader.vue';
import CoursesSection from "../views/homepage/CoursesSection.vue";
export default {
    components: { CoursesSection,TheHeader }
};
</script>