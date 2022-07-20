<template>
    <div class="log-table">
        <div class="header d-flex bg-gray">
            <div>اليوم</div>
            <div>الوقت</div>
            <div>الطفل</div>
            <div>ولي الأمر</div>
            <div>المشكلة</div>
            <div>رابط المكالمات</div>
            <div>حالة المكالمة</div>
            <div>التوصية</div>
        </div>
        <div class="body">
            <TableCol></TableCol>
        </div>
    </div>
</template>

<script>
  import TableCol from './CallLog_TableCol.vue'
    export default {
        components: {TableCol}
    }
</script>

<style scoped>
.header {
  padding: 23px 0;
}
.header > div {
  flex: 1;
  text-align: center;
  font-weight: bold;
}
</style>