<template>
    <div class="container">
        <div class="banner relative overflow-hidden radius-12">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVGa04OI-Nz_WVhfGsDZy-lXU9Z2LwpWnvtQ&usqp=CAU" alt="" class="main-img h-100 w-100 z-1">
            <div class="fav-box relative">
                <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-add.svg" class="add pointer"> 
                <img width="36" height="36" src="https://www.arabiaweather.com/farms/assets/images/favourite-added-offer.svg" class="remove pointer">
            </div>
        </div>
    </div>
</template>

<style scoped>
.banner {
    height:400px;
}
.banner:after  {
    content: '';
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0.98;
    pointer-events: none;
    background: rgb(0 0 0 / 20%);
    pointer-events: none;
}
.fav-box .remove {
    position: absolute;
    right: 0;
    top: 0;
    opacity: 0;
    pointer-events: none;
}
.fav-box .add.active ~ .remove {
    opacity: 1;
    pointer-events: initial;
}
.fav-box {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1;
}
</style>