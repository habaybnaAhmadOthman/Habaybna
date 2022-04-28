<template>
    <div class="small-card w-100-p relative">
        <div class="fav-box relative pointer shadow-2"></div>
        <router-link class="radius-10 shadow d-flex p-10 bg-white box" to="/content/aa">
            <div class="body ml-15 d-flex flex-column space-between">
                <p class="black-2 font-20 font-15-p three-line">لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم</p>
                <span class="date font-14 white radius-20 gray mr-30 pr-20">1996/11/4</span>
            </div>
            <figure class="d-flex relative">
                <!-- favourite -->
                <img class="radius-10 object-fit main-img" src="/images/test.jpg" width="100" height="100">
            </figure>
       </router-link>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.date {
    align-self: baseline;
}
.box:after {
    content: '';
    background: url(/images/arrow-left-full.svg) no-repeat center;
    position: absolute;
    left: 15px;
    bottom: 9px;
    margin: auto;
    width: 33px;
    height: 27px;
}
.fav-box {
    position: absolute;
    background-color: rgb(255 255 255);
    border-radius: 50%;
    left: 0;
    right: 10px;
    bottom: 4px;
    width: 34px;
    height: 34px;
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
.main-img {
    min-width: 100px;
}

</style>
