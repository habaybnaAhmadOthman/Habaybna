<template>
  <div class="mobile-row" :class="dayNameEn">
    <p @click="removeDay" class="row-head black bold">{{dayName}} | <span class="gray">{{dayDate}}</span></p>
    <div class="day-intervals-list flex-wrap">
      <span @click="removeInterval(interval.id)" v-for="(interval,index) in formatedDayIntervals" :key="index">{{interval.val}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['day'],
    emits: ['remove-interval','remove-day'],
    computed: {
      dayDate(){
        return this.day[0].val.slice(0,10).replaceAll('-','.')
      },
      dayName(){
        return new Date(this.day[0].val).toLocaleDateString('ar-EG',{weekday:'long'})
      },
      dayNameEn(){
        return new Date(this.day[0].val).toLocaleDateString('en-US',{weekday:'long'})
      },
      formatedDayIntervals(){
        return this.day.map((interval)=> {
          const val = new Date(interval.val).toLocaleTimeString('en-US',{
            hour:  "2-digit",
            minute: "2-digit",
          })
          return {val:val,id: interval.id}
        })
      },
    },
    methods: {
      removeInterval(intervalID) {
        let shouldUserConfirm = true
        if (isNaN(intervalID) && intervalID.startsWith('no-'))
          shouldUserConfirm = false
        this.$emit('remove-interval',intervalID,shouldUserConfirm)
      },
      removeDay(){
        this.$emit('remove-day',this.day[0].val.slice(0,10))
      }
    }
  }
</script>

<style scoped>
.row-head {
  border: 1px solid #f2f2f2;
  border-radius: 5px;
  padding: 15px 10px 10px 4px;
  background: #fff;
}
.day-intervals-list {
  padding: 15px 10px;
  display: flex;
  gap: 10px;
}
.day-intervals-list span{
    border: 1px solid #ccc;
    padding: 4px 4px 2px 4px;
    border-radius: 8px;
    min-width: 60px;
    text-align: center;
}
.mobile-row {
  background: #fff;
  border-radius: 5px;
  box-shadow: 2px 2px 2px rgb(0 0 0 / 10%);
  border-right: 5px solid yellowgreen;
}
.mobile-row.Saturday {
    border-color: #607d8b;
}
.mobile-row.Sunday {
border-color: #9c27b0;
}
.mobile-row.Monday {
border-color: #6ad500;
}
.mobile-row.Tuesday {
    border-color: #a384ff;
}
.mobile-row.Wednesday {
    border-color: #009688;
}
.mobile-row.Thursday {
    border-color: #03a9f4;
}
.mobile-row.Friday {
border-color: #ff9f02;
}
</style>