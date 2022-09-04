<template>
    <div class="d-flex registration-template h-full h-auto-p overflow-hidden">
        <div class="right-side bg-white w-40 w-100-p pt-0-p pt-20-p" :class="padding">
            <a title="whatsapp" class="whatsapp-float mo" href="https://api.whatsapp.com/send?phone=+962799760238" data-action="share/whatsapp/share" target="_blank"> 
                <div class="d-flex align-center">
                    <img src="/images/whatsapp-white.svg" width="25">
                    <span class="mr-10">تواصل معنا عبر واتس اب</span>
                </div>
            </a>
            <slot></slot>
        </div>
        <LeftSide class="w-60 w-100-p pt-0-p"></LeftSide>
    </div>
</template>

<script>
// page header
import LeftSide from "./LeftSide.vue";
export default {
    props: { padding: { default: "pt-100" } },
    components: {
        LeftSide
    },
    mounted(){
        document.querySelector('body').classList.add('h-full', 'bg-white');
    },
};
</script>

<style scoped>
.right-side {
    overflow-y: auto;
}
@media (max-width: 767px) {
    .registration-template {
        flex-direction: column-reverse;
    }
    .whatsapp-float {
        position: absolute;
        bottom: 5px;
        right: 10px;
        color: #fff;
        background: #62b263;
        border-radius: 30px;
        padding: 5px 5px 5px 10px;
        font-size: 13px;
    }
}
</style>
