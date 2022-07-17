<template>
    <div class="course-box bg-white shadow w-31 radius-10 relative w-100-p">
        <!-- <div @click="addToFavourite" :class="{'active':course.is_favourite}" class="fav-box relative pointer"></div> -->
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
                <DiscountLabel :is-free="course.is_free" 
                :hasDiscount="course.discount.has_discount" 
                :discountValue="course.discount.discount_value" />
            </figure>

            <div class="p-side-20 pb-10 pt-10">
                <p class="yellow font-16 bold mb-10">الدورة التدريبية</p>
                <p class="font-20 font-18-p black-2 mb-15 bold two-line course-title">{{ courseTitle }}</p>
                <div class="d-flex space-between">
                    <div class="d-flex align-center">
                        <template v-if="course.discount.has_discount">
                        <span
                            class="bold font-22 main-color ml-15"
                            v-if="!course.is_free && course.discount.discount_price"
                            >{{ course.discount.discount_price }} $</span
                        >
                        <span
                            class="gray font-19 before-discount bold"
                            v-if="!course.is_free && course.price"
                            
                            >{{ course.price }} $</span
                        >
                        </template>
                        <template v-else-if="!course.is_free && course.price">
                            <span
                            class="bold font-22 main-color ml-15"
                            v-if="!course.is_free && course.price"
                            >{{ course.price }} $</span
                        >
                        </template>
                    </div>
                    <span class="gray font-18"
                        >{{ getTime }}</span
                    >
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
import DiscountLabel from './Card_DiscountLabel.vue'
export default {
    props: ['course'],
    components: {DiscountLabel},
    computed:{
        courseSlog(){
            if (this.course.title)
                return this.course.title.split(' ').join('-')
            else
                return this.course.courseTitle.split(' ').join('-')
        },
        isLoggedIn() {
            return this.$store.getters["user/isLoggedIn"];
        },
        courseTitle(){
            if (this.course.title)
                return this.course.title.split(' ').join('-')
            else
                return this.course.courseTitle
        },
        getTime(){
            if (this.course.course_length) {
                var hms = new Date(this.course.course_length * 1000).toISOString().substr(11, 8);
                if (+hms.split(':')[0] > 0) {
                    return `${+hms.split(':')[0]} ساعة`
                } else if (+hms.split(':')[1] > 0) {
                    return `${+hms.split(':')[1]} دقيقة`
                } else {
                    return `${+hms.split(':')[2]} ثواني`
                }
            }
            return ''
        }
    },
    methods: {
        forceRefresh(){
            this.$store.commit("forceRefresh");
        },
        // async addToFavourite(event) {
        //     if (this.isLoggedIn) {
        //         event.target.classList.toggle('active')
        //         await this.$store.dispatch("courses/addToFavourite",{
        //             courseID:this.course.id
        //         });
        //     } else {
        //         this.$store.commit('loginModal',true);
        //     }
        // },
        
    },
    mounted(){
        
    }
};
</script>

<style scoped>
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
.course-box .course-title {
    height: 60px;
}
@media (max-width: 767px) {
    .fav-box {
        width: 40px;
        height: 40px;
    }
    .course-box .course-title {
        height: auto;
    }
}
</style>
