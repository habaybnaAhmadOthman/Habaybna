<template>
  <div class="main">
    <h1>نتائج البحث</h1>
    <h1>مقالات</h1>

    <ul
      v-if="filteredArticles.data && filteredArticles.data.length > 1"
      class="cards"
    >
      <li
        v-for="(item, index) in filteredArticles.data"
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
    <ul v-else class="cards">
      <li class="card no-article">
        <h2>لا يوجد مقالات . . . . . "{{ keyword }}"</h2>
      </li>
    </ul>
      <div class="portal-pagination mt-16 justify-center d-flex">
        <Pagination
          :data="filteredArticles"
          @pagination-change-page="fetchDataArticles"
        ></Pagination>
      </div>
    <h1>دورات تدريبية</h1>

    <ul
      v-if="filteredCourses.data && filteredCourses.data.length > 1"
      class="cards"
    >
      <li
        v-for="(item, index) in filteredCourses.data"
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
    <ul v-else class="cards">
      <li class="card no-article">
        <h2>لا يوجد دورات تدريبية . . . . . "{{ keyword }}"</h2>
      </li>
    </ul>
          <div class="portal-pagination mt-16 justify-center d-flex">
        <Pagination
          :data="filteredCourses"
          @pagination-change-page="fetchData"
        ></Pagination>
      </div>
  </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  // props: ['filtered-articles','showMoreCard','class-list','current-page'],
  components: { Pagination: LaravelVuePagination },
  mounted() {
    //   console.log(this.$route.query.keyWord);
    this.keyword = this.$route.query.keyWord;
    this.fetchData(_, this.keyword);
  },
  data() {
    return {
      keyword: "",
      filteredArticles: [],
      filteredCourses: [],
      filteredSpecialists: [],
      //   atLeastOneSelected: false,
    };
  },
  methods: {
    fetchData(page) {
      if (typeof page === "undefined") {
        console.log(typeof page);
        page = 1;
      }
      const resp = this.callApi(
        "get",
        "/api/get-search-result/?page=" + page + "&keyWord=" + this.keyword
      ).then((res) => {
        if (res.status == 200) {
          // articles
          this.filteredArticles = res.data.articles;
          console.log(this.filteredArticles, res);
          var ids = new Set(res.data.articles.data.map((d) => d.id));
          var merged = [
            ...res.data.articles.data,
            ...res.data.showMoreArticles.data.filter((d) => !ids.has(d.id)),
          ];
          this.filteredArticles.data = merged;

          // courses
          this.filteredCourses = res.data.courses;
          var ids = new Set(res.data.courses.data.map((d) => d.id));
          var mergedC = [
            ...res.data.courses.data,
            ...res.data.showMoreCourses.data.filter((d) => !ids.has(d.id)),
          ];
          this.filteredCourses.data = mergedC;
        }
      });
    },
    fetchDataArticles(page){
              if (typeof page === "undefined") {
        console.log(typeof page);
        page = 2;
      }
            const resp = this.callApi(
        "get",
        "/api/get-search-result/?page=" + page + "&keyWord=" + this.keyword
      ).then((res) => {
        if (res.status == 200) {
          // articles
          this.filteredArticles = res.data.articles;
          console.log(this.filteredArticles, res);
          var ids = new Set(res.data.articles.data.map((d) => d.id));
          var merged = [
            ...res.data.articles.data,
            ...res.data.showMoreArticles.data.filter((d) => !ids.has(d.id)),
          ];
          this.filteredArticles.data = merged;

        }
      });

    },
  },
};
</script>

<style scoped>
.main {
  max-width: 1200px;
  margin: 0 auto;
  /* background-color: white; */
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
.search-pagination{
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
