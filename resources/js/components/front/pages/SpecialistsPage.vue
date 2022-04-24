<template>
    <div class="library-page center m-auto d-flex justify-center align-center flex-column">
        <router-link to="/" class="logo d-flex mt-10">
            <img src="/images/siteImgs/header/logo.png" width="120" />
        </router-link>
        <h1 class="bold black-2 mt-50 mb-50">قريباً</h1>
        <div class="w-30 w-100-p">
            <router-link to="/" class="btn ">العودة الى الرئيسية</router-link>

        </div>
    </div>
</template>

<script>
    // import TheHeader from '../layouts/header/TheHeader.vue'
    
    // import TheFooter from '../layouts/TheFooter.vue'
    export default {
        // components: { TheHeader,TheFooter},
    }
</script>
<style scoped>
h1 {
    font-size: 100px;
}
</style>
