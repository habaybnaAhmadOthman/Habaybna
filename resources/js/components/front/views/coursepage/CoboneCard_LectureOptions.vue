<template>
    <div class="w-100 lectures-options">
        <router-link class="btn-register-now white-i font-18 font-16-p bold flex-all w-100 pointer mb-20 next-arrow relative trans" :disabled="isLectureFinished" @click.native="forceRefresh" :to="getLectureURL('next')" v-if="hasNextLecture"> التالي</router-link>
        <router-link class="btn-register-now white-i font-18 font-16-p bold flex-all w-100 pointer relative prev-arrow" @click.native="forceRefresh" :to="getLectureURL('prev')" v-if="hasPrevLecture"> السابق</router-link>
        <router-link v-if="isReadyToExam" class="btn-register-now white-i font-18 font-16-p bold flex-all w-100 pointer relative next-arrow" :to="goToExam"> الذهاب الى الإختبار</router-link>
    </div>
</template>

<script>
    export default {
        
        computed: {
            // if this lecture is the first one , then #hide the Prev button
            hasPrevLecture(){
                return this.getLecture().index > 0
            },
            // if this lecture is the last one
            hasNextLecture(){
                return (this.getLecture().index  != this.$store.getters['courses/courseLectures'].length - 1)
            },
            isLectureFinished(){
                var progress = this.$store.getters['courses/course'].course_progress
                return !(progress.length > 0 &&  progress[this.getLecture().index] !== undefined && progress[this.getLecture().index].is_complete)
            },
            isReadyToExam(){
                if (this.getLecture().index  == this.$store.getters['courses/courseLectures'].length - 1)
                    if (this.getCourseData && this.getCourseData.course_progress.length > 0 && this.getCourseData.course_progress[this.getLecture().index] !== undefined && this.getCourseData.course_progress[this.getLecture().index].is_complete == 1)
                        return true
                return  false
            },
            goToExam(){
                return `/courses/${this.getCourseData.title.split(' ').join('-')}/exam`
            },
            getCourseData(){
                return this.$store.getters['courses/course']
            }
        },
        data() {
            return {
                prevLecture: null,
                currentLecture: null
            }
        },
        methods: {
            getLectureByIndex(index) {
                return this.$store.getters["courses/courseLectures"][index]
            },
            getLecture(){
                return this.$store.getters["courses/currentLecture"]
            },
            getLectureURL(type){
                    let lectureTitle;
                    if (type == 'prev') {
                        lectureTitle = this.getLectureByIndex(this.getLecture().index - 1)
                    } else {
                        lectureTitle = this.getLectureByIndex(this.getLecture().index + 1)
                    }
                    lectureTitle = lectureTitle.title.split(' ').join('-')
                    return `/courses/${this.getCourseData.title.split(' ').join('-')}/${lectureTitle}`
            },
            forceRefresh(){
                this.$store.commit("forceRefresh");
            }
        },
    }
</script>

<style scoped>
.btn-register-now {
    background:#632F63;
    border-radius: 25px;
    height: 60px;
    border: 0;
}

.next-arrow:after, .prev-arrow:after {
    content:'';
    background:url(/images/right-arrow-white.png) no-repeat;
    background-size: 15px 24px;
    background-position: center;
    width: 15px;
    height: 24px;
    position: absolute;
    right: 40px;
    top: 0;
    bottom: 0;
    margin: auto;
}
.prev-arrow:after {
    right: auto;
    left: 40px;
    transform: rotate(180deg);
    background:url(/images/arrow-right-color.svg) no-repeat;
    background-size: cover;
}
.prev-arrow {
    background: transparent;
    border: 1px solid #939598;
    color: #363636!important;
}
.lectures-options a:only-of-type {
    margin-bottom: 0!important;
}
a[disabled] {
    opacity: 0.2;
}
@media (max-width: 767px) {
    .btn-register-now {
        height: 50px;
    }
}
</style>