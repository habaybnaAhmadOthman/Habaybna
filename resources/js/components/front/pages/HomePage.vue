<template>
  <div class="homepage">
    <TheHeader></TheHeader>
    <LandingSection></LandingSection>
    <div class="mt-50">
      <IconsSection></IconsSection>
    </div>
    <div
      class="video-box relative w-55 mt-20-p w-100-p p-side-12-p m-side-auto"
    >
      <iframe
        class="video-box-home"
        src="https://www.youtube.com/embed/4VsdSsLT_BI"
        title="تجربة أبوين مع طفلهما المتأخرين في الكلام والتطور دفعتهما لتطوير منصة حبايبنا.نت"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      ></iframe>
    </div>
    <div class="mt-50 mobile-statistic">
      <img src="images/siteImgs/statisticmobile.png" alt="" />
    </div>
    <div class="statistic">
      <img src="images/siteImgs/statistics.png" alt="" />
    </div>
    <div class="">
      <CoursesSection :cardsCount="5" :showMoreCard="true"></CoursesSection>
    </div>
    <Articles
      :cardsCount="5"
      :showMoreCard="true"
      :title="true"
      :list-only="true"
    ></Articles>
    <div class="mt-50">
      <Testimonials
        type="course"
        title="ماهو رأي مستخدمي حبايبنا.نت؟"
      ></Testimonials>
    </div>
    <div class="mt-50">
      <HabaybnaMedia></HabaybnaMedia>
    </div>
    <div class="mt-50">
      <ContactUS></ContactUS>
    </div>
    <div class="mt-50">
      <!-- <Partners></Partners> -->
    </div>
    <TheFooter></TheFooter>
  </div>
</template>

<script>
import TheHeader from "../layouts/header/TheHeader.vue";
import TheFooter from "../layouts/TheFooter.vue";
import LandingSection from "../views/homepage/LandingSection.vue";
import IconsSection from "../views/homepage/iconsSection.vue";
import CoursesSection from "../views/onlinecourses/CoursesSection.vue";
import Articles from "../views/library/ContentSection.vue";
import HabaybnaMedia from "../views/custom/HabaybnaMedia.vue";
import ContactUS from "../views/custom/ContactUS.vue";
import Partners from "../views/custom/Partners.vue";
import Testimonials from "../views/custom/Testimonials.vue";
export default {
  components: {
    LandingSection,
    IconsSection,
    Articles,
    CoursesSection,
    TheHeader,
    Partners,
    HabaybnaMedia,
    ContactUS,
    Testimonials,
    TheFooter,
  },
  mounted() {},
};
</script>
<style scoped>
.video-box-home {
  width: 1080px;
  height: 680px;
}
.statistic {
  display: flex;
  justify-content: center;
}
.statistic img{
  width: 55%;
}
.mobile-statistic {
  display: none;
}
@media (max-width: 767px) {
  .video-box-home {
    width: 360px;
    height: 210px;
  }

  .mobile-statistic {
      margin: 50px 0;
    display: flex;
    justify-content: center;
  }
  .statistic {
    display: none;
  }
}
</style>
