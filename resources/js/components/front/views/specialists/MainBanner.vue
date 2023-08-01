<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box overflow-hidden">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-25 main-color bold font-18-p mb-25 mb-10-p">رحلتك مع طفلك مليئة بالمفاجآت الغير متوقعة وتحتاجين إلى من يرشدك أحياناً</h1>
            <h2 class="font-20 font-16-p f-normal black">حبايبنا.نت معك في أصعب الأوقات خصوصاً إذا كنت تواجهين مع طفلك بعض الشكوك أو التحديات التي تعيق نموه وقدرته على التعلم ولاتعرفين أين تتوجهين أو ماذا تفعلين ولايمكنك الانتظار طويلاً</h2>
          </div>
        </div>
        <img class="landing-bg" src="images/specialistsbanner.jpg" alt="الاستشارات مع المختصين">
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
      margin-top: 30px;

    width: 40%;
}

@media (max-width: 767px) {
    .box {
      flex-direction: column-reverse;
    }
    .landing-bg {
      width: 100%;
      margin-bottom: 20px;
    }
}
</style>
