<template>
    <div class="bg-white big-container" v-if="courseData">
        <div class="d-flex justify-center mt-5">
            <button class="btn-main font-22 bold " @click="capture">حفظ الشهادة</button>
            <router-link class="btn-main font-22 bold mr-20" to="/">عودة إلى الرئيسية</router-link>
            
        </div>
        <div class="certificate do m-side-auto center  mt-10 relative" id="photo">
            <img class="frame" src="/images/frame.jpg" alt="" width="908" height="651">
            <div class="z-1">
                <div class="main-color font-30 bold name"><span>مبروك </span> <span>{{firstName + ' ' + lastName}}</span></div>
                <div class="cource-title black-2 font-23"><span class="cr p-side-15">لقد أتممت بنجاح <span>دورة التدريب الرقمية </span></span></div>
                <div class="course-descc black-2 font-26 bold">{{course.split('-').join(' ')}}</div>
                <div class="hours black-2 font-23">{{ getTime(courseData.course_length) }}</div>
                <div class="date black-2 font-26"><span class=" p-side-15"><span>{{day}}</span><span class="p-side-30 month">{{month}}</span><span>{{year}}</span></span></div>
                <div class="logos">
                    <img src="/images/cer-logo.png" alt="" width="85" height="75">
                    <img v-for="logo in logos" :key="logo" :src="logo" width="85" height="75">
                </div>
            </div>
        </div>
        <div class="certificate-mo mo m-side-auto center  mt-10 relative">
            <img class="frame-mo" src="/images/frame.jpg" alt="" width="908" height="651">
            <div class="z-1">
                <div class="main-color font-30 bold name"><span>مبروك </span> <span>{{firstName + ' ' + lastName}}</span></div>
                <div class="cource-title black-2 font-23"><span class="cr p-side-15">لقد أتممت بنجاح <span>دورة التدريب الرقمية </span></span></div>
                <div class="course-descc black-2 font-26 bold">{{course.split('-').join(' ')}}</div>
                <div class="hours black-2 font-23">{{ getTime(courseData.course_length) }}</div>
                <div class="date black-2 font-26"><span class=" p-side-15"><span>{{day}}</span><span class="p-side-30 month">{{month}}</span><span>{{year}}</span></span></div>
                <div class="logos">
                    <img src="/images/cer-logo.png" alt="" width="85" height="75">
                    <img v-for="logo in logos" :key="logo" :src="logo" width="85" height="75">
                </div>
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
            lastName: null,
            day: null,
            month: null,
            year: null,
            courseData: null,
            logos: []
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
                this.logos = this.courseData.certificate_logos.map(logo => logo.url)
                this.firstName = obj.firstName;
                this.lastName = obj.lastName;
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
.frame {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.c-el {
    position: absolute;
    top: 0;
    left: 0;
}
.name {
    width: 100%;
    padding: 0 90px;
    padding-top: 140px;
}
.cource-title {
    text-align: center;
    width: 100%;
    margin-top: 10px;
}

.course-descc {
    width: 100%;
    padding: 30px 90px 0 90px;
}
.hours {
    width: 100%;
    position: relative;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}
.hours:before {
    content: '';
    background: #363636;
    width: 200px;
    height: 1px;
    display: block;
    background-size: 100% 100%;
    margin-top: 5px;
}
.date {
    margin-top: 20px;
    direction: ltr;
    text-align: center;
    width: 100%;
}

.logos {
    position: absolute;
    width: 100%;
    top: 499px;
    padding: 0 150px;
    text-align: center;
    display: flex;
    justify-content: center;
    gap: 15px;
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
    .certificate-mo .name {
        padding: 0px 20px;
        padding-top: 140px;
        font-size: 23px;
    }
    .certificate-mo .cource-title {
        font-size: 19px;
    }
    .certificate-mo .course-descc {
        width: 100%;
        padding: 0px 5px 0 5px;
        font-size: 22px;
    }
    .certificate-mo .date {
        margin-top: 0;
    }
    .certificate-mo .hours {
        font-size: 16px;
    }
    .certificate-mo .logos {
        position: initial;
        padding: 0 10px;
    }
    
    .certificate-mo .logos img{
        width: 45px;
        height: 45px;
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