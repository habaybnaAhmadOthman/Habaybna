<template>
    <div class="course-content-table">
        <h3 class="title-line font-27 mb-40">{{title}}</h3>
        <div class="list radius-10 overflow-hidden">
            <div v-for="(row) in rows" :key="row.lesson_id" class="lecture-box d-flex align-center black-2 font-27 regular">
                <!-- :active -->
                <template v-if="type == 'course'">
                    <div class="play-video d-flex">
                        <img class="play-icon" src="/images/lock-icon.svg" width="50" height="50" alt="" />
                        <div class="duration">
                            <span class="nowrap">{{row.lesson_length | lessonTime(row.lesson_length)}}</span>
                        </div>
                        <div class="video-name">
                            <span>{{row.lesson_title}}</span>
                        </div>
                    </div>
                </template> 
            </div>
            <!-- <div class="lecture-box d-flex align-center black-2 font-27 regular ">
                <router-link to="/" class="play-video d-flex">
                    <img class="play-icon pointer" src="/images/test-icon.svg" width="50" height="50" alt="" />
                </router-link>
                <div class="duration">
                    <span class="nowrap">٢٠ دقيقة</span>
                </div>
                <div class="video-name">
                    <span>المفاهيم و المصطلحات الأساسية لتحليل السلوك التطبيقي</span>
                </div>
            </div>
            <div class="lecture-box d-flex align-center black-2 font-27 regular ">
                <router-link to="/" class="play-video d-flex">
                    <img class="play-icon pointer" src="/images/certificate-icon.svg" width="50" height="50" alt="" />
                </router-link>
                <div class="duration">
                    <span class="nowrap">٢٠ دقيقة</span>
                </div>
                <div class="video-name">
                    <span>المفاهيم و المصطلحات الأساسية لتحليل السلوك التطبيقي</span>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    props: ['title','rows','type'],
    filters: {
        lessonTime(videoLength){
            if (+videoLength.split(':')[0] > 0) {
                return `${videoLength} ساعة`
            } else {
                return `${videoLength} دقيقة`
            }
            
        }
    }
};
</script>

<style scoped>
.list {
    background-color: #f2f2f2;
    box-shadow: 0px 3px 9px #00000029;
}
.lecture-box {
    padding: 25px 60px 25px 20px;
}
.lecture-box:not(.active){
    border-bottom: 2px solid #fff;
}
.lecture-box:last-of-type{
    border-bottom: none;
}
.lecture-box.active {
    background: rgb(167 167 167 / 50%);
    box-shadow: 0px 3px 6px #00000029;
    mix-blend-mode: multiply;
}
.duration {
    margin-right: 117px;
    margin-left: 100px;
}
</style>
