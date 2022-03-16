<template>
    <div class="course-content-table" >
        <h3 class="title-line font-27 mb-40">{{title}}</h3>
        <div class="list radius-10 overflow-hidden">
            <div v-for="(row,index) in rows" :key="row.lesson_id" class="lecture-box d-flex align-center black-2 font-27 regular">
                <!-- :active -->
                <template v-if="type == 'course'">
                    <div class="tag">
                        <div class="play-video d-flex">
                            <img class="play-icon" src="/images/lock-icon.svg" width="50" height="50" alt="" />
                            <div class="duration">
                                <span class="nowrap">{{row.lesson_length | lessonTime(row.lesson_length)}}</span>
                            </div>
                            <div class="video-name">
                                <span>{{row.lesson_title}}</span>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="type == 'lecture'">
                    <div class="relative w-100">
                        <router-link :class="{'active':isCurrentVideo(row.title)}" class="d-flex tag" :to="getVideoURL(row.title,row.is_complete,index)">
                            <div class="play-video d-flex">
                                <img class="play-icon" :src="getVideoIcon(row.is_complete,index)" width="50" height="50" alt="" />
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
            <div class="lecture-box d-flex align-center black-2 font-27 regular">
                <div class="tag">
                    <div class="play-video d-flex">
                        <img class="play-icon" src="/images/test-icon.svg" width="50" height="50" alt="" />
                        <div class="duration">
                            <span class="nowrap">٢٠ دقيقة</span>
                        </div>
                        <div class="video-name">
                            <span>الإختبار</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lecture-box d-flex align-center black-2 font-27 regular">
                <div class="tag">
                    <div class="play-video d-flex">
                        <img class="play-icon" src="/images/certificate-icon.svg" width="50" height="50" alt="" />
                        <div class="duration">
                            <span class="nowrap">إصدار الشهادة</span>
                        </div>
                        <div class="video-name">
                            <span></span>
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
    },
    methods: {
        isCurrentVideo(title){
            return this.currentVideo.title == title
        },
        getVideoIcon(isComplete, index){
            if (isComplete || index == 0) {
                return `/images/play-icon.svg`
            } else {
                return `/images/unavailable-play-icon.svg`
            }
        },
        getVideoURL(title,isComplete,index) {
            if (isComplete || index == 0) {
                return `/courses/${this.courseTitle.split(' ').join('-')}/${title.split(' ').join('-')}`
            } else {
                return `/`
            }
        }
    },
    created(){
        
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
</style>
