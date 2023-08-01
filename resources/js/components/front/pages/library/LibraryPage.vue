<template>
  <div class="library-page">
    <TheHeader></TheHeader>
    <CommunityBar></CommunityBar>
    <Banner></Banner>
    <div class="our-features">
      <div class="container p-side-12-p">
        <h2 class="main-color mb-20-p font-30 title-line mb-50 font-20-p">
          ما هي مميزات مكتبة حبايبنا.نت ؟
        </h2>
        <div class="features pt-15 d-flex space-between flex-wrap pt-0-p">
          <div
            class="box relative center w-25 p-side-10 p-side-15-p half-p radius-3-p"
          >
            <img
              src="/images/Icons Library/9.svg"
              width="250"
              height="150"
              class="mb-30 mt-15-p mb-15-p"
            />
            <p class="font-19 main-color font-15-p mb-15-p">
              تهم كل والدين وأساسية لتطور كل طفل
            </p>
          </div>
          <div
            class="box relative center w-25 p-side-10 p-side-15-p half-p radius-3-p"
          >
            <img
              src="/images/Icons Library/10.svg"
              width="250"
              height="150"
              class="mb-30 mt-15-p mb-15-p"
            />
            <p class="font-19 main-color font-15-p mb-15-p">
              فيديوهات قصيرة وسريعة وتغير حياتك و حياة طفلك
            </p>
          </div>
          <div
            class="box relative center w-25 p-side-10 p-side-15-p half-p radius-3-p"
          >
            <img
              src="/images/Icons Library/11.svg"
              width="250"
              height="150"
              class="mb-30 mt-15-p mb-15-p"
            />
            <p class="font-19 main-color font-15-p mb-15-p">
              يقدمها خبراء في مجالات متنوعة مرتبطة بتطور الطفل
            </p>
          </div>
          <div
            class="box relative center w-25 p-side-10 p-side-15-p half-p radius-3-p"
          >
            <img
              src="/images/Icons Library/12.svg"
              width="250"
              height="150"
              class="mb-30 mt-15-p mb-15-p"
            />
            <p class="font-19 main-color font-15-p mb-15-p">
              من الوقت والجهد والتفكير في البحث عن بدائل
            </p>
          </div>
        </div>
      </div>
    </div>
    <ContentSection :save-current-page="true"></ContentSection>
    <TheFooter></TheFooter>
  </div>
</template>

<script>
import TheHeader from "../../layouts/header/TheHeader.vue";
import CommunityBar from "../../layouts/habaybnacommunity/CommunityBar.vue";

import Banner from "../../views/library/MainBanner.vue";
import ContentSection from "../../views/library/ContentSection.vue";
import TheFooter from "../../layouts/TheFooter.vue";
export default {
  components: { CommunityBar, TheHeader, Banner, ContentSection, TheFooter },
  beforeRouteEnter(to, from, next) {
    const shouldGetFiltersFromPrevPage = localStorage.getItem("new_filters");
    if (!shouldGetFiltersFromPrevPage) {
      if (from.query.page) localStorage.setItem("prev_page", from.query.page);
      if (from.query.filters)
        localStorage.setItem("prev_filters", from.query.filters);
    } else {
      localStorage.removeItem("new_filters");
    }
    next((vm) => {
      vm.prevRoute = from;
    });
  },
};
</script>

<style scoped>
@media (max-width: 767px) {
  .box img {
    width: 100px;
    height: 100px;
  }
}
</style>
