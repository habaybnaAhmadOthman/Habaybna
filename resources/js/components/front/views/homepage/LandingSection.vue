<template>
  <section class="landing-section relative">
    <div class="container h-100 z-1">
      <div class="flex-all h-100">
        <div class="landing-call-links p-side-30">
          <p class="white bold font-40 pr-20 font-20-p">أهلاً بكم!</p>
          <h1 class="font-30 white f-normal font-18-p">تطوير مهارات الأطفال وتلبية احتياجاتهم التطورية ليست أمراً سهلاً! بحاجة لإرشاد وتوجيه من المختصين. لذلك نضع عالم من الخبرات والمعرفة بين يديكم لمساعدتكم في تمكين الأطفال بمختلف قدراتهم</h1>
        </div>
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
.landing-section:before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: url(/images/banner-gradinet.svg);
  mix-blend-mode: multiply;
  background-size: 100%;
}
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

@media (max-width: 767px) {
    .landing-section {
      height: 400px;
    }
}
</style>
