<template>
  <div class="">
    <p class="font-20 main-color font-18-p bold mb-10">ملخص عن الأخصائي</p>
    <p class="font-18 black-2 font-16-p mb-20">منصة حبايبنا.نت هي منصة رقمية عربية تهدف إلى تمكين الوالدين ومقدمي الرعاية العرب ليستطيعوا تحسين حياة الأطفال المتأخرين في التطور بمختلف مجالات الحياة. يتكون فريق التحرير من مجموعة من الأخصائيين في التربية الخاصة أو التأهيل بالإضافة إلى محرري المحتوى.</p>
    <p class="font-20 main-color font-18-p bold mb-10">المؤهل العلمي</p>
    <p class="font-18 black-2 font-16-p mb-20">بكالوريوس تربية</p>
    <p class="font-20 main-color font-18-p bold mb-10">عدد سنوات الخبرة</p>
    <p class="font-18 black-2 font-16-p mb-20">5</p>
    <p class="font-20 main-color font-18-p bold mb-10">التخصص والخبرات</p>
    <div class="gap-10 d-flex flex-wrap">
      <Tag :classes="'yellow'" :value="'أطفال'"></Tag>
      <Tag :classes="'yellow'" :value="'أطفال'"></Tag>
      <Tag :classes="'yellow'" :value="'أطفال'"></Tag>
    </div>
  </div>
</template>

<script>
  import Tag from '../../layouts/Tag.vue'
  export default {
    components: {Tag}
  }
</script>

<style scoped>

</style>