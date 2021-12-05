<template>
    <div class="d-flex videos-list flex-wrap">
        <template v-if="filteredCourses.length">
            <div
                class="card-video ml-25 mb-25 overflow-hidden relative"
                v-for="(course, index) in filteredCourses"
                :key="index"
            >
                <img
                    src="/images/siteImgs/1.jpg"
                    class="object-fit"
                    alt=""
                    width="100%"
                    height="235"
                />
                <svg class="corner" xmlns="http://www.w3.org/2000/svg">
                    <path></path>
                </svg>

                <!-- tools -->
                <div
                    class="card-tools p-side-15 d-flex space-between align-center w-100"
                >
                    <div class="fav-box relative">
                        <img
                            width="36"
                            height="36"
                            src="https://www.arabiaweather.com/farms/assets/images/favourite-add.svg"
                            class="add pointer"
                        />
                        <img
                            width="36"
                            height="36"
                            src="https://www.arabiaweather.com/farms/assets/images/favourite-added-offer.svg"
                            class="remove pointer"
                        />
                    </div>
                    <p class="tag radius-60 p-side-10 white">
                        {{ course.category }}
                    </p>
                </div>
                <!-- info -->
                <div class="info pt-30 p-side-15">
                    <p class="main-color font-16 bold two-line">
                        {{ course.title }}
                    </p>
                    <p
                        class="font-14 main-color source relative d-flex align-center mb-10"
                    >
                        {{ course.provider }}
                    </p>
                    <p class="three-line gray mb-25 desc">
                        {{ course.description }}
                    </p>
                    <div class="about d-flex align-center">
                        <p class="d-flex align-center main-color font-13">
                            <img
                                src="/images/siteImgs/header/logo.png"
                                class="ml-5"
                                alt=""
                                width="24"
                                height="18"
                            />
                            {{ course.video }} فيديو
                        </p>
                        <p class="d-flex align-center main-color font-13 mr-20">
                            <img
                                src="/images/siteImgs/header/logo.png"
                                class="ml-5"
                                alt=""
                                width="24"
                                height="18"
                            />
                            {{ course.hours }} ساعات
                        </p>
                    </div>
                </div>
                <div
                    class="card-footer flex-all white pt-15 pb-15 z-1"
                    :class="{ premium: course.price }"
                >
                    <label class="" v-if="course.price"
                        ><p>50 USD</p>
                        <p class="font-13 before-discount relative">
                            USD 100
                        </p></label
                    >
                    <label v-else>مجاني</label>
                </div>
            </div>
        </template>
        <div v-else class="w-100 center">
            <h2>لا يوجد كورسات في هذه الفئة</h2>
        </div>
    </div>
</template>
<script>
export default {
    props: ["filteredCourses"],
    methods: {}
};
</script>

<style scoped>
.card-video {
    width: 23%;
}
.card-video {
    border-radius: 40px;
    box-shadow: 0px 3px 6px #00000029;
}
.corner {
    position: absolute;
    top: 0;
    right: 0;
    width: 80px;
    height: 80px;
    top: 123px;
}
.corner path {
    fill: #fff;
    d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z");
}
.info {
    background: #fff;
    z-index: 1;
    position: relative;
    border-radius: 40px 0 0 0;
    padding-bottom: 40px;
    transform: translateY(-40px);
}
.source:before {
    content: "";
    border-radius: 50%;
    background: #660066;
    width: 7px;
    height: 7px;
    display: block;
    margin-left: 7px;
}
.card-footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: #009688;
    height: 58px;
}
.desc {
    height: 72px;
}
.card-tools {
    position: absolute;
    z-index: 1;
    right: 0;
    top: 25px;
}
.fav-box .remove {
    position: absolute;
    right: 0;
    top: 0;
    opacity: 0;
    pointer-events: none;
}
.fav-box .add.active ~ .remove {
    opacity: 1;
    pointer-events: initial;
}

.tag {
    background: #eb7676;
}
.premium {
    background: #660066;
}
.discount {
    position: absolute;
    top: 7px;
    color: #eb7676;
}
.before-discount:before {
    content: "";
    width: 100%;
    height: 1px;
    background: #fff;
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    transform: rotate(-2deg);
}
.before-discount {
    position: absolute;
    bottom: 5px;
    left: 0;
    right: 0;
    margin: auto;
    display: flex;
    max-width: fit-content;
}
</style>
