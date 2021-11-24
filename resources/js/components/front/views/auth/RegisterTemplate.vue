<template>
    <div class="d-flex registration-template main-bg h-full overflow-hidden">
        <div class="right-side bg-white w-40" :class="padding">
            <slot></slot>
        </div>
        <LeftSide class="w-60"></LeftSide>
    </div>
</template>

<script>
// page header
import LeftSide from "./LeftSide.vue";
export default {
    props: { padding: { default: "pt-100" } },
    components: {
        LeftSide
    }
};
</script>

<style scoped>
.right-side {
    overflow-y: auto;
}
</style>
