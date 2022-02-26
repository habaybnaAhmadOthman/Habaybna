<template>
    <div class="company-banner relative pt-25 pb-55">
        <div class="container z-1">
            <div class="w-85">
                <h2 class="title-line mb-40">للمؤسسات</h2>
                <p class="font-25 gray bold mb-20">هل أنتم أحد المؤسسات أو المراكز أو المدارس التي  ترغب بشراء حزمة لتدريب مموظفيكم أو عملائكم؟</p>
                <p class="font-22 gray bold">يمكنكم الاستفادة من خصم المجموعة للمؤسسات والشركات تواصلوا معنا عبر <span class="main-color bold font-24 mr-10">community@habaybna.net</span> وسيقوم فريق منصة حبايبنا.نت بالتواصل معكم</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
.company-banner {
    background:#f4f0f4;
}
.company-banner:before {
    content:'';
    left: 40px;
    top: 0;
    width: 434px;
    height: 100%;
    background: url(/images/company-banner.png) no-repeat;
    position: absolute;
    opacity: .3;
    background-size: contain;
}
</style>