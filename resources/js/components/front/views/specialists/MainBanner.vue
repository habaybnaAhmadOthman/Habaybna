<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-30 main-color bold font-18-p mb-25 mb-0-p">أهلا بكم في خدمة الاستشارات مع المختصين</h1>
            <h2 class="font-24 font-16-p f-normal black">لكل أب و أم رحلتهم الخاصة مع تطور طفلهم المختلفة عن غيرهم لذا وفرنا لكم هذه الخدمة للحصول على التوجيه الفردي الملائم لاحتياجات طفلكم التطورية</h2>
          </div>
        </div>
        <img class="landing-bg do" src="images/consultant-page-bg.png" alt="الاستشارات مع المختصين">
        <img class="landing-bg mo" src="images/consultant-page-bg.png" alt="الاستشارات مع المختصين">
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
    width: 30%;
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
