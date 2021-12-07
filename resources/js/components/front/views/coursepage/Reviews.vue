<template>
    <div class="reviews-container mt-30">
            <div class="container">
                <div class="reviews-box" show-more-less :class="{'active': showMore}">
                    <div class="review-box relative to-show">
                        <figure class="d-flex align-center">
                            <img class="rounded object-fit ml-10" src="https://www.blogenium.com/wp-content/uploads/2019/08/blogenium-cute-wallpapers-images-2-1024x576.jpg" alt="" width="35" height="35">
                            <p class="main-color font-17">اسم المستخدم</p>
                        </figure>
                        <p class="comment pre-line w-80 pr-20 mt-10">يمكنك متابعة الدورة من خلال الكمبيوتر او التليفون من خلال حسابك في الموقع والدورة تكون في حسابك مدى الحياة يمكنك متابعتها في اى وقت</p>
                    </div>
                    <div more @click="showMoreLess" class="btn mt-15 w-60 m-side-auto" ><span class="d-flex align-center justify-center">أظهر المزيد <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
                    <div less @click="showMoreLess" class="btn mt-15 w-60 m-side-auto" ><span class="d-flex align-center justify-center">عرض أقل <img class="mr-10" src="/images/siteImgs/header/logo.png" alt="" width="16" height="24"></span></div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return {
            showMore: false,
        }
    },
    methods: {
        showMoreLess() {
            this.showMore = !this.showMore
        }
    }
}
</script>
<style scoped>
.review-box:after {
    content:'';
    display: block;
    background: #707070;
    margin:  20px 0;
    width: 100%;
    height: 1px;
}
[show-more-less] [less], .to-show, [show-more-less].active [more]  {
    display: none;
}
[show-more-less]:not(.active) .to-show:nth-child(-n+3),[show-more-less].active .to-show ,
[show-more-less].active [less]{
    display: block;
}
.reviews-box .btn {
    padding:8px;
}
</style>