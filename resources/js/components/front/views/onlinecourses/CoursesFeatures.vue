<template>
  <div class="our-features">
    <div class="container p-side-12-p">
      <h2 class="main-color  mb-20-p font-30 title-line mb-50 font-20-p">
        ما هي مميزات دورات حبايبنا.نت ؟
      </h2>
      <div class="features pt-15 d-flex space-between flex-wrap pt-0-p">
        <div
          class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p"
        >
          <img
            src="/images/Icons Courses/coursesicons1.svg"
            width="250"
            height="150"
            class="mb-30 mt-15-p mb-15-p"
          />
          <p class="font-19 main-color font-15-p mb-15-p">
            من خبراتهم بالعمل مع العديد من الوالدين والأطفال
          </p>
        </div>
        <div
          class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p"
        >
          <img
            src="/images/Icons Courses/coursesicons2.svg"
            width="250"
            height="150"
            class="mb-30 mt-15-p mb-15-p"
          />
          <p class="font-19 main-color font-15-p mb-15-p">
            تراعي وقتكم المحدود والتزاماتكم المتعددة
          </p>
        </div>
        <div
          class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p"
        >
          <img
            src="/images/Icons Courses/coursesicons3.svg"
            width="250"
            height="150"
            class="mb-30 mt-15-p mb-15-p"
          />
          <p class="font-19 main-color font-15-p mb-15-p">
            كل دورة هي مفتاح لمرحلة جديدة في تطور طفلك
          </p>
        </div>
        <div
          class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p"
        >
          <img
            src="/images/Icons Courses/coursesicons4.svg"
            width="250"
            height="150"
            class="mb-30 mt-15-p mb-15-p"
          />
          <p class="font-19 main-color font-15-p mb-15-p">
            يمكنك مشاهدتها في أي وقت ومكان ملائم لك
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.our-features {
  padding-bottom: 80px;
}
.course-page .title-line {
  margin-bottom: 40px;
}
.course-page .our-features {
  padding-top: 20px;
  padding-bottom: 60px;
}
@media (max-width: 767px) {
  .box {
    background: transparent;
    box-shadow: none;
  }
  .box img {
    width: 100px !important;
    height: 100px !important;
  }
  .features {
    row-gap: 12px;
  }
  .our-features {
    padding-bottom: 6px;
  }
}
</style>
