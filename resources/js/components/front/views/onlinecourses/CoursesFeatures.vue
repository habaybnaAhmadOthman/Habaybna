<template>
    <div class="our-features pt-45">
        <div class="container">
            <h2 class="main-color mb-100 font-30 title-line mb-50">
                ما هي مميزات دورات التدريب من حبايبنا.نت
            </h2>
            <div class="features pt-15 d-flex space-between flex-wrap">
                <div class="box relative center w-25 p-side-10">
                      <img
                          src="/images/video.svg"
                          width="65"
                          height="70"
                          class="mb-30"
                      />
                    <p class="font-19 main-color">
                        مسجلة بجودة عالية متاحة لك بأي وقت ومن أي مكان
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10">
                    <img
                        src="/images/thumb-up.svg"
                        width="51"
                        height="70"
                        class="mb-30"
                    />
                    <p class="font-19 main-color">
                        مبسطة تقدم استراتيجيات عملية من السهل تطبيقها
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10">
                    <img
                        src="/images/file.svg"
                        width="78"
                        height="70"
                        class="mb-30"
                    />
                    <p class="font-19 main-color">
                        تقدم معلومات موثوقة مثبتة بالدراسات والأبحاث
                    </p>
                </div>
                <div class="box relative center w-25 p-side-10">
                    <img
                        src="/images/specialists-avatar.svg"
                        width="70"
                        height="70"
                        class="mb-30"
                    />
                    <p class="font-19 main-color">
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
</style>