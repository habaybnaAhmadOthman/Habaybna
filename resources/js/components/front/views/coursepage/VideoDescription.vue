<template>
    <div class="video-description w-38">
        <h2 class="main-color font-30">معلومات الحلقة</h2>
        <p class="gray font-18">{{lectureInfo}}</p>
    </div>
</template>

<script>
export default {
    props: ['lectureInfo']
}
</script>