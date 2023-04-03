


<template>
  <div class="container-fluid">
    <TheHeader></TheHeader>
    <div class="habaybna-community">
      <div class="row">
        <CommunityLSide />
        <div class="col-md-6">
          <div class="community-md-side">
            <CummunityFormInput @handelNewPost="handelNewPost" />

            <CommunityPost
              @handelNewComment="handelNewComment"
              v-for="(post, index) in allPosts"
              :key="index"
              :post="post"
            />
          </div>
        </div>
        <CommunityRSide />
      </div>
    </div>
    <div v-if="isLoading">
      <loading-spinner></loading-spinner>
    </div>
  </div>
</template>
<script>
import LoadingSpinner from "../layouts/LoadingSpinner.vue";

import TheHeader from "../layouts/header/TheHeader.vue";
import HabaybnaMedia from "../views/custom/HabaybnaMedia.vue";
import Partners from "../views/custom/Partners.vue";
import CommunityLSide from "../layouts/habaybnacommunity/CommunityLside.vue";
import CommunityRSide from "../layouts/habaybnacommunity/CommunityLside.vue";
import CummunityFormInput from "../layouts/habaybnacommunity/CummunityFormInput.vue";
import CommunityPost from "../layouts/habaybnacommunity/CommunityPost.vue";

export default {
  components: {
    TheHeader,
    HabaybnaMedia,
    Partners,
    CommunityLSide,
    CummunityFormInput,
    CommunityPost,
    CommunityRSide,
    LoadingSpinner,
  },
  emit: ["handelNewPost", "handelNewComment"],
  mounted() {
    this.getAllPosts();
  },
  data() {
    return {
      allPosts: [],
      isLoading: false,
    };
  },
  methods: {
    getAllPosts() {
      this.callApi("get", "/api/posts").then((resp) => {
        this.isLoading = true;
        this.loading();
        this.allPosts = resp.data.data;

        // this.$emit("handelNewPost", resp.data);
      });
    },

    handelNewPost(post) {
      this.isLoading = true;
      this.loading();
      this.allPosts.unshift(post);
      document.getElementById('create-post-txt').value = ""
    },

    loading(time = 500) {
      setTimeout(() => {
        this.isLoading = false;
      }, time);
    },
    handelNewComment(post){
        console.log('comunity post :' ,post );
        let postIndex = this.allPosts.findIndex(x => x.id === post.id)

        // console.log(postIndex, this.allPosts[postIndex]);
        this.allPosts[postIndex].components = post.components

    },
  },
};
</script>
<style scoped>
.habaybna-community {
  margin-top: 42px;
  padding: 0 100px;
}
.community-l-side,
.community-md-side,
.community-r-side {
}
.top-r-side,
.top-md-side,
.top-l-side {
  background-color: #fff;
  border: 1px solid #80808066;
  border-radius: 17px;
  padding: 27px 10px;
  margin-bottom: 15px;
}
.community-r-side,
.community-md-side,
.community-l-side {
}
.community-r-side {
}
.community-md-side {
}

.community-l-side {
}
.top-l-side {
}
img {
  vertical-align: top;
}

/* Create post */
.create-post {
  width: 95%;
  max-width: 660px;
  margin: 0 auto;
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.create-post__avatar {
  width: 65px;
  height: 65px;
  border-radius: 5px;
}

.create-post__form {
  background-color: #fff;
  padding: 20px;
  width: 100%;
  position: relative;
  border-radius: 5px;
}

.create-post__form::after {
  content: " ";
  position: absolute;
  width: 0;
  height: 0;
  /* left: -19px; */
  right: -13px;
  top: 20px;
  bottom: auto;
  border: 10px solid;
  border-color: transparent;
  border-right-color: #fff;
}

/* Dynamic height for text-area:
https://css-tricks.com/the-cleanest-trick-for-autogrowing-textareas/ */
.create-post__text-wrap {
  display: grid;
  margin-bottom: 20px;
}

.create-post__text-wrap::after {
  content: attr(data-replicated-value) " ";
  white-space: pre-wrap;
  visibility: hidden;
}

.create-post__text-wrap > textarea {
  min-height: 70px;
  font-size: 16px;
  color: #757a91;
  resize: none;
  overflow: hidden;
}

.create-post__text-wrap > textarea::placeholder {
  color: #999999;
}

.create-post__text-wrap > textarea,
.create-post__text-wrap::after {
  border: none;
  font: inherit;
  grid-area: 1 / 1 / 2 / 2;
  line-height: 1.5;
  word-break: break-all;
}

.create-post__media-wrap {
  margin-bottom: 20px;
}

.create-post__media-item {
  width: 100%;
  max-width: 140px;
  position: relative;
}

.create-post__media-item button {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #fff;
  border: none;
  padding: 5px;
  border-radius: 50%;
}

.create-post__media-item img {
  width: 100%;
}

.create-post__buttons {
  display: flex;
  gap: 40px;
  justify-content: space-between;
}

.create-post__assets-buttons {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(6, 1fr);
}

#create-post-media {
  display: none;
}

/* Post */
.post {
  width: 95%;
  max-width: 660px;
  margin: 0 auto 40px;
  display: flex;
  gap: 20px;
}

.post__avatar {
  width: 65px;
  height: 65px;
  border-radius: 5px;
}

.post__content {
  border-radius: 5px;
  width: 100%;
  padding: 20px;
  position: relative;
}

.post__content::after {
  content: " ";
  position: absolute;
  width: 0;
  height: 0;
  left: -19px;
  right: auto;
  top: 20px;
  bottom: auto;
  border: 10px solid;
  border-color: transparent;
  border-right-color: #fff;
}

.post__header {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
  align-items: center;
  font-family: var(--secondary-font);
  justify-content: space-between;
}

.post__user {
  font-weight: 600;
  font-size: 14px;
  color: #aeaeae;
}

.post__meta {
  display: flex;
  align-items: center;
  gap: 15px;
}

.post__reblogs {
  color: #fff;
  font-size: 12px;
  font-weight: bold;
  display: inline-block;
  padding: 3px 5px;
  background-color: #aeaeae;
  border-radius: 5px;
}

.post__header-btn {
  border: none;
  background-color: transparent;
  width: 20px;
}

.post__content {
  background-color: #fff;
}

.post__body {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
  margin-bottom: 15px;
}

.post__text {
  font-size: 16px;
  color: #000;
  line-height: 1.5;
}

.post__img {
  width: 100%;
}

.post__footer {
  color: #aeaeae;
  font-size: 14px;
}

/* Buttons */
.create-post__submit {
  background: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.create-post__asset-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 5px 15px;
  color: #51595e;
  font-size: 16px;
  gap: 10px;
  background: none;
  border: none;
}

.create-post__asset-btn:not(:last-child) {
  border-right: 1px solid rgba(100, 117, 137, 0.2);
}

.create-post__asset-btn:disabled {
  opacity: 0.3;
}

.create-post__asset-btn .icon {
  transition: all 0.3s ease;
  width: 40px;
  height: 35px;
}

.create-post__asset-btn:not(:disabled):hover .icon,
.create-post__asset-btn:not(:disabled):focus .icon {
  transform: translateY(-3px);
}

.create-post__submit {
  background-color: #5596e6;
  border: 1px solid transparent;
  border: none;
  color: #fff;
  font-family: inherit;
  font-size: 16px;
  padding: 5px 15px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.create-post__submit:disabled {
  background-color: rgb(186, 235, 255);
}
@media (max-width: 767px) {
  .habaybna-community {
    margin: 0;
    padding: 0;
  }

  .community-l-side,
  .community-r-side {
    display: none;
  }
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>>

