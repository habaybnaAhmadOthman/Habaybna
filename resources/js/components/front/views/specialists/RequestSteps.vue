<template>
  <section class="request-section relative">
    <div class="container">
      <h3 class="font-24 main-color bold mb-10 d-block center-p w-100-p font-20-p">كيف يمكنك حجز الاستشارة</h3>
      <div class="d-flex space-between flex-wrap-p">
        <div class="steps w-100-p pt-20 w-40 p-side-12-p">
          <div class="step mb-25 d-flex">
            <div class="num-box relative">
              <span class="bg-yellow white font-23 rounded flex-all ml-25 step-num">1</span>
            </div>
            <div class="">
              <p class="--title black-2 font-20 mb-20 d-flex align-center bold"> اختر الأخصائي المناسب</p>
              <p class="font-15 black-2">يمكنك الاطلاع الملف الشخصي لكل أخصائيين والتعرف عليه. جميع الأخصائيين معتمدين في مجالاتهم ولديهم مؤهلات علمية لاتقل عن درجة الماجستير وخبرة عملية لاتقل عن 7 سنوات، والأهم من ذلك، لديهم الشغف لمساعدة الوالدين في التغلب على تحدياتهم</p>
            </div>
          </div>
          <div class="step mb-25 d-flex">
            <div class="num-box relative">
              <span class="bg-yellow white font-23 rounded flex-all ml-25 step-num">2</span>
            </div>
            <div class="">
              <p class="--title black-2 font-20 mb-20 d-flex align-center bold">احجز وقت الجلسة المناسبة</p>
              <p class="font-15 black-2">اختر اليوم والوقت المناسبين لك من الأوقات المتاحة للأخصائي. سيكون عليك التسجيل والدفع مقدماً لتأكيد الحجز. سيصلك رابط المكالمة فور التأكيد وسنقوم بتذكيرك قبل الموعد برسالة نصية وعبر البريد الالكتروني</p>
            </div>
          </div>
          <div class="step d-flex">
            <div class="num-box relative">
              <span class="bg-yellow white font-23 rounded flex-all ml-25 step-num">3</span>
            </div>
            <div class="">
              <p class="--title black-2 font-20 mb-20 d-flex align-center bold">تحدث مع الأخصائي</p>
              <p class="font-15 black-2">بعد تأكيد الحجز سيصلك رابط للمكالمة وتأكيد الموعد، وسيكون الأخصائي/ة بانتظارك في الوقت المحدد لتسأل أكثر كيف يمكنك التعامل مع احتياجاتك واحتياجات طفلك بكل خصوصية وأمان دون الخوف من إصدار الأحكام</p>
            </div>
          </div>
        </div>
        <div class="video-box relative w-55 mt-20-p w-80-p m-side-auto">
          <video class="radius-10" width="100%" controls>
            <source src="https://aws3.devops.arabiaweather.com/arabiaweather-crowd-sourcing-production/media/users/56336/posts/268852/original.720p.mp4" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  methods: {
    hidePlayBtn(){
      document.querySelector('.video-box').classList.add('active')
    }
  },
  mounted(){
    document.querySelector('.video-box video').addEventListener('play',this.hidePlayBtn)
  },
  destroyed(){
    document.querySelector('.video-box video').removeEventListener('play',this.hidePlayBtn)
  }
}
</script>

<style scoped>

.step-num {
    width: 34px;
    height: 34px;
    min-width: 34px;
}
.step:not(:last-of-type) .step-num:after {
    content: '';
    background: #780d93;
    width: 1px;
    height: calc(100% - 19px);
    position: absolute;
    top: 40px;
}
.video-box {
  cursor: pointer;
}
.video-box:after {
  content: '';
  position: absolute;
  width: 180px;
  height: 180px;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;
  background: url(/images/play-icon-2.svg) no-repeat;
  background-size: cover;
  pointer-events: none;
  transition: .3s;
}
.video-box.active:after {
  opacity: 0;
}
@media (max-width: 767px) {
  .video-box:after {
    width: 57px;
    height: 57px;
  }
}
</style>
