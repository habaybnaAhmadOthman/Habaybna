<template>
  <div class="">
    <div class="box mt-30 flex-wrap-p p-side-12-p">
      <div class="content w-100-p">
        <h1 class="font-40 bold black font-28-p">{{ title }}</h1>
        <router-link :to="authorURL" class="author-box bold mb-20 mt-10 d-flex align-center">
          <img :src="author.avatar | defaultAvatar" class="object-fit rounded" width="40" height="40">
          <div class="mr-10">
            <p class="font-14 main-color trans"> بواسطة : {{author.firstName + ' ' + author.lastName}} </p>
            <p class="font-14 gray trans">{{author.specialization}}</p>
          </div>
        </router-link>
        <div
          class="font-20 black-2 font-18-p pre-line li-auto"
          v-html="description"
        ></div>
        <div class="tags mt-30 d-flex flex-wrap align-center" v-if="tags">
          <p class="bold ml-20">السمات:</p>
          <div class="gap-10 d-flex flex-wrap">
            <Tag v-for="tag in tags" :key="tag.id" :value="tag.title"></Tag>
          </div>
        </div>
      </div>
      <!-- <div class="left-side-col w-100-p mt-20-p">
                <div class="floating-ads">
                    <div class="shadow-2 radius-10 ad-box bg-yellow p-10 mpu">
                        ad 1
                    </div>
                    <div class="shadow-2 radius-10 ad-box bg-soft p-10 mt-15 mpu">
                        ad 2
                    </div>
                </div>
            </div> -->
    </div>
  </div>
</template>

<script>
import Tag from "../../layouts/Tag.vue";
export default {
  props: ["title", "author", "description", "tags"],
  components: {
    Tag,
  },
  computed: {
    authorURL(){
      var url = this.author.firstName.split(' ').join('-')
      if (this.author.lastName)
        url += `-${this.author.lastName.split(' ').join('-')}`

      url += `--${this.author.user_id}`
      return `/specialist/${url}`
    },
  },
  filters: {
      defaultAvatar: function (avatar) {
          if (avatar == 'default.jpg') return '/images/avatars/default.jpg'
          return avatar
      }
  }
};
</script>

<style scoped>
.main-img {
  max-height: 700px;
}
.floating-ads {
  position: sticky;
  top: 10px;
}
.author-box:hover * {
  color: #FF9E00;
}
@media (max-width: 767px) {
}
</style>
