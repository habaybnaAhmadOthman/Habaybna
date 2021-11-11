<template>
    <main>
        <TheHeader></TheHeader>
        <router-view></router-view>
    </main>
</template>

<script>
import TheHeader from './components/front/layouts/header/TheHeader.vue'
export default {
    components: {TheHeader}
}
</script>
<style>

@import url('./../../public/css/common.css');
</style>