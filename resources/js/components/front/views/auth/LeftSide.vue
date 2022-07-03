<template>
    <div class="left-side h-100 pt-100 h-auto-p mt-10-p center p-side-50 p-side-12-p relative mt-0-p-i pt-20-p">
        <a v-if="$route.meta.back == true" @click.prevent="$router.back()" class="back-btn" ><img src="/images/back-btn.svg" width="30" height="30" /><span class="do white bold">عودة</span></a>
        <img src="/images/siteImgs/header/logo.png" class="mt-20 mt-0-p z-1" alt="" />
    </div>
</template>

<style scoped>
.left-side {
    background-image: url(/images/register-bg.jpg);
    background-size: cover;
}
.back-btn {
    position: absolute;
    left: 10px;
    top: 10px;
    background: #fff;
    border-radius: 50%;
    width: 30px;
    height: 30px;
}
.left-side:before {
    content: '';
    background: rgb(102 0 102 / 50%);
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
@media (max-width: 767px) {
    .left-side {
        min-height: 140px;
    }
}
</style>
