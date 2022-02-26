<template>
    <div class="banner-info">
        <h2 class="title-line font-27 mb-40">{{header}}</h2>
        <h3 class="black-2 font-27 pre-line f-normal mb-40">{{description}}</h3>
    </div>
</template>

<script>
    export default {
        props: ['header','description']
    }
</script>

<style scoped>
.banner-info {
    margin-top: 150px;
}
</style>