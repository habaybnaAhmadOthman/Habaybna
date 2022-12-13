<template>
  <section class="icons-section relative">
    <div class="container h-100 z-1">
      <div
        class="
          icons-box
          d-flex
          row-3-gap
          gap-20
          justify-center-p
          p-side-12-p
          pb-10-p
          flex-wrap
        "
      >
        <div class="icon-box">
          <router-link to="/online-courses">
            <figure class="mb-20 video">
              <img
                src="/images/online-video-icon.svg"
                alt=""
                width="101"
                height="81"
              />
            </figure>
            <p class="black font-30 mb-10 bold font-16-p">دورات تدريب رقمية</p>
            <p class="black-2 font-24 pre-line font-14-p">
              تقدم تدريبات عملية يقدمها أخصائيون متميزون
            </p>
          </router-link>
        </div>
        <div class="icon-box">
          <router-link to="/ask-specialists">
            <figure class="mb-20 consultation">
              <img
                src="/images/consultation-icon.svg"
                alt=""
                width="93"
                height="97"
              />
            </figure>
            <p class="black font-30 mb-10 bold font-16-p">
              استشارات مع المختصين
            </p>
            <p class="black-2 font-24 pre-line font-14-p">
              للحصول على التوجيه والإرشاد بشكل فردي عن بعد
            </p>
          </router-link>
        </div>
        <div class="icon-box">
          <router-link to="/library">
            <figure class="mb-20 library">
              <img
                src="/images/product-icon.svg"
                alt=""
                width="98"
                height="90"
              />
            </figure>
            <p class="black font-30 mb-10 bold font-16-p">
              مكتبة معلومات مجانية
            </p>
            <p class="black-2 font-24 pre-line font-14-p">
              تضم تجارب وخبرات لتمكين الأطفال بمختلف قدراتهم
            </p>
          </router-link>
        </div>
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
figure {
  height: 97px;
  display: flex;
  align-items: flex-end;
}
@media (max-width: 767px) {
  .icon-box {
    padding: 5px 20px;
    min-width: 210px;
    text-align: center;
  }
  .icon-box figure {
    height: 40px;
  }
  .icon-box figure img {
    display: block;
    margin: auto;
  }
  .icon-box .video img {
    width: 50px;
    height: 40px;
  }
  .icon-box .consultation img {
    width: 38px;
    height: 40px;
  }
  .icon-box .library img {
    width: 44px;
    height: 40px;
  }
}
</style>
