<template>
  <div class="main">
    <TheHeader></TheHeader>

    <h1>نتائج البحث</h1>
    <h1
    v-if="data.filteredArticles && data.filteredArticles.data &&  data.filteredArticles.data.length > 0"
    >مقالات</h1>

    <ul
      v-if="data.filteredArticles && data.filteredArticles.data &&  data.filteredArticles.data.length > 0"
      class="cards"
    >
      <li
        v-for="(item, index) in data.filteredArticles.data"
        :key="index"
        class="cards_item"
      >
        <router-link
          class="w-100"
          :to="`/library/${item.title.split(' ').join('-')}`"
        >
          <div class="card">
            <div class="card_content">
              <h2 class="card_title">{{ item.title }}</h2>
              <!-- <p class="card_text">
                Demo of pixel perfect pure CSS simple responsive card grid
                layout
              </p> -->
            </div>
            <div class="card_image">
              <img :src="item.cover_photo" />
            </div>
          </div>
        </router-link>
      </li>
    </ul>
    <!-- <ul v-else class="cards">
      <li class="card no-article">
        <h2>لا يوجد مقالات . . . . . "{{ keyword }}"</h2>
      </li>
    </ul> -->
    <div v-if="data.filteredArticles && data.filteredArticles.data" class= "portal-pagination mt-16 justify-center d-flex">
      <Pagination
        :data="data.filteredArticles"
        @pagination-change-page="fetchDataArticles"
      ></Pagination>
    </div>
    <h1
      v-if="
      data.filteredCourses && data.filteredCourses.data &&
        data.filteredCourses.data.length > 0
      "
    >دورات تدريبية</h1>

    <ul
      v-if="
      data.filteredCourses && data.filteredCourses.data &&
        data.filteredCourses.data.length > 0
      "
      class="cards"
    >
      <li
        v-for="(item, index) in data.filteredCourses.data"
        :key="index"
        class="cards_item"
      >
        <router-link
          class="w-100"
          :to="`/courses/${item.courseTitle.split(' ').join('-')}`"
        >
          <div class="card-course">
            <div class="card_image_course">
              <img :src="item.cover_photo" />
            </div>
            <div class="card_content">
              <h2 class="card_title">{{ item.courseTitle }}</h2>
              <!-- <p class="card_text">
                Demo     of  pixel    perfect    pure   CSS   simple    responsive     card    grid
                layout
              </p> -->
            </div>
          </div>
        </router-link>
      </li>
    </ul>
    <!-- <ul v-else class="cards">
      <li class="card no-article">
        <h2>لا يوجد دورات تدريبية . . . . . "{{ keyword }}"</h2>
      </li>
    </ul> -->
                <h1 v-if="filteredSpecialists.length > 0">  الأخصائيين</h1>
        <div class="d-flex specialist-list flex-wrap row-2" v-if="!isMobile">
            <SpecialistCard v-for="specialist in filteredSpecialists" :key="specialist.user_id" :specialist="specialist"></SpecialistCard>
        </div>
                <div class="relative" v-else>
            <div class="coaches-swiper my-swiper" dir="rtl">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div v-for="specialist in filteredSpecialists" :key="specialist.user_id" class="swiper-slide mobile-slide">
                        <SpecialistCard :specialist="specialist"></SpecialistCard>
                    </div>
                </div>
                <div class="swiper-button-next coaches-next mobile-arrow"></div>
                <div class="swiper-button-prev coaches-prev mobile-arrow"></div>
            </div>

        </div>
    <!-- <div class="portal-pagination mt-16 justify-center d-flex">
        <Pagination
          :data="filteredCourses"
          @pagination-change-page="fetchData"
        ></Pagination>
      </div> -->
  </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import TheHeader from "../layouts/header/TheHeader.vue";
import TheFooter from "../layouts/TheFooter.vue";
import SpecialistCard from '../views/specialists/SpecialistCard.vue'

export default {
  // props: ['filtered-articles','showMoreCard','class-list','current-page'],
  components: { Pagination: LaravelVuePagination, TheFooter, TheHeader, SpecialistCard },
  mounted() {
    this.keyword = this.$route.query.keyWord;
    this.fetchData(1, this.keyword);
  },
  data() {
    return {
      keyword: "",
      data: {
        filteredArticles: [],
        filteredCourses: [],
        filteredSpecialists: [],
      },
      //   atLeastOneSelected: false,
    };
  },
  methods: {
    fetchData(page) {
      if (typeof page === "undefined") {
        const page = 1;
      }
      const resp = this.callApi(
        "get",
        "/api/get-search-result?page=" + page + "&keyWord=" + this.keyword
      ).then((res) => {
        if (res.status == 200) {
          // articles
        //   this.filteredArticles = res.data.articles;
          var ids = new Set(res.data.articles.data.map((d) => d.id));
           this.data.filteredArticles = res.data.articles.data.length > 0 ? res.data.articles : res.data.showMoreArticles

           this.data.filteredArticles.data = [
            ...res.data.articles.data,
            ...res.data.showMoreArticles.data.filter((d) => !ids.has(d.id)),
          ];

          // courses

          var ids = new Set(res.data.courses.data.map((d) => d.id));
           this.data.filteredCourses = res.data.courses.data.length > 0 ? res.data.courses : res.data.showMoreCourses
           this.data.filteredCourses.data = [
            ...res.data.courses.data,
            ...res.data.showMoreCourses.data.filter((d) => !ids.has(d.id)),
          ];
        //   specialists
        this.filteredSpecialists = res.data.specialists

        }
      });
    },
    fetchDataArticles(page) {
      if (typeof page === "undefined") {
        page = 2;
      }
      const resp = this.callApi(
        "get",
        "/api/get-search-result?page=" + page + "&keyWord=" + this.keyword
      ).then((res) => {
        if (res.status == 200) {
          // articles
        //   this.filteredArticles = res.data.articles;
          var ids = new Set(res.data.articles.data.map((d) => d.id));
           this.data.filteredArticles = res.data.articles.data.length > 0 ? res.data.articles : res.data.showMoreArticles

           this.data.filteredArticles.data = [
            ...res.data.articles.data,
            ...res.data.showMoreArticles.data.filter((d) => !ids.has(d.id)),
          ];
        }
      });
    },
  },


};
</script>

<style scoped>
.main {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.main ul {
  margin: 16px 0;
}

h1 {
  font-size: 24px;
  font-weight: 400;
  text-align: center;
  margin-top: 16px;
}
.cards {
  max-width: 1200px;
  /*margin: 0 auto; */
  justify-content: flex-start;
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  margin: 0;
  padding: 0;
}

.cards_item {
  display: flex;
  padding: 1rem;
}

.card {
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
  display: flex;
  /* flex-direction: column; */
  width: 100%;
  overflow: hidden;
  height: 6rem;
  align-items: center;
}
.card_content {
  /* width: 70%; */
  flex-grow: 1;
  padding: 1rem;
  /* background: linear-gradient(to bottom left, #ececec 80%, #9d529d 100%); */
}

.no-article {
  justify-content: center;
  align-items: center;
}

.card_title {
  color: #363636;
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: capitalize;
  margin: 0px;
}
.search-pagination {
  flex-basis: 100%;
  text-align: center;
}
.card_text {
  color: #363636;
  font-size: 0.875rem;
  line-height: 1.5;
  margin-bottom: 1.25rem;
  font-weight: 400;
}
.card_image {
  width: 30%;
  padding: 0.12rem;
}
.card_image_course {
  width: 100%;
  padding: 0.12rem;
}

/* courses section */

.card-course {
  flex-direction: column;
  text-align: center;
  padding: 1rem;
  background-color: white;
  border-radius: 0.25rem;
}
@media (max-width: 767px) {
  .cards_item {
    width: 100%;
    padding: 0.7rem;
  }
}
@media (min-width: 40rem) {
  .cards_item {
    width: 100%;
    padding: 0.2rem;
  }
}

@media (min-width: 56rem) {
  .cards_item {
    width: 33.3333%;
    padding: 0.2rem;
  }
}
</style>
