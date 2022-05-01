<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <Banner></Banner>
        <ContentSection></ContentSection>
        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
    import Banner from '../../views/library/MainBanner.vue'
    import ContentSection from '../../views/library/ContentSection.vue'
    import TheFooter from '../../layouts/TheFooter.vue'
    export default {
        components: { TheHeader,Banner,ContentSection,TheFooter},
    }
</script>

<style scoped>

</style>