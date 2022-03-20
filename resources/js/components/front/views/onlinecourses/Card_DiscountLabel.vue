<template>
    <div>
        <div
            class="discount-label d-flex white pr-30 align-center"
            v-if="!isFree && hasDiscount"
        >
            <span class="font-16">خصم</span>
            <span class="font-17 top-2 discount-val">{{ discountValue }}</span>
        </div>
        <div
            class="discount-label d-flex white align-center free-course-label"
            v-if="isFree"
        >
            <span class="font-20">مجاناً</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['isFree','hasDiscount','discountValue']
};
</script>

<style scoped>

.discount-label {
    background: url(/images/discount-label.svg) no-repeat;
    background-size: 100% 100%;
    width: 130px;
    height: 53px;
    position: absolute;
    bottom: 20px;
    right: 0;
    pointer-events: none;
}
.discount-val {
    padding-right:3px;
}

.free-course-label {
    padding-right: 40px;
    background: url(/images/free-label.svg) no-repeat;
}
.free-course-label span{
    position: relative;
    top: 4px;
}
.course-discount {
    z-index: 100;
}
.course-discount .discount-label{
    bottom: 60px;
}
</style>
