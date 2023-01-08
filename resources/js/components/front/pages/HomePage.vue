<template>
  <div class="homepage">
    <TheHeader></TheHeader>
    <LandingSection></LandingSection>
      <IconsSection></IconsSection>
    <div
      class="video-box-home-container"
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
      <img src="images/siteImgs/statisticmobile2.png" alt="" />
    </div>
    <div class="statistic">
      <img src="images/siteImgs/statisticweb2.png" alt="" />
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
.video-box-home-container {
  display: flex;
  justify-content: center;
  margin-top: 75px;
}
.video-box-home {
  width: 74%;
  height: 680px;
}
.statistic {
  display: flex;
  justify-content: center;
      margin: 77px 0;

}
.statistic img{
  width: 75%;
}
.mobile-statistic {
  display: none;
}
@media (max-width: 767px) {
  .video-box-home {
    width: 355px;
    height: 200px;
  }

  .mobile-statistic {
      margin: 50px 0;
    display: flex;
    justify-content: center;
  }
  .mobile-statistic img{
  width: 90%;
}
  .statistic {
    display: none;
  }
  .video-box-home-container {

  margin-top: 20px;
}
}
</style>
