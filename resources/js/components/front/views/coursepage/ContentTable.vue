<template>
    <div class="course-content-table">
        <h3 class="title-line font-27">محتوى الدورة التدريبية</h3>
        <div class="list radius-10 overflow-hidden">
            <div class="lecture-box active d-flex align-center black-2 font-27 regular ">
                <router-link to="/" class="play-video d-flex">
                    <img class="play-icon pointer" src="/images/play-icon.svg" width="50" height="50" alt="" />
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
                    <img class="play-icon pointer" src="/images/lock-icon.svg" width="50" height="50" alt="" />
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
                    <img class="play-icon pointer" src="/images/lock-icon.svg" width="50" height="50" alt="" />
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
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.title-line {
    margin-bottom: 70px;
}
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
