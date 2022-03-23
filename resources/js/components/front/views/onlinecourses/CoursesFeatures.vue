<template>
    <div class="our-features">
        <div class="container p-side-12-p">
            <h2 class="main-color mb-100 mb-20-p font-30 title-line mb-50 font-20-p">
                ما هي مميزات دورات التدريب من حبايبنا.نت
            </h2>
            <div class="features pt-15 d-flex space-between flex-wrap pt-0-p">
                <div class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p">
                      <img
                          src="/images/video.svg"
                          width="65"
                          height="70"
                          class="mb-30 mt-15-p mb-15-p"
                      />
                    <p class="font-19 main-color font-15-p mb-15-p">
                        مسجلة بجودة عالية متاحة لك بأي وقت ومن أي مكان
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p">
                    <img
                        src="/images/thumb-up.svg"
                        width="51"
                        height="70"
                        class="mb-30 mt-15-p mb-15-p"
                    />
                    <p class="font-19 main-color font-15-p mb-15-p">
                        مبسطة تقدم استراتيجيات عملية من السهل تطبيقها
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p">
                    <img
                        src="/images/file.svg"
                        width="78"
                        height="70"
                        class="mb-30 mt-15-p mb-15-p"
                    />
                    <p class="font-19 main-color font-15-p mb-15-p">
                        تقدم معلومات موثوقة مثبتة بالدراسات والأبحاث
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10 p-side-15-p half-p shadow-p radius-3-p">
                    <img
                        src="/images/specialists-avatar.svg"
                        width="70"
                        height="70"
                        class="mb-30 mt-15-p mb-15-p"
                    />
                    <p class="font-19 main-color font-15-p mb-15-p">
                        يقدمها أخصائيون ذوي خبرة عملية متميزة في مجالهم
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.box:not(:last-of-type):after {
  content: "";
  background: #E58C01;
  height: 61px;
  width: 2px;
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  margin: auto;
}
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
    .box:not(:last-of-type):after {
        content: none;
    }
    .box {
        background: #fff;
    }
    .box img {
        width: 42px;
        height: 42px;
    }
    .features {
        row-gap: 12px;
    }
    .our-features {
        padding-bottom: 6px;
    }
}
</style>