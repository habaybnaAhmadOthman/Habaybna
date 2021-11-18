<template>
    <div class="header-margin">
        <div class="container soft-bg radius-12 pt-30 pb-30 mb-30">
            <AuthHeader></AuthHeader>
            <div class="p-side-30 mt-50 w-50 m-side-auto">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
// page header
import AuthHeader from "./../../front/layouts/header/AuthHeader.vue";
export default {
    components:{
        AuthHeader
    }
}
</script>

<style scoped>
.soft-bg {
    background: #eff5ff;
}
</style>