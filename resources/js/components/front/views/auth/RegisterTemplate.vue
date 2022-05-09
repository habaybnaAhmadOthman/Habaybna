<template>
    <div class="d-flex registration-template h-full h-auto-p overflow-hidden">
        <div class="right-side bg-white w-40 w-100-p pt-0-p pt-20-p" :class="padding">
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
}
</style>
