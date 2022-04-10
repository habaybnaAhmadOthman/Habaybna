<template>
    <div class="library-banner">
        <div class="container h-100">
            <div class="box flex-all flex-wrap h-100">
                <div>
                    <h1 class="w-100 font-50 bold white relative main-title">نضع بين يديك مكتبة رقمية تضم أكثر من 1000 معلومة</h1>
                    <h2 class="w-100 white font-30 bold mt-20">يقدمها المختصين لمساعدتك في تمكين طفلك</h2>
                    <h3 class="w-100 white font-40 bold">مقالات - فيديوهات - ندوات رقمية - صور توضيحية</h3>
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
    .library-banner {
        height: 621px;
        background: url(/images/register-bg.jpg) no-repeat center;
    }
    .main-title:after {
        content: '';
        display: block;
        width: 100%;
        height: 5px;
        background: #FF9E00;
        border-radius: 20px;
        margin-top: 5px;
    }
</style>