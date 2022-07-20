<template>
  <div class="log-col">
    <!-- date -->
    <div>
      <p class="bold">الاثنين</p><p class="font-13 gray"> 25.08.2022</p>
    </div>

    <!-- time -->
    <div class="bold">
      م5:30
    </div>

    <!-- child -->
    <div>
      <p class="bold">عبد السميع الفرنجي</p>
      <p class="font-13 gray">اضطراب طيف التوحد</p>
    </div>
    
    <!-- parent -->
    <div>
      <p class="bold">نسرين محمد الزين</p>
      <p class="font-13 gray">السعودية</p>
    </div>
    
    <!-- problem -->
    <div>
      <p>ابني متأخر في الكلام ولا أعرف</p>
    </div>
    
    <!-- problem -->
    <div class="blue">
      <p>https://docs.g.....</p>
    </div>
    
    <!-- call status -->
    <div class="call-status">
      <p>مجدولة</p>
    </div>
    
    <!-- recommendation -->
    <div class="recommendation">
      <p>لايمكن الكتابة إلا بعد أن تصبح ناجحة</p>
    </div>


  </div>
</template>

<script>
  export default {
    
  }
</script>

<style scoped>
.log-col {
  padding: 10px 5px 10px 0;
  display: flex;
      align-items: center;
}
.log-col > div {
  flex: 1;
  font-size: 14px;
  padding: 0 5px;
  /* text-align: center; */
}
</style>