<template>
    <div class="ask-specialists-page">
        <TheHeader></TheHeader>
            <div class="mb-20 mb-30-p">
                <MainBanner></MainBanner>
            </div>
            <div class="mb-40">
                <Benefits></Benefits>
            </div>
            <div class="mb-50">
                <RequestSteps></RequestSteps>
            </div>
            <div class="pt-20 mb-50 mb-10-p pt-0-p">
                <SpecialistsSection :show-title="true" :showMoreCard="true"></SpecialistsSection>
            </div>
            <div class="container center">
                <h6 class="m-side-auto font-30 black-2 w-50 w-90-p font-20-p pt-0-p pt-15">تحتاجون لمساعدة في الاختيار من الأخصائيين؟ يمكنكم التواصل مع فریق حبایبنا</h6>
            </div>

        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import MainBanner from '../../views/specialists/MainBanner.vue'
    import Benefits from '../../views/specialists/Benefits.vue'
    import RequestSteps from '../../views/specialists/RequestSteps.vue'
    import SpecialistsSection from '../../views/specialists/SpecialistsSection.vue'


    import TheHeader from '../../layouts/header/TheHeader.vue';
    import TheFooter from '../../layouts/TheFooter.vue';
    export default {
        components: { TheHeader,TheFooter,MainBanner,Benefits,RequestSteps,SpecialistsSection},
        methods: {
            goToLink(url) {
                window.open(url,'_blank')
            }
        }
    }
</script>
<style scoped>
h1 {
    font-size: 100px;
}
</style>
