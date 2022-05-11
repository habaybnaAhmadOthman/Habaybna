<template>
    <div class="bg-white big-container" v-if="courseData">
        <div class="d-flex justify-center mt-5">
            <button class="btn-main font-22 bold " @click="capture">حفظ الشهادة</button>
            <router-link class="btn-main font-22 bold mr-20" to="/">عودة إلى الرئيسية</router-link>
            
        </div>
        <div class="certificate do m-side-auto center  mt-10 relative" id="photo">
            <img src="/images/frame.png" alt="" width="908" height="651">
            <div class="main-color font-30 bold name"><span>مبروك </span> <span>{{firstName}}</span></div>
            <div class="cource-title black-2 font-26"><span class="cr p-side-15">لقد أتممت بنجاح <span>دورة التدريب الرقمية </span></span></div>
            <div class="course-descc black-2 font-23">{{course.split('-').join(' ')}}</div>
            <div class="date black-2 font-26"><span class="dr p-side-15"><span>{{day}}</span><span class="p-side-30 month">{{month}}</span><span>{{year}}</span></span></div>
            <div class="hours black-2 font-23">{{ getTime(courseData.course_length) }}</div>
            <div class="slogan black-2 font-20">بشغفكم و تعلمكم المستمر أصبحتم تملكون أحد <br>مفاتيح المستقبل لأبنائنا بمختلف قدراتهم</div>
            <div class="logos">
                <img src="/images/cer-logo.png" alt="" width="85" height="75">
            </div>
        </div>
        <div class="certificate-mo mo m-side-auto center  mt-10 relative">
            <img class="frame-mo" src="/images/frame.png" alt="" width="908" height="651">
            <div class="main-color font-30 bold name-"><span>مبروك </span> <span>{{firstName}}</span></div>
            <div class="cource-title- black-2 font-26"><span class="cr p-side-15">لقد أتممت بنجاح <span>دورة التدريب الرقمية </span></span></div>
            <div class="course-descc- black-2 font-23">{{course.split('-').join(' ')}}</div>
            <div class="date- black-2 font-26"><span class="dr p-side-15"><span>{{day}}</span><span class="p-side-30 month">{{month}}</span><span>{{year}}</span></span></div>
            <div class="hours- black-2 font-23">{{ getTime(courseData.course_length) }}</div>
            <div class="slogan- black-2 font-20">بشغفكم و تعلمكم المستمر أصبحتم تملكون أحد <br>مفاتيح المستقبل لأبنائنا بمختلف قدراتهم</div>
            <div class="logos-">
                <img src="/images/cer-logo.png" alt="" width="85" height="75">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data(){
        return {
            firstName: null,
            day: null,
            month: null,
            year: null,
            courseData: null,
        }
    },
    methods: {
        isLoading(status) {
            this.$store.commit("isLoading", status);
        },
        capture(){
            this.isLoading(true);
            const self = this
            const html2canvas = require('html2canvas');
            if (window.matchMedia("(max-width: 677px)").matches) {
                document.getElementById('photo').classList.add('active');
            }
            html2canvas(document.getElementById('photo')).then(function(canvas){
                let anchor = document.createElement('a');
                anchor.classList.add('download-porpose');
                let dataURL = canvas.toDataURL('image/png');
                let url = dataURL.replace(/^data:image\/png/,'data:application/octet-stream');
                anchor.setAttribute('href',url)
                anchor.setAttribute('download','download.png');
                document.body.appendChild(anchor);
                anchor.click();
                anchor.remove();
                document.getElementById('photo').classList.remove('active');
                self.isLoading(false);
            });
        },
        async getUserData(){
            try {
                this.isLoading(true);
                const obj = await this.$store.getters['user/userData'];
                this.courseData = await this.$store.dispatch('courses/getMyCourseData',this.course);
                await this.$store.dispatch('courses/getCertificateData',this.course);
                this.firstName = obj.firstName;
                const date = new Date().toLocaleDateString("nl",{month:"long", day:"2-digit",year: "numeric"});
                this.day = date.split(' ')[0]
                this.month = new Date().toLocaleDateString("en",{month:"long"})
                this.year = date.split(' ')[2]
            } catch (e) {
                console.log(e)
            }
            this.isLoading(false);
        },
        getTime(seconds) {
            var hms = new Date(seconds * 1000).toISOString().substr(11, 8);
            if (+hms.split(':')[0] > 0) {
                return `${+hms.split(':')[0]} ساعة`
            } else if (+hms.split(':')[1] > 0) {
                return `${+hms.split(':')[1]} دقيقة`
            } else {
                return `${+hms.split(':')[2]} ثواني`
            }
        }
    },
    mounted(){
        this.getUserData()
    }
}
</script>

<style scoped>
.certificate {
    width: 908px;
    height: 651px;
}
.c-el {
    position: absolute;
    top: 0;
    left: 0;
}
.name {
    position: absolute;
    top: 140px;
    width: 100%;
    padding: 0 220px;
}
.cource-title {
    position: absolute;
    top: 204px;
    right: 0;
    text-align: center;
    width: 100%;
    padding: 0 110px;
}
.cource-title .cr, .dr{
    border-bottom: 1px solid #363636;
    padding-bottom: 10px;
}
.course-descc {
    position: absolute;
    top: 263px;
    width: 100%;
    padding: 0 90px;
    max-height: 63px;
    overflow: hidden;
}
.month {
    text-transform: capitalize;
}
.month:before,.month:after {
    content: '';
    background: url(/images/line.png);
    width: 13px;
    height: 21px;
    display: inline-block;
    background-size: 100% 100%;
    transform: translate(-10px, 3px);
}
.month:after {
    transform: translate(10px, 3px)!important;
}
.hours {
    position: absolute;
    top: 377px;
    width: 100%;
}
.slogan {
    position: absolute;
    top: 420px;
    width: 100%;
}
.date {
    position: absolute;
    top: 333px;
    direction: ltr;
    text-align: center;
    width: 100%;
}
.dr {
    padding-bottom: 0;
}
.logos {
    position: absolute;
    width: 100%;
    top: 499px;
    padding: 0 240px;
    text-align: right;
}
@media (max-width: 767px) {
    .frame-mo {
        width: 100%;
        height: auto;
        position: absolute;
        top: 0;
        left: 0;
        pointer-events: none;
    }
    .name- {
        padding-top: 63px;
        font-size: 18px;
    }
    .cource-title- .cr{
        padding-top: 7px;
        font-size: 16px;
            border-bottom: 1px solid #363636;
    }
    .course-descc- {
        font-size: 15px;
        padding: 0 60px;
        max-height: 40px;
        line-height: 19px;
        overflow: hidden;
    }
    .date- {
        padding-top: 5px;
        font-size: 16px;
    }
    .date- .month {
        padding-left: 15px;
        padding-right: 15px;
    }
    .date- .month:before {
        transform: translate(10px, 3px);
    }
    .date- .month:after {
        transform: translate(-10px, 3px)!important;
    }
    .date- .dr {
        display: inline-flex;
        align-items: center;
        flex-direction: row-reverse;
    }
    .hours- {
        font-size: 15px;
    }
    .slogan- {
        font-size: 13px;
        display: none;
    }
    .logos-  {
        padding-right: 110px;
        text-align: right;
    }
    .logos- img {
        width: 40px;
        height: 40px;
    }
    .big-container {
        min-height: 100vh;
    }
    .btn-main {
        font-size: 20px;
    }
    #photo.active {
        display: block!important;
    }
    #photo.active ~ .certificate-mo {
        display: none!important;   
    }
}
</style>