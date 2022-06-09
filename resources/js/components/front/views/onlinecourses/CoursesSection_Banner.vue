<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-30 main-color bold font-18-p mb-25 mb-0-p">أفضل الأخصائيين يقدمون لك التدريب لمساعدتك على تطوير مهارات طفلك</h1>
            <h2 class="font-24 font-16-p f-normal black">نقدم دورات تدريب رقمية تساعد الوالدين ومقدمي الرعاية على تدريب الطفل واكتساب مهارات جديدة في مختلف مجالات الحياة مع التركيز على جوانب الحياة العملية</h2>
          </div>
        </div>
        <img class="landing-bg mb-30-p" src="images/online-bg-1.png" alt="">
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
    width: 28%;
}

@media (max-width: 767px) {
    .box {
      flex-direction: column-reverse;
    }
    .landing-bg {
        width: 60%;
    }
}
</style>
