<template>
    <div class="banner mt-15 mt-0-p">
        <img class="w-100 main-img object-fit radius-10" src="/images/courses-bg.JPG" width="100%">
        <div class="d-flex space-between mt-15 align-center p-side-12-p">
            <p class="font-18 bold gray font-16-p">تم النشر : <span class="">2020/9/15</span></p>
            <div class="d-flex">
                <div class="fav-box relative pointer shadow-2 ml-25"></div>
                <p class="align-center bold d-flex font-14-p font-20 pointer yellow"><img class="ml-10 share-img" src="/images/share-color.svg" width="34" height="36" alt="" > مشاركة</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
.main-img {
    max-height: 700px;
}
.fav-box {
    background-color: rgb(255 255 255);
    border-radius: 50%;
    width: 44px;
    height: 44px;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: .3s;
    z-index: 1;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
@media (max-width: 767px) { 
    .share-img {
        width: 24px;
    }
    .main-img {
        height: calc(100vw * .625);
        border-radius: 0;
    }
    .fav-box {
        width: 33px;
        height: 33px;
    }
}
</style>