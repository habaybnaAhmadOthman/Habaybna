<template>
  <section class="landing-section pt-50 relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="flex-all h-100">
          <div class="landing-call-links p-side-5">
            <h1 class="font-25 main-color bold font-18-p mb-25">
              أهلاً بك في حبايبنا.نت
            </h1>
            <h2 class="font-20 font-16-p f-normal black">
              مجتمع من المعرفة ونصائح الخبراء عن تطور الطفل‎
            </h2>
            <SearchModal></SearchModal>
          </div>
        </div>
        <img
          class="landing-bg w-80-p mb-30-p"
          src="images/siteImgs/Home page image.png"
          alt=""
        />
      </div>
    </div>
  </section>
</template>
<script>
import SearchModal from "../../layouts/SearchModal.vue";
export default {
  components: { SearchModal },
};
</script>

<style scoped>
.landing-bg {
  width: 45%;
}

@media (max-width: 767px) {
  .box {
    flex-direction: column-reverse;
  }
}
</style>
