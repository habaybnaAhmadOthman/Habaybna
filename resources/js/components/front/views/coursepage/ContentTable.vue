<template>
    <div class="course-content-table p-side-12-p" >
        <h3 class="title-line font-27 mb-40 do">{{title}}</h3>
        <div class="list radius-10 overflow-hidden">
            <div v-for="(row,index) in rows" :key="row.lesson_id" class="relative lecture-box d-flex align-center black-2 font-27 regular">
                <!-- :active -->
                <template v-if="type == 'course'">
                    <div class="relative w-100">
                        <router-link @click.native="forceRefresh" class="d-flex tag" :to="getVideoURLIfAvailable(index,row.lesson_title)">
                            <div class="play-video d-flex">
                                <img class="play-icon" :src="getCourseVideoIcon(index)" width="50" height="50" alt="" />
                                <div class="duration">
                                    <span class="nowrap black-2">{{row.lesson_length | lessonTime(row.lesson_length)}}</span>
                                </div>
                                <div class="video-name black-2">
                                    <span>{{row.lesson_title}}</span>
                                </div>
                            </div>
                        </router-link>
                        <span class="prevent-click"></span>
                    </div>
                </template>
                <template v-else-if="type == 'lecture'">
                    <div class="relative w-100">
                        <router-link @click.native="forceRefresh" :class="{'active':isCurrentVideo(row.title)}" class="d-flex tag" :to="getVideoURLIfAvailable(index,row.title)">
                            <div class="play-video d-flex">
                                <img class="play-icon" :src="getCourseVideoIcon(index)" width="50" height="50" alt="" />
                                <div class="duration">
                                    <span class="nowrap black-2">{{row.length | lessonTime(row.length)}}</span>
                                </div>
                                <div class="video-name">
                                    <span class="black-2">{{row.title}}</span>
                                </div>
                            </div>
                        </router-link>
                        <span class="prevent-click"></span>
                    </div>
                </template>
            </div>
            <div class="relative test lecture-box d-flex align-center black-2 font-27 regular">
                <div class=" w-100">
                    <router-link class="d-flex tag" :to="isReadyToExam">
                        <div class="play-video d-flex">
                            <img class="play-icon" src="/images/test-icon.svg" width="50" height="50" alt="" />
                            <div class="duration">
                                <span class="nowrap black-2">٢٠ دقيقة</span>
                            </div>
                            <div class="video-name black-2">
                                <span>الإختبار</span>
                            </div>
                        </div>
                    </router-link>
                    <span class="prevent-click"></span>
                </div>
            </div>
            <div class="relative certificate lecture-box d-flex align-center black-2 font-27 regular">
                <div class="tag">
                    <div class="play-video d-flex">
                        <img class="play-icon" src="/images/certificate-icon.svg" width="50" height="50" alt="" />
                        <!-- <img class="play-icon" src="/images/certificate-icon-color.svg" width="50" height="50" alt="" /> -->
                        <div class="duration do">
                            <span class="nowrap">إصدار الشهادة</span>
                        </div>
                        <div class="video-name">
                            <span class="mo">إصدار الشهادة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title','rows','type','currentVideo'],
    data(){
        return {
            currentLecture: null,
            courseData: null,
            isDataReady: false,
        }
    },
    filters: {
        lessonTime(videoLength){
            if (+videoLength.split(':')[0] > 0) {
                return `${videoLength} ساعة`
            } else {
                return `${videoLength} دقيقة`
            }
        }
    },
    computed: {
        courseTitle(){
            return this.$store.getters['courses/course'].title;
        },
        isReadyToExam(){
            if (this.courseData && this.courseData.course_progress && this.courseData.course_progress && this.courseData.course_progress[this.courseData.course_progress.length - 1].is_complete) {
                return `/courses/${this.courseData.title.split(' ').join('-')}/exam`
            } else
                return '/'
        },
    },
    methods: {
        isCurrentVideo(title){
            return this.currentVideo.title == title
        },
        getCourseProgress(){
            this.courseData = this.$store.getters['courses/course']
        },
        // for course page use
        getCourseVideoIcon(index){
            if (
                index == 0 ||
                // this.courseData.course_progress[index].is_complete == 1 ||
                (
                    this.courseData.course_progress && 
                    this.courseData.course_progress[index - 1].is_complete == 1
                )
            ) {
                return `/images/play-icon.svg`
            } else {
                if (this.type == 'course')
                    return `/images/lock-icon.svg`
                else
                    return `/images/unavailable-play-icon.svg`
            }
        },
        // for course page use
        getVideoURLIfAvailable(index,title){
            if (!this.courseData)
                this.getCourseProgress()
            
            if (
                index == 0 ||
                // this.courseData.course_progress[index].is_complete == 1 ||
                (this.courseData.course_progress && this.courseData.course_progress[index - 1].is_complete == 1)
                ) {
                    title = title.split(' ').join('-')
                    return `/courses/${this.courseTitle.split(' ').join('-')}/${title.split(' ').join('-')}`
                } else {
                    return `/`
                }
                
        },
        getVideoIcon(isComplete, index){
            if (isComplete || index == 0) {
                return `/images/play-icon.svg`
            } else {
                return `/images/unavailable-play-icon.svg`
            }
        },
        forceRefresh(){
            this.$store.commit("forceRefresh");
        },
    },
    mounted(){
        // to get available lectures
        
    },
};
</script>

<style scoped>
.list {
    background-color: #f2f2f2;
    box-shadow: 0px 3px 9px #00000029;
}
.lecture-box  .tag{
    padding: 25px 60px 25px 20px;
    width: 100%;
}
.lecture-box  .tag > * {
    width: 100%;
}
.lecture-box .tag:not(.active) {
    border-bottom: 2px solid #fff;
}
.lecture-box:last-of-type .tag{
    border-bottom: none;
}
.lecture-box  .tag.active {
    background: rgb(167 167 167 / 50%);
    box-shadow: 0px 3px 6px #00000029;
    mix-blend-mode: multiply;
}
.duration {
    margin-right: 117px;
    margin-left: 100px;
}
.no-pointer {
    cursor: default;
}
.prevent-click {
    position :absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    display: none;
}
[href="/"] + .prevent-click {
    display: block;
}
@media (max-width: 767px) {
    .lecture-box .tag {
        padding: 25px 16px 25px 16px;
    }
    .duration {
        position: absolute;
        left: 8px;
        bottom: 8px;
        margin: 0;
        font-size: 14px;
    }
    .video-name {
        font-size: 16px;
        margin-right: 16px;
        margin-left: 0;
        display: flex;
        align-items: center;
        justify-content:center;
    }
}
</style>
