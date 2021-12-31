<template>
    <div class="course-banner mb-50 relative">
        <div class="container h-100">
            <div class="flex-all flex-column h-100 white z-1 center-p p-side-12-p">
                <h2 class="font-40 font-28-p">أهلا بك في زاوية التعلم المخصصة لك</h2>
                <p class="w-70 white font-20 center pre-line desc w-100-p font-18-p">
                    لأن تمكين طفلك يحتاج إلى وقت، تدريب وتعلم مستمر 
                    أفضل الآخصائيين يقدمون لك التدريب لتعليم طفلك مهارات جديدة
                </p>
            </div>
        </div>
    </div>
</template>
<script>
export default {};
</script>

<style scoped>
.course-banner {
    height: 70vh;
    background-image: url(/images/courses-bg.JPG);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.course-banner:before {
    content: '';
    background: rgb(102 0 102 / 50%);
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
.desc {
  margin-top: -25px;
}
@media (max-width: 767px) {
    .course-banner {
        height: 50vh;
        background-attachment:inherit;
        background-size: cover;
        background-position: center;
    }
}
</style>
