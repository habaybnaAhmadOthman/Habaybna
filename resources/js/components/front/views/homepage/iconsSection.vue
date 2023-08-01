<template>
  <section class="icons-section relative mt-50">
    <div class="container h-100 z-1">
      <div class="row">
        <div class="w-25 col-sm-6 icon-box mb-10" >
          <router-link to="/online-courses">
            <figure class="video">
              <img
                src="/images/siteImgs/homepageicons1.png"
                alt=""
                width="101"
                height="81"
              />
            </figure>
            <p class="black-2 font-24 pre-line font-14-p">
              لمساعدتك على فهم احتياجات طفلك الأساسية مع أكثر من 1000 فيديو
            </p>
          </router-link>
        </div>
        <div class="w-25 col-sm-6 icon-box mb-10 ">
          <router-link to="/ask-specialists">
            <figure class="consultation">
              <img
                src="/images/siteImgs/homepageicons2.png"
                alt=""
                width="93"
                height="97"
              />
            </figure>

            <p class="black-2 font-24 pre-line font-14-p">
              للحصول على التوجيه والإرشاد بشكل فردي عن بعد
            </p>
          </router-link>
        </div>
        <div class="w-25 col-sm-6 icon-box mb-10 ">
          <router-link to="/library">
            <figure class="library">
              <img
                src="/images/siteImgs/homepageicons3.png"
                alt=""
                width="98"
                height="90"
              />
            </figure>

            <p class="black-2 font-24 pre-line font-14-p">
              لمساعدتك على معرفة بدائل لتحسين حياة طفلك من خلال دورات قصيرة
              خفيفة
            </p>
          </router-link>
        </div>
        <div class="w-25 col-sm-6 icon-box mb-10 ">
          <router-link to="/habaybna-community">
            <figure class="library">
              <img
                src="/images/siteImgs/homepageicons4.png"
                alt=""
                width="98"
                height="90"
              />
            </figure>

            <p class="black-2 font-24 pre-line font-14-p">
              لمساعدتك على التعامل مع تحد في التطور أو التعليم مع طفلك من خلال
              الاستشارات
            </p>
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
    import "/public/css/common.css";

export default {
  components: {},
};
</script>

<style scoped>

figure {
  height: 143px;
  width: 143px;
  display: flex;
  align-items: flex-end;
}
a figure img {
  height: 100%;
  width: 100%;
}
.icon-box a {
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  text-align: center;
}
.icon-box p {
width: 80%;
}

/* @media (max-width: 767px) {
  .icon-box {
    padding: 5px 20px;
    max-width: 24%;
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
  .icon-box a {
          display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
} */
</style>
