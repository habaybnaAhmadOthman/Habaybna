<template>
  <div class="all-courses-page">
    <TheHeader></TheHeader>
    <section
      class="specialist-section pt-50 container pt-20-p mb-30 p-side-12-p"
    >
      <h1 class="main-color bold font-27 mb-30">الأخصائيين</h1>
      <div
        class="
          radius-12
          p-side-30
          w-32 w-100-p
          price-box
          bg-white
          d-flex
          align-center
          space-between
        "
      >
        <p class="font-20 main-color bold d-flex align-center">
          <img
            class="ml-10"
            src="/images/coin-icon.png"
            width="30"
            height="30"
            alt="الأخصائيين"
          /><span class="top-2"> USD 54</span>
        </p>
        <p class="font-20 main-color bold d-flex align-center">
          <img
            class="ml-10"
            src="/images/time-icon.png"
            width="30"
            height="30"
            alt="الأخصائيين"
          /><span class="top-2"> 30 دقيقة</span>
        </p>
      </div>
      <div
        class="
          radius-12
          bg-white
          d-flex
          align-center
          space-between
          mt-10
          p-10
          w-32 w-100-p

        "
      >
        <p class="font-20" style="textAlign:center">
          <!-- <img
            class="ml-10"
            src="/images/coin-icon.png"
            width="30"
            height="30"
            alt="الأخصائيين"
          /> -->
          لأنكم حبايبنا نهديكم خصم 35% عند استخدام الكود:
          <span class="d-block font-22 main-color bold pt-15 pb-15">Hellohabaybna22</span>
          <ul style="textAlign:right">
              <li style="list-style:inside; vertical-align: middle;">صالح خلال أكتوبر ونوفمبر 2022</li>
              <li style="list-style:inside; vertical-align: middle;">يمكن استخدام الكود أكثر من مرة</li>
          </ul>
        </p>
      </div>
    </section>
    <SpecialistsSection :list-only="false"></SpecialistsSection>

    <div class="mt-30">
      <TheFooter></TheFooter>
    </div>
  </div>
</template>

<script>
import TheHeader from "../../layouts/header/TheHeader.vue";
import SpecialistsSection from "../../views/specialists/SpecialistsSection.vue";
import TheFooter from "../../layouts/TheFooter.vue";
export default {
  components: { TheFooter, TheHeader, SpecialistsSection },
};
</script>

<style scoped>
.price-box {
  height: 76px;
}
</style>
