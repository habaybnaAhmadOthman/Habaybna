<template>
    <div class="content-inner w-100-p">
        <FixedHeadWithLeftSide />
        <div class="page-header bg-white relative pt-10-p pb-10-p">
            <div class="container-fluid pt-15 pb-15">
                <slot name="page-header"></slot>
            </div>
        </div>
        <div class="content-container p-side-12-p pt-0-p">
            <slot></slot>
        </div>
    </div>
</template>
<script>
import FixedHeadWithLeftSide from '../../layouts/header/FixedHead.vue'
export default {
    components : {
        FixedHeadWithLeftSide
    }
}
</script>
<style scoped>
.container-fluid {
    min-width: auto!important;
}
.content-inner {
    position: relative;
    width: calc(100% - 230px);
    min-height: calc(100vh - 65px);
    padding-bottom: 60px;
    background: #eef5f9;
}
.page-header {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%);
}
.card {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%), -1px 0 2px rgb(0 0 0 / 5%);
    background: #fff;
}
h1 {
    color: #2f333e;
    font-size: 18px;
    font-weight: bold;
}
</style>
