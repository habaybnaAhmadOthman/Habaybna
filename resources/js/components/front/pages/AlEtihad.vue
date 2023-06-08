<template>
  <div class="terms-page">
    <TheHeader />
    <div class="container">
      <div class="bae-banner">
        <img src="/images/siteImgs/بدعم من بنك الاتحاد (1).jpg" class="" />
      </div>
      <!-- <div class="w-80 w-100-p"> -->
      <div>
        <iframe
          src="https://docs.google.com/forms/d/e/1FAIpQLSddamFyd5GDyPmFx3g_dXNLdZl2S-_d7GHaH4qoRVI8MLGwCg/viewform?embedded=true"
          style="overflow: socroll"
          width="100%"
          height="5100"
          frameborder="0"
          marginheight="0"
          marginwidth="0"
          >Loading…</iframe
        >
      </div>
      <!-- </div> -->
    </div>
    <TheFooter />
  </div>
</template>

<script>
import TheHeader from "../layouts/header/TheHeader.vue";

import TheFooter from "../layouts/TheFooter.vue";
export default {
  components: { TheHeader, TheFooter },
};
</script>
<style scoped>
h1 {
  font-size: 100px;
}
.bae-banner > img{
  max-height: 500px;
  width: 100%;
}
.bae-banner .teQAzf {
    width: 90vw !important;
}
</style>
