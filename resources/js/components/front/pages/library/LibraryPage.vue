<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <Banner></Banner>
        <ContentSection :save-current-page="true"></ContentSection>
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
        beforeRouteEnter(to, from, next) {
            if (from.query.page)
                localStorage.setItem('prev_page',from.query.page)
            next((vm) => {
                vm.prevRoute = from;
            });
        }
    }
</script>

<style scoped>

</style>