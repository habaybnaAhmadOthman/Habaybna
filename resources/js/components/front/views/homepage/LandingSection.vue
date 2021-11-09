<template>
  <section class="landing-section">
    <div class="container h-100">
      <div class="flex-all h-100">
        <SearchWidget></SearchWidget>

        <div class="landing-call-links p-side-30">
          <p class="font-22 white bold">يمكنك التحدث مباشرة مع أخصائيين في التربية الخاصة والتأهيل</p>
          <button class="btn call-btn font-18 mt-25 bold">اتصل الآن</button>
        </div>

      </div>
    </div>
  </section>
</template>
<script>
import SearchWidget from './LandingSection_Search.vue'
export default {
  components:{ SearchWidget}
}
</script>

<style scoped>
.landing-section {
  background: linear-gradient(
      90deg,
      rgba(0, 0, 0, 0.263) 0%,
      rgba(0, 0, 0, 0.26) 100%
    ),
    url(http://cms.habaybna.net/sites/default/files/2020-02/caleb-woods-ecRuhwPIW7c-unsplash_0.jpg)
      center top / cover no-repeat;
  height: 90.7vh;
}
.call-btn {

}

</style>
