<template>
  
  <div class="search-container">

    <div class="search-box mb-20">
      <h1 class="font-20 white mb-15 regular light">الموقع العربي المتخصص بشؤون التحديات التطورية والذهنية في الوطن العربي. أبناؤنا بمختلف قدراتهم حبايبنا</h1>
      <form class="search-form">
        <div class="from-group relative">
          <input type="text" placeholder="بحث" class="radius-5 p-10 border-0 w-100 font-16">
          <router-link to="/" class="flex-all h-100 search-icon">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAMAAABhEH5lAAAAOVBMVEUAAAB6hYp7hox8ho18h4uAgI94h498hY17ho17ho17hYx8hox7hox6hY17hY17hY17ho18hox8ho2Ava9AAAAAEnRSTlMAMPDAQBAggN/Q4K+gYLCfcFCWYRAyAAAAeElEQVQY012OWQ7DMAgFicGOt3SZ+x+2anCx1PkBDaCH/LgG1GeRIDeccxvSq4jN7U569nNYtwkTZzLvanRZGPWubzSCwEdbHUsVyBH08EYZ3pTEFevju2eVtox2QLVCy24SeihAOsOkQ6SY+b9hNttsNEyQ9d98AB0EBTElKvkoAAAAAElFTkSuQmCC" alt="search">
          </router-link>
        </div>
      </form>
    </div>

    <div class="suggestions-box d-flex align-center mb-15">
      <h2 class="white font-14">مقترحات</h2>
      <div class="box font-14">
        <router-link to="/" class="underline white mr-20" title="">النطق واللغة</router-link>
        <router-link to="/" class="underline white mr-20" title="">صعوبات التعلم</router-link>
        <router-link to="/" class="underline white mr-20" title="">الشلل الدماغي</router-link>
        <router-link to="/" class="underline white mr-20" title="">متلازمة داون</router-link>
      </div>
    </div>

    <div class="numbers-container d-flex align-center">
      <div class="number-video white font-15 d-flex align-center">
        <img width="42" height="42" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MyIgaGVpZ2h0PSI1MyIgdmlld0JveD0iMCAwIDUzIDUzIj4NCiAgPGcgaWQ9Ikdyb3VwXzg4NjciIGRhdGEtbmFtZT0iR3JvdXAgODg2NyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEyNTggLTc4NSkiPg0KICAgIDxjaXJjbGUgaWQ9IkVsbGlwc2VfNTciIGRhdGEtbmFtZT0iRWxsaXBzZSA1NyIgY3g9IjI2LjUiIGN5PSIyNi41IiByPSIyNi41IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjU4IDc4NSkiIGZpbGw9IiMzZmM0ZTAiLz4NCiAgICA8cGF0aCBpZD0iUGF0aF84ODIzIiBkYXRhLW5hbWU9IlBhdGggODgyMyIgZD0iTTEwOTIsNTczLjA2NWw4LjQzNC02LjYyMkwxMDkyLDU1OS44MjJaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxODguNTY2IDI0NS4xNzgpIiBmaWxsPSIjZmZmIiBzdHJva2U9IiNmZmYiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIzIi8+DQogIDwvZz4NCjwvc3ZnPg0K" alt="video">
        <span class="mr-10">874 فيديو</span>
      </div>
      <div class="number-video white font-15 d-flex align-center mr-20">
        <img width="42" height="42" src="https://www.habaybna.net/_nuxt/img/text.9cf24dd.svg" alt="video">
        <span class="mr-10">195 مقال</span>
      </div>
    </div>

  </div>

        
</template>

<style scoped>


/* search */
.search-container {
  padding:28px 72px;
  background: rgba(0,0,0,.22);
}
.search-icon {
  position: absolute;
  width :50px;
  top :0;
  left:0;
}
.en .search-icon{
  left: auto;
  right: 0;
}
/* end search */
</style>
