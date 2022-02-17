<template>
    <div class="course-card w-30 radius-10 overflow-hidden bg-white relative">
        <figure class="d-flex relative overflow-hidden radius-10 figure-box">
            <img class="w-100 course-card-img" src="/images/register-bg.jpg" width="100%" height="250" alt="">
            <div class="fav-box relative pointer"></div>
            <img class="play-icon pointer" src="/images/play-icon.svg" />
        </figure>
        <div class="d-flex box-details flex-wrap">
            <router-link to="/" class="btn-register-now white-i font-18 mb-20 bold flex-all w-100">إشترك الآن</router-link>
            <form class="cobone-form relative d-flex w-100">
                <input type="text" class="w-80 cobone-input" placeholder="هل لديك كوبون أو قسيمة شرائية استخدمها الآن ؟">
                <input type="submit" value="" class="apply-cobone w-10">
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
.btn-register-now {
    background:#632F63;
    border-radius: 25px;
    height: 60px;
}
.box-details {
    padding: 20px 20px 40px 20px;
}
.course-card {
    box-shadow: 0px 3px 6px #00000029;
    align-self: end;
    top: 170px;
}
.cobone-form {
    height: 60px;
}
.cobone-input {
    border: 1px solid #939598;
    border-radius: 0 25px 25px 0;
    color: #939598;
    font-size: 12px;
    padding: 20px 8px;
}
.apply-cobone {
    background-color: #632F63;
    position: relative;
    border-radius: 25px 0 0 25px;
    border: 0;
    width: 20%;
    background-image: url(/images/arrow-left.svg);
    background-repeat: no-repeat;
    background-position: center;
}
.fav-box {
    position: absolute;
    background-color: rgb(255 255 255 / 90%);
    border-radius: 50%;
    left: 11px;
    top: 14px;
    width: 44px;
    height: 44px;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: .3s;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
.figure-box .play-icon {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 55px;
    height: 55px;
    margin: auto;
}
</style>