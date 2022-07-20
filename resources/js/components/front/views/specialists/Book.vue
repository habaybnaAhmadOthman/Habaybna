<template>
  <div class="book-box">
    <p class="font-20 bold main-color mb-20">إختر اليوم</p>
    <div class="d-flex box flex-wrap">
      <RadioTag
        v-for="item in items"
        :key="item.id"
        :item="item"
        :isDay="true"
        @on-day-select="onDaySelect"
      ></RadioTag>
    </div>

    <!-- start time container -->
    <div class="mt-30" v-if="selectedDay !== null">
      <p class="font-20 bold main-color mb-20">إختر الوقت</p>
      <div class="d-flex box flex-wrap">
        <RadioTag
          v-for="item in items[selectedDay].availableTimes"
          :key="item.id"
          :item="item"
          :isDay="false"
          @on-time-select="onTimeSelect"
        ></RadioTag>
      </div>

      <div class="mt-40 d-flex flex-wrap ">
        <div class="d-flex w-38 ml-20 w-100-p m-0-p mb-20-p">
          <CoboneForm></CoboneForm>
        </div>
        <button :disabled="canSubmit" @click="submit" class="btn w-100-p">
          إحجز موعدك
        </button>
      </div>
    </div>
    <!-- end time container -->

    <div class="price-box w-50 mt-30 d-flex align-center space-between w-100-p">
        <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> $45</span></p>
        <p class="font-20 main-color bold d-flex"><img class="ml-10" src="/images/test.jpg" width="22" height="22" alt="الأخصائيين" ><span> 30 دقيقة</span></p>
    </div>

  </div>
</template>

<script>
import RadioTag from "./Book_RadioTag.vue";
import CoboneForm from "./CoboneForm.vue";
export default {
  components: { RadioTag,CoboneForm },
  methods: {
    onDaySelect(id) {
      this.items.map((item, index) => {
        if (item.id == id) {
          // remove selected time from prev selected day
          if (
            !item.selected &&
            this.selectedDay != null &&
            this.selectedTime != null
          ) {
            this.items[this.selectedDay].availableTimes[this.selectedTime].selected = false;
            this.selectedTime = null
          }
          item.selected = true;
          this.selectedDay = index;
        } else item.selected = false;
      });
    },
    onTimeSelect(id) {
      this.items[this.selectedDay].availableTimes.map((item, index) => {
        if (item.id == id) {
          item.selected = true;
          this.selectedTime = index;
        } else item.selected = false;
      });
    },
    submit() {
      console.log(
        this.items[this.selectedDay].availableTimes[this.selectedTime]
      );
    },
  },
  computed: {
    canSubmit() {
      console.log(this.selectedDay == null || this.selectedTime == null)
      return this.selectedDay == null || this.selectedTime == null;
    },
  },
  data() {
    return {
      items: [
        {
          id: 1,
          date: "2022-06-15 13:00:00",
          selected: false,
          availableTimes: [
            {
              id: 1,
              date: "2022-06-15 11:00:00",
              selected: false,
            },
            {
              id: 2,
              date: "2022-06-16 15:00:00",
              selected: false,
            },
            {
              id: 3,
              date: "2022-06-17 17:00:00",
              selected: false,
            },
          ],
        },
        {
          id: 2,
          date: "2022-06-16 15:00:00",
          selected: false,
          availableTimes: [
            {
              id: 1,
              date: "2022-06-11 03:00:00",
              selected: false,
            },
            {
              id: 2,
              date: "2022-06-12 04:00:00",
              selected: false,
            },
            {
              id: 3,
              date: "2022-06-13 05:00:00",
              selected: false,
            },
          ],
        },
        {
          id: 3,
          date: "2022-06-17 17:00:00",
          selected: false,
        },
      ],
      selectedDay: null,
      selectedTime: null,
    };
  },
};
</script>

<style scoped>
.book-box .box {
  gap: 20px;
}
.btn {
  border-radius: 30px;
  width: 250px;
}
.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}
@media (max-width: 767px) {
    .btn {
      height: 50px;
    }
}
</style>