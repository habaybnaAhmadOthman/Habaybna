<template>
  <div
    class="align-center bg-blue d-flex h-15 justify-center w-100  community-bar"
  >
    <router-link to="/habaybna-community" class="flex-all w-100">
      <p class="white p-5">تفاعل مع المختصين في مجتمع حبايبنا</p>
      <div class="">
        <img src="/images/siteImgs/question-mark.png" alt="" />
      </div>
    </router-link>
  </div>
</template>
<script>
export default {};
</script>
<style scoped>
.py-30 {
  padding: 30px 0;
}
.community-bar {
    position: fixed;
    z-index: 2;
    opacity: 0.95;
}
.community-bar img {
  -webkit-transition: -webkit-transform 0.8s ease-in-out;
  -ms-transition: -ms-transform 0.8s ease-in-out;
  transition: transform 0.4s ease-in-out;
  width:45px;
}
.community-bar:hover {
  cursor: pointer;
}
.community-bar:hover img {
  transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
}
</style>
