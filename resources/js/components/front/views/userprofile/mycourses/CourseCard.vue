<template>
    <div class="course-box bg-white shadow w-31 radius-10 relative w-100-p">
        <div v-if="withFavourite" @click="addToFavourite" :class="{'active':course.is_favourite}" class="fav-box relative pointer"></div>
        <router-link :to="`/courses/${courseSlog}/${getLectureUrl}`">
            <figure class="d-flex relative radius-10 overflow-hidden figure-box">
                <img
                    class="main-img w-100 object-fit"
                    :src="course.cover_photo"
                    height="206"
                    width="auto"
                />
            </figure>

            <div class="p-side-20 pb-10 pt-10">
                <p class="yellow font-18 bold mb-10">الدورة التدريبية</p>
                <p class="font-20 font-18-p black-2 mb-15 bold two-line course-title">{{ course.title }}</p>
                <div class="d-flex space-between">
                    
                    <span class="bold font-22 main-color"
                        >{{ course.course_length }} ساعات</span
                    >
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    props: ['course','withFavourite'],
    computed:{
        courseSlog(){
            return this.course.title.split(' ').join('-')
        },
        getLectureUrl(){
            return this.course.videos_title_length[0].lesson_title.split(' ').join('-')
        }
    },
    methods:{
        async addToFavourite(event) {
            var msg = 'تمت الإضافة إلى المفضلة'
            if (event.target.classList.contains('active')) {
                msg = 'تمت الإزالة من المفضلة'
            }
            event.target.classList.toggle('active')
            await this.$store.dispatch("courses/addToFavourite",{
                courseID:this.course.id
            });
            this.$store.commit("alertDialogMsg", msg);
        },
    },
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
.course-title {
    height: 60px;
}
@media (max-width: 767px) {
    .course-title {
        height: auto;
    }   
}
</style>
