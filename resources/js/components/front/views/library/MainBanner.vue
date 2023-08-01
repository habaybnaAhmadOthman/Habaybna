<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-35 main-color bold font-20-p mb-25 mb-0-p">
              تحتاجين إلى من يقدم لك نصيحة ويكون معك كل يوم؟
            </h1>
            <h2 class="font-26 font-18-p f-normal black">
              مع مكتبة حبايبنا.نت تحصلين على نصيحة جديدة من ‘حد الخبراء كل يوم
              لإدراة رحلتك مع طفلك والتعامل مع احتياجاته داخل المنزل وخارجه
            </h2>
          </div>
        </div>
        <img
          class="landing-bg relative mb-30-p"
          src="images/Image for the content library.jpg"
          alt=""
        />
      </div>
    </div>
  </section>
</template>
<script>
export default {
  components: {},
};
</script>

<style scoped>
.landing-bg {
  width: 28%;
}
.patt-1 {
  position: absolute;
  top: 0;
  left: 0;
  transform: rotate(45deg);
}
@media (max-width: 767px) {
  .box {
    flex-direction: column-reverse;
  }
  .landing-bg {
    width: 100%;
  }
}
</style>
