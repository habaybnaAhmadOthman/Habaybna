<template>
    <div class="all-courses-page">
        <TheHeader></TheHeader>
        <section class="specialist-section pt-50 container pt-20-p mb-30 p-side-12-p">
            <h1 class="main-color bold font-27 mb-30">الأخصائيين</h1>
            <div class="radius-12 p-side-30 w-32 w-100-p price-box bg-white d-flex align-center space-between">
                <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> USD 59</span></p>
                <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> 30 دقيقة</span></p>
            </div>
        </section>

        <SpecialistsSection :list-only="false"></SpecialistsSection>

        <div class="mt-30">
            <TheFooter></TheFooter>
        </div>
        
    </div>
</template>

<script>
import TheHeader from '../../layouts/header/TheHeader.vue';
import SpecialistsSection from '../../views/specialists/SpecialistsSection.vue'
import TheFooter from '../../layouts/TheFooter.vue';
export default {
    components: { TheFooter,TheHeader ,SpecialistsSection}
};
</script>

<style scoped>
.price-box {
    height: 76px;
}
</style>