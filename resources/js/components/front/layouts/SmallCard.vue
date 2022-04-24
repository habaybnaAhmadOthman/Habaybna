<template>
    <div class="small-card w-100-p relative">
        <router-link class="radius-10 shadow d-flex p-10 bg-white box" to="/">
            <figure class="d-flex relative">
                <!-- favourite -->
                <div class="fav-box relative pointer shadow-2"></div>
                <img class="radius-20 object-fit main-img" src="/images/test.jpg" width="100" height="100">
            </figure>
            <div class="body mr-15 d-flex flex-column space-between">
                <p class="black-2 font-20 font-15-p three-line">لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم لوريم ايبسوم</p>
                <span class="bg-yellow date font-14 white radius-20">1996/11/4</span>
            </div>
       </router-link>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.date {
    align-self: baseline;
    padding: 3px 15px 0 15px;
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
    right: 0;
    top: -20px;
    width: 44px;
    height: 44px;
    margin: auto;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: .3s;
    z-index: 10;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
.main-img {
    min-width: 100px;
}

</style>
