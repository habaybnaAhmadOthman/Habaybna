<template>
    <div class="d-flex registration-template main-bg h-full">
        <div class="right-side w-50">
            <slot></slot>
        </div>
        <LeftSide class="w-50"></LeftSide>
    </div>
</template>

<script>
// page header
import LeftSide from "./LeftSide.vue";
export default {
    components: {
        LeftSide
    }
};
</script>

<style scoped>
.right-side {
    background:#b57abd;
    border-radius: 24px 0 0 24px;
    overflow-y: auto;
}
.registration-template .right-side, .registration-template .left-side{
    padding-top: 98px;
}
</style>
