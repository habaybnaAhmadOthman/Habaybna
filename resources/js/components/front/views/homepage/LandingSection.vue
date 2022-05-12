<template>
  <section class="landing-section pt-50 relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="flex-all h-100">
          <div class="landing-call-links p-side-30">
            <h1 class="font-25 main-color bold font-18-p mb-25">لأن كل طفل لديه خطواته الخاصة في التطور يحتاج الـوالدين ومقدمي الرعاية إلى مرشــد يرافقهم ويساندهم في رحلتهم لتمكين طفلهم ويدلهم على الطريق المناسب له</h1>
            <h2 class="font-20 font-16-p f-normal black">أفضل الأخصائيين يقدمون التوجيه والتدريب لكل أم وأب أو مقدم رعاية يسعون لتطوير مهارات طفلهم المتأخر في التطور وتقديم الأفضل له ليجد طريقه في الحياة ومكانه في المجتمع</h2>
          </div>
        </div>
        <img class="landing-bg w-80-p mb-30-p" src="images/landing-1.png" alt="">
      </div>
    </div>
  </section>
</template>
<script>
export default {
  components:{ }
}
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
