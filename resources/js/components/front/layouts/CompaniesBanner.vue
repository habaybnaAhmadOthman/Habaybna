<template>
    <div>
        <h2 class="title-line mb-20 mo p-side-12-p">للمؤسسات</h2>
        <div class="company-banner relative pt-25 pb-55 pt-20-p pb-10-p">
            <div class="container z-1 p-side-12-p">
                <div class="w-85 w-100-p">
                    <h2 class="title-line mb-40 do">للمؤسسات</h2>
                    <p class="font-25 gray bold mb-20 font-18-p">هل أنتم أحد المؤسسات أو المراكز أو المدارس التي  ترغب بشراء حزمة لتدريب مموظفيكم أو عملائكم؟</p>
                    <p class="font-22 gray bold font-16-p desc">يمكنكم الاستفادة من خصم المجموعة للمؤسسات والشركات تواصلوا معنا عبر <span class="main-color bold font-24 mr-10 font-16-p m-0-p">community@habaybna.net</span> وسيقوم فريق منصة حبايبنا.نت بالتواصل معكم</p>
                </div>
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
    opacity: 0.1;
    background-size: contain;
}
@media (max-width: 767px) {
    .company-banner[data-v-f6f7d8c0]:before {
        content: '';
        left: 0;
        top: auto;
        bottom: 0;
        width: 205px;
        height: 159px;
    }
    .desc,.desc span {
        font-family: "Baloo"!important;
    }
}

</style>