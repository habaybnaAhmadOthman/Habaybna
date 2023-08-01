<template>
  <section class="landing-section pt-50 pt-20-p relative">
    <div class="container h-100 z-1">
      <div class="d-flex align-center space-between box">
        <div class="w-60 w-100-p h-100">
          <div class="landing-call-links p-side-30 p-side-12-p">
            <h1 class="font-30 main-color bold font-18-p mb-25 mb-0-p">من الصعب معرفة ماهو مطلوب منك في كل مرحلة ينمو بها طفلك</h1>
            <h2 class="font-24 font-16-p f-normal black">مع دورات حبايبنا.نت ستحصلين على خطوات وإرشادات تساعدك على فهم احتياجات طفلك وكيف يمكنك مساعدته على التعلم والوصول لمراحل جديدة في التطور والنمو </h2>
          </div>
        </div>
        <img class="landing-bg w-40 mb-30-p mt-50" src="images/Courses Image smaller01.png" alt="">
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
    width: 40%;
}

@media (max-width: 767px) {
    .box {
      flex-direction: column-reverse;
    }
    .landing-bg {
        width: 70%;
    }
}
</style>
