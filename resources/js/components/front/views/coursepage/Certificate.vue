<template>
    <div>
        <div class="d-flex justify-center">
            <button class="btn-main font-30 bold" @click="capture">حفظ الشهادة</button>
        </div>
        <div class="certificate m-side-auto center  mt-10 relative" id="photo">
            <img src="/images/frame.png" alt="" width="908" height="651">
            <div class="main-color font-30 bold name"><span>مبروك </span> <span>ريم</span></div>
            <div class="cource-title black-2 font-26"><span class="cr p-side-15">لقد أتممت بنجاح <span>دورة التدريب الرقمية </span></span></div>
            <div class="course-descc black-2 font-23">الأطفال المتأخرين بالتطور </div>
            <div class="date black-2 font-26"><span class="dr p-side-15"><span>30</span><span class="p-side-30 month">June</span><span>2022</span></span></div>
            <div class="hours black-2 font-23">15 ساعة</div>
            <div class="slogan black-2 font-20">بشغفكم و تعلمكم المستمر أصبحتم تملكون أحد <br>مفاتيح المستقبل لأبنائنا بمختلف قدراتهم</div>
            <div class="logos">
                <img src="/images/cer-logo.png" alt="" width="85" height="75">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        capture(){
            const html2canvas = require('html2canvas');
            console.log('Function Screenshot');
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
            });
        }
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
    top: 275px;
    width: 100%;
    padding: 0 90px;
    max-height: 63px;
    overflow: hidden;
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
    top: 394px;
    width: 100%;
}
.slogan {
    position: absolute;
    top: 429px;
    width: 100%;
}
.date {
    position: absolute;
    top: 350px;
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
</style>