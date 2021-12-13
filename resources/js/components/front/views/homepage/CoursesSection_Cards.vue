<template>
    <div class="d-flex videos-list flex-wrap">
        <template v-if="filteredCourses.length">
            <div
                class="card-video relative"
                v-for="(course, index) in filteredCourses"
                :key="index"
            >
                <span class="course-discount white" v-if="!course.is_free && course.discount.has_discount">خصم {{course.discount.discount_value}}</span>
                <router-link
                    class="d-flex flex-column overflow-hidden h-100"
                    :to="`/courses/${course.id}`"
                >
                    <img
                        :src="course.cover_photo"
                        class="object-fit main-img"
                        alt=""
                        width="100%"
                        height="235"
                    />

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
                    </div>
                    <!-- card body -->
                    <div class="body d-flex flex-column h-100 space-between">
                        <div class="info pt-15 p-side-10 pb-15">
                            <p class="main-color font-20 bold two-line -title mb-5">
                                {{ course.title }}
                            </p>
                            <p
                                class="font-14 main-color source relative d-flex align-center mb-15 gray flex-wrap"
                            >
                            <span v-for="(provider,idx) in course.providers" :key="idx" class="main-bg radius-5 white source-name">
                                {{provider.name}}
                            </span>
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
                                    {{ course.videos_count }} فيديو
                                </p>
                                <p
                                    class="d-flex align-center main-color font-13 mr-20"
                                >
                                    <img
                                        src="/images/siteImgs/header/logo.png"
                                        class="ml-5"
                                        alt=""
                                        width="24"
                                        height="18"
                                    />
                                    {{ course.course_length }} ساعات
                                </p>
                            </div>
                        </div>
                        <div
                            class="card-footer flex-all white pt-15 pb-15 z-1"
                            :class="{ premium: !course.is_free }"
                        >
                            <label class="" v-if="!course.is_free && course.price"
                                ><p class="font-22">{{course.price}} USD</p>
                                <p v-if="course.discount.discount_price" class="font-15 before-discount relative">
                                    USD {{course.discount.discount_price}}
                                </p></label
                            >
                            <label v-else>مجاني</label>
                        </div>
                    </div>
                </router-link>
            </div>
        </template>
        <div v-else class="w-100 center">
            <h2>لا يوجد كورسات في هذه الفئة</h2>
        </div>
    </div>
</template>
<script>
export default {
    props: ["filteredCourses"]
};
</script>

<style scoped>
.videos-list {
    column-gap: 2%;
    row-gap: 20px;
}
.-title {
    height: 40px;
    line-height: 20px;
}
.videos-list .main-img {
    height: 200px;
    min-height: 200px;
}
.card-video {
    width: 23%;
}
.course-discount {
    background: #9c27b0;
    border-radius: 0px 4px 4px 0;
    height: 23px;
    line-height: 22px;
    padding-right: 15px;
    padding-left: 19px;
    left: -10px;
    position: absolute;
    top: 32px;
    text-align: center;
    min-width: 95px;
}
.course-discount:before {
    content: "";
    width: 0;
    height: 0;
    border-top: 6px solid #742083;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -6px;
    left: 0;
}
.card-video a {
    border-radius: 40px;
    box-shadow: 0px 3px 6px #00000029;
}
.source {
    max-height: 20px;
    overflow: hidden;
}
.source:before {
    content: "";
    border-radius: 50%;
    background: #7B7A7B;
    width: 7px;
    height: 7px;
    display: block;
    margin-left: 7px;
}
.card-footer {
    background: #009688;
    min-height: 63px;
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
.source-name {
    padding: 0 4px;
    line-height: 20px;
    margin-left: 5px;
}
@media (max-width: 1100px) {
    .card-video {
        width: 32%;
    }
}
</style>
