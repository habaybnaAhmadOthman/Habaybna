<template>
    <div class="library-page">
        <TheHeader></TheHeader>
        <CommunityBar></CommunityBar>
        <Banner></Banner>
        <ContentSection :save-current-page="true"></ContentSection>
        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import TheHeader from '../../layouts/header/TheHeader.vue'
import CommunityBar from "../../layouts/habaybnacommunity/CommunityBar.vue";

    import Banner from '../../views/library/MainBanner.vue'
    import ContentSection from '../../views/library/ContentSection.vue'
    import TheFooter from '../../layouts/TheFooter.vue'
    export default {
        components: { CommunityBar,TheHeader,Banner,ContentSection,TheFooter},
        beforeRouteEnter(to, from, next) {
            const shouldGetFiltersFromPrevPage = localStorage.getItem('new_filters');
            if (!shouldGetFiltersFromPrevPage) {
                if (from.query.page)
                    localStorage.setItem('prev_page',from.query.page)
                if (from.query.filters)
                    localStorage.setItem('prev_filters',from.query.filters)
            } else {
                localStorage.removeItem('new_filters')
            }
            next((vm) => {
                vm.prevRoute = from;
            });
        }
    }
</script>

<style scoped>

</style>
