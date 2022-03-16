<template>
    <div class="course-box bg-white shadow w-31 radius-10 relative">
        <div class="fav-box relative pointer"></div>
        <router-link @click.native="forceRefresh" :to="`/courses/${courseSlog}`">
            <figure class="d-flex relative radius-10 overflow-hidden figure-box">
                <img
                    class="main-img w-100 object-fit"
                    :src="course.cover_photo"
                    height="206"
                    width="auto"
                />

                <!-- <img class="play-icon pointer" src="/images/play-icon.svg" /> -->

                <!-- discount -->
                <div
                    class="discount-label d-flex white pr-30 align-center"
                    v-if="!course.is_free && course.discount.has_discount"
                >
                    <span class="font-16">خصم</span>
                    <span class="font-17 top-2 discount-val">{{
                        course.discount.discount_value
                    }}</span>
                </div>
                <div
                    class="discount-label d-flex white align-center free-course-label"
                    v-if="course.is_free"
                >
                    <span class="font-20">مجاناً</span>
                </div>
            </figure>

            <div class="p-side-20 pb-10 pt-10">
                <p class="yellow font-18 bold mb-10">الدورة التدريبية</p>
                <p class="font-20 black-2 mb-15 bold two-line course-title">{{ course.title }}</p>
                <div class="d-flex space-between">
                    <div class="d-flex align-center">
                        <span
                            class="bold font-22 main-color ml-15"
                            v-if="!course.is_free && course.price"
                            >{{ course.price }} JD</span
                        >
                        <span
                            class="gray font-19 before-discount bold"
                            v-if="!course.is_free && course.discount.discount_price"
                            >{{ course.discount.discount_price }} JD</span
                        >
                    </div>
                    <span class="bold font-22 main-color"
                        >{{ +course.course_length.split(':')[0] }} ساعات</span
                    >
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    props: ['course'],
    computed:{
        courseSlog(){
            return this.course.title.split(' ').join('-')
        }
    },
    methods: {
        forceRefresh(){
            this.$store.commit("forceRefresh");
        }
    }
};
</script>

<style scoped>
.fav-box {
    position: absolute;
    background-color: rgb(255 255 255 / 90%);
    border-radius: 50%;
    left: 11px;
    top: 14px;
    width: 44px;
    height: 44px;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: .3s;
    z-index: 2;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
.figure-box .play-icon {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    width: 55px;
    height: 55px;
    margin: auto;
}
.before-discount {
    position: relative;
    top: 1px;
}
.before-discount:after {
    content: '';
    position: absolute;
    left: -4px;
    top: -3px;
    bottom: 0;
    margin: auto;
    width: 120%;
    height: 1px;
    background: red;
}
.discount-label {
    background: url(/images/discount-label.svg) no-repeat;
    background-size: 100% 100%;
    width: 130px;
    height: 53px;
    position: absolute;
    bottom: 20px;
    right: 0;
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
.related-courses-section .course-box .course-title {
    height: 60px;
}
</style>
