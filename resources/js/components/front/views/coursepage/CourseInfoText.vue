<template>
    <div class="banner-info mb-40 mb-20-p">
        <h2 class="title-line font-27 mb-40 do">{{header}}</h2>
        <div class="black-2 font-20 pre-line f-normal" v-html="description"></div>
    </div>
</template>

<script>
    export default {
        props: ['header','description'],
        
    }
</script>

<style scoped>
.banner-info {
    margin-top: 150px;
}
@media (max-width: 767px) {
    .banner-info {
        margin-top: 20px;
    }
}
</style>