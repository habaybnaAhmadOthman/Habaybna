<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-30 main-color bold font-18-p mb-25 mb-10-p"> أهلا بكم في خدمة الاستشارات مع المختصين، لستم وحدكم بعد الآن، فأفضل الأخصائيين مستعدون لمساعدتكم في مواجهة مشاكلكم مع تطور أبنائكم</h1>
            <h2 class="font-24 font-16-p f-normal black">من خلال هذه الخدمة يمكن لكل أم وأب استشارة الأخصائيين للحصول على التوجيه المناسب لمساعدة طفلكم على تطوير مهاراته. يمكن للأخصائيين مرافقتكم طوال فترة تدريب طفلكم على مهارة جديدة ليقدموا لكم الدعم والتوجيه الذي تحتاجونه خلال هذه الفترة لاجتيازها بنجاح</h2>
          </div>
        </div>
        <img class="landing-bg do" src="images/consultant-page-bg.png" alt="الاستشارات مع المختصين">
        <img class="landing-bg mo" src="images/calls-bg-mo.png" alt="الاستشارات مع المختصين">
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
