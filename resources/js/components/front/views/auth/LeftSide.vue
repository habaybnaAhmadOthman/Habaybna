<template>
    <div class="left-side h-100 pt-100 h-auto-p mt-10-p center p-side-50 p-side-12-p relative mt-0-p-i pt-20-p">
        <img src="/images/siteImgs/header/logo.png" class="mt-20 mt-0-p z-1" alt="" />
        <img src="/images/slogan.jpg" class="mt-20 mt-0-p slogan" alt="" />
        
    </div>
</template>

<style scoped>
.left-side {
    background-image: url(/images/register-bg.jpg);
    background-size: cover;
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
.slogan {
    width: 400px;
    display: block;
    text-align: center;
    margin: auto;
    height: 250px;
    transform: translateY(-50px);
}
@media (max-width: 767px) {
    .left-side {
        height: 240px;
    }
    .slogan { 
        position: absolute;
        bottom: 0;
        transform: none;
        bottom: -30px;
        left: 0;
        right: 0;
        width: 350px;
        height: 210px;
    }
}
</style>
