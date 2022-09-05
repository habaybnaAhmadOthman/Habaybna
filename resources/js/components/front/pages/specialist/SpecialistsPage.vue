<template>
    <div class="ask-specialists-page">
        <TheHeader></TheHeader>
            <div class="mb-70">
                <MainBanner></MainBanner>
            </div>
            <div class="mb-40 mb-70">
                <Benefits></Benefits>
            </div>
            <div class="mb-50">
                <RequestSteps></RequestSteps>
            </div>
            <div class="pt-20 mb-50 mb-10-p pt-0-p">
                <SpecialistsSection :show-title="true" :showMoreCard="true"></SpecialistsSection>
            </div>
            <div class="container center mb-30-p">
                <h6 class="m-side-auto font-22 black-2 w-90-p font-16-p pt-0-p pt-15">هل تحتاج لمساعدة في تحديد الأخصائي المناسب؟ </h6>
                <div class="d-flex flex-colmn justify-center">
                    <router-link class="font-22 blue do" to="/" @click.native="goToContactForm">تواصل مع فريق حبايبنا.نت</router-link>
                    <a class="blue-3 mo font-22 font-16-p" href="https://api.whatsapp.com/send?phone=+962799760238" data-action="share/whatsapp/share" target="_blank">تواصل مع فريق حبايبنا.نت</a>
                </div>
                
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
            },
            goToContactForm() {
                window.scrollTo(0, document.querySelector('.contact-us-section').offsetTop - 50)
            }
        }
    }
</script>
<style scoped>
h1 {
    font-size: 100px;
}
</style>
