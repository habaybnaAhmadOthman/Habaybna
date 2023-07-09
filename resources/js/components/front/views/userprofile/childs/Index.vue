<template>
  <UserProfileContent>
    <template #page-header>
      <h1>حسابات الاطفال</h1>
    </template>
    <template>
      <section class="bg-white p-25 center">
        <!-- modal -->
        <div class="modal w-40" v-if="showModal">
          <div class="d-flex w-100 justify-end">
            <span
              class="close font-23 pl-10 pr-10 pointer"
              @click="showModal = false"
              >x</span
            >
          </div>
          <div class="modal-title mb-20 justify-start d-flex">
            <h3 class="border-bottom">طفلي</h3>
          </div>
          <form
            ref="addChildFom"
            @submit="addChild"
            @submit.prevent
            enctype="multipart/form-data"
          >
            <div class="d-flex child-photo">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>صورة</h4>
                </div>
                <div class="d-flex justify-start pl-5">
                  <p style="text-align: right">
                    تساعدك الصورة في اضفاء طابع شخصي لحساب طفلك
                  </p>
                </div>
              </div>
              <img
                :src="image"
                width="45"
                height="45"
                class="pointer user-avatar user-avatar-get radius-60 object-fit"
                @click="chooseImage"
              />
              <input
                class="file-input"
                ref="fileInput"
                type="file"
                @input="onSelectFile"
              />
            </div>
            <div class="d-flex child-photo">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>تاريخ الميلاد</h4>
                </div>
                <div class="w-100 mt-5">
                  <div class="child-birthday d-flex justify-center w-100">
                    <input
                      type="date"
                      id="birthday"
                      name="birthday"
                      v-model="childInfo.dob"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>اسم الطفل</h4>
                </div>
                <div class="w-100 mt-5">
                  <div class="d-flex justify-center w-100">
                    <input
                      type="text"
                      id="name"
                      class="pb-5 pr-5 pt-5 radius-5 w-100"
                      name="name"
                      v-model="childInfo.name"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>جنس الطفل</h4>
                </div>
                <div class="child-birthday d-flex justify-center mt-5 w-100">
                  <div class="d-flex pb-15 pt-15 space-around">
                    <div class="align-center d-flex ml-20">
                      <input
                        type="radio"
                        id="male"
                        value="M"
                        v-model="childInfo.gender"
                        required
                      />
                      <label for="one">ذكر</label>
                    </div>
                    <div class="align-center d-flex">
                      <input
                        type="radio"
                        id="female"
                        value="F"
                        v-model="childInfo.gender"
                      />
                      <label for="two">انثى</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>هل لدى طفلك حالة خاصة لنمنحك المزيد من الاهتمام؟</h4>
                </div>
                <div class="d-flex w-100">
                  <div class="d-flex pt-10">
                    <input
                      type="checkbox"
                      id="checkbox"
                      v-model="showInterests"
                      @change="handelShowInterests"
                    />
                    <label class="" for="checkbox">نعم</label>
                  </div>
                </div>
                <div
                  v-if="showInterests && intersets.length > 0"
                  class="w-100 mt-5"
                >
                  <div
                    v-for="(interset, index) in intersets"
                    :key="index"
                    class="pt-10 d-flex align-center"
                  >
                    <input
                      type="checkbox"
                      :id="index"
                      v-model="childInfo.selectedIntersests"
                      :value="interset"
                    />
                    <label class="" for="checkbox">{{ interset.title }}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>
                    هل تود مشاركتنا أي أمر آخر عن طفلك ؟ بالتأكيد يسعدنا ذلك
                  </h4>
                </div>
                <div class="d-flex w-100">
                  <div class="d-flex pt-10 w-100">
                    <textarea
                      class="w-100 radius-5"
                      v-model="childInfo.otherInfo"
                      placeholder=""
                      rows="3"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <button class="pb-5 pl-20 pr-20 pt-5 radius-10" type="submit">
                    حفظ
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal w-40" v-if="showModalEdit">
          <div class="d-flex w-100 justify-end">
            <span
              class="close font-23 pl-10 pr-10 pointer"
              @click="showModalEdit = false"
              >x</span
            >
          </div>
          <div class="modal-title mb-20 justify-start d-flex">
            <h3 class="border-bottom">طفلي</h3>
          </div>
          <form
            ref="editChildFom"
            @submit="editChild"
            @submit.prevent
            enctype="multipart/form-data"
          >
            <div class="d-flex child-photo">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>صورة</h4>
                </div>
                <div class="d-flex justify-start pl-5">
                  <p style="text-align: right">
                    تساعدك الصورة في اضفاء طابع شخصي لحساب طفلك
                  </p>
                </div>
              </div>
              <img
                :src="`${selectedChild.photo !== 'default.jpg' ? selectedChild.photo : image}`"
                width="45"
                height="45"
                class="pointer user-avatar user-avatar-get radius-60 object-fit"
                @click="chooseImage"
              />
              <input
                class="file-input"
                ref="fileInputedit"
                type="file"
                @input="onSelectFile"
              />
            </div>
            <div class="d-flex child-photo">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>تاريخ الميلاد</h4>
                </div>
                <div class="w-100 mt-5">
                  <div class="child-birthday d-flex justify-center w-100">
                    <input
                      type="date"
                      id="birthday"
                      name="birthday"
                      v-model="selectedChild.dob.dob"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>اسم الطفل</h4>
                </div>
                <div class="w-100 mt-5">
                  <div class="d-flex justify-center w-100">
                    <input
                      type="text"
                      id="name"
                      class="pb-5 pr-5 pt-5 radius-5 w-100"
                      name="name"
                      v-model="selectedChild.name"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>جنس الطفل</h4>
                </div>
                <div class="child-birthday d-flex justify-center mt-5 w-100">
                  <div class="d-flex pb-15 pt-15 space-around">
                    <div class="align-center d-flex ml-20">
                      <input
                        type="radio"
                        id="male"
                        value="m"
                        v-model="selectedChild.gender"
                        name="gender"
                      />
                      <label for="one">ذكر</label>
                    </div>
                    <div class="align-center d-flex">
                      <input
                        name="gender"
                        type="radio"
                        id="female"
                        value="f"
                        v-model="selectedChild.gender"
                      />
                      <label for="two">انثى</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>الاهتمامات</h4>
                </div>
                <!-- <div class="d-flex w-100">
                  <div class="d-flex pt-10">
                    <input
                      type="checkbox"
                      id="checkbox"
                      v-model="showInterests"
                      @change="handelShowInterests"
                    />
                    <label class="" for="checkbox">نعم</label>
                  </div>
                </div> -->
                <div class="w-100 mt-5">
                  <div
                    v-for="(interset, index) in intersets"
                    :key="index"
                    class="pt-10 d-flex align-center"
                  >
                    <input
                      type="checkbox"
                      :id="index"
                      v-model="selectedChild.interests"
                      :value="interset"
                    />
                    <label class="" for="checkbox">{{ interset.title }}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <h4>عن طفلي :</h4>
                </div>
                <div class="d-flex w-100">
                  <div class="d-flex pt-10 w-100">
                    <textarea
                      class="w-100 radius-5"
                      v-model="selectedChild.other_info"
                      placeholder=""
                      rows="3"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mt-20">
              <div class="d-flex flex-1 flex-column">
                <div class="d-flex justify-start">
                  <button class="pb-5 pl-20 pr-20 pt-5 radius-10" type="submit">
                    حفظ
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div
          class="delete-child d-flex delete-child justify-center flex-column w-40"
          v-if="showModalDelete"
        >
          <h1 class="center">هل انت متأكد من حذف حساب الطفل ؟</h1>
          <div class="d-flex justify-center">
            <div class="d-flex mt-40 space-around w-50">
              <button @click="deleteChild()" class="delete-yes">نعم</button>
              <button
                @click="
                  showModalDelete = false;
                  selectedChild = null;
                  selectedChildIndex = null;
                "
                class="delete-no"
              >
                لا
              </button>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="">
            <div class="childs-list d-flex align-center flex-column">
              <div
                v-for="(child, index) in childs"
                :key="index"
                class="child-card"
              >
                <div class="d-flex mt-10 mb-10">
                  <div class="child-photo">
                    <img
                      :src="`${
                        child.photo !== 'default.jpg' ? child.photo : image
                      }`"
                      width="45"
                      height="45"
                      class="pointer user-avatar user-avatar-get radius-60 object-fit"
                    />
                  </div>
                  <div class="child-info d-flex flex-column mr-20 space-around">
                    <div class="child-name d-flex">
                      <h3>{{ child.name }}</h3>
                      <img
                        class="mr-5"
                        :src="`${
                          child.gender == 'm'
                            ? '/images/siteImgs/male-3-16.png'
                            : '/images/siteImgs/female-2-16.png'
                        }`"
                        alt=""
                        style="width: 16px; height: 16px"
                      />
                    </div>
                    <div class="child-dob d-flex">
                      <strong>
                        <p>{{ child.dob.age }}</p>
                      </strong>
                      <img
                        class="mr-15"
                        src="/images/siteImgs/birthday-cake-24.png"
                        alt=""
                      />
                    </div>
                  </div>
                  <div class="child-edit d-flex flex-1 left">
                    <a class="edit" @click="handelEditChild(index)"> تعديل</a>
                    <a class="delete" @click="handelDeleteChild(index)"> حذف</a>
                  </div>
                </div>
              </div>
              <div class="child-card add-child">
                <div class="d-flex mt-10 mb-10">
                  <div class="child-info">
                    <div class="child-name">
                      <p>
                        <a
                          @click="
                            showModal = true;
                            image = '/images/avatars/default.jpg';
                          "
                        >
                          <strong>+</strong> أضف طفل</a
                        >
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </template>
    <!-- overlay -->
    <div class="overlay" v-if="showModal" @click="showModal = false"></div>
    <div
      class="overlay"
      v-if="showModalEdit"
      @click="showModalEdit = false"
    ></div>
    <div
      class="overlay"
      v-if="showModalDelete"
      @click="showModalDelete = false"
    ></div>
  </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../../views/userprofile/UserProfile_Content.vue";
export default {
  components: { UserProfileContent },
  created() {
    this.callApi("get", "/api/profile/get-childs").then((resp) => {
      this.childs = resp.data;
    });
        this.callApi("get", "/api/get-selected-categories").then((resp) => {
       this.intersets = resp.data;
    });
  },
  data() {
    return {
      image: "/images/avatars/default.jpg",
      showModal: false,
      showModalEdit: false,
      showModalDelete: false,
      showInterests: false,
      childs: [],
      intersets: [],
      childInfo: {
        name: "",
        photo: "",
        dob: "",
        gender: "",
        otherInfo: "",
        selectedIntersests: [],
      },
      selectedChild: null,
      selectedChildIndex: null,
      editChildPhoto: null,
    };
  },

  methods: {
    async handelShowInterests() {
        this.callApi("get", "/api/get-selected-categories").then((resp) => {
       this.intersets = resp.data;
    });
    },
    chooseImage() {
      if (this.showModalEdit) {
        this.$refs.fileInputedit.click();
        return;
      }
      this.$refs.fileInput.click();
    },
    onSelectFile() {
      if (this.showModalEdit) {
        const input = this.$refs.fileInputedit;
        const files = input.files;
        if (files && files[0]) {
          this.editChildPhoto = files[0];

          const reader = new FileReader();
          reader.onload = (e) => {
            this.selectedChild.photo = e.target.result
            this.image = e.target.result;
          };

          reader.readAsDataURL(files[0]);
          this.$emit("input", files[0]);
        }
      } else {
        const input = this.$refs.fileInput;
        const files = input.files;
        if (files && files[0]) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.image = e.target.result;
          };

          this.childInfo.photo = files[0];
          reader.readAsDataURL(files[0]);
          this.$emit("input", files[0]);
        }
      }
    },
    addChild() {
      const childData = new FormData();
      childData.append("name", this.childInfo.name);
      childData.append("photo", this.childInfo.photo);
      childData.append("dob", this.childInfo.dob);
      childData.append("gender", this.childInfo.gender);
      childData.append("other_info", this.childInfo.otherInfo);
      childData.append(
        "selectedIntersests",
        JSON.stringify(this.childInfo.selectedIntersests)
      );
      this.callApi("post", "/api/profile/add-child", childData).then((resp) => {
        if (resp.status == 200) {

          this.childs = resp.data,
          this.childInfo.name = "";
          this.childInfo.photo = "",
            this.childInfo.dob = "",
            this.childInfo.gender = "",
            this.childInfo.otherInfo = "",
            this.childInfo.selectedIntersests = [],
            this.showModal = false;
          this.showInterests = false;
          this.showInterests = false

        }
        if (resp.status == 201) {
          alert("يمكنك اضافة خمسة اطفال كحد اعلى");
          this.showModal = false;
        }
      });
    },
    handelEditChild(index) {
        this.selectedChildIndex = index;
      this.showModalEdit = true;
      this.selectedChild = this.childs[index];
    //   this.image = this.selectedChild.photo;
    },
    handelDeleteChild(index) {
      this.showModalDelete = true;
      this.selectedChild = this.childs[index];
    },
    editChild() {
      const childDataed = new FormData();
      childDataed.append("name", this.selectedChild.name);
      childDataed.append("id", this.selectedChild.id);
      childDataed.append("photo", this.editChildPhoto);
      childDataed.append("dob", this.selectedChild.dob.dob);
      childDataed.append("gender", this.selectedChild.gender);
      childDataed.append("other_info", this.selectedChild.other_info);
      childDataed.append(
        "interests",
        JSON.stringify(this.selectedChild.interests)
      );
      this.callApi("post", "/api/profile/edit-child", childDataed).then(
        (resp) => {
          if (resp.status == 200) {
            this.showModalEdit = false;
            this.image = "/images/avatars/default.jpg";
            this.selectedChild = null;
            this.selectedChildIndex = null;
            this.editChildPhoto = null;
            this.childs = resp.data;
            this.childInfo.photo = null;
          }
        }
      );
    },
    deleteChild() {
      this.callApi(
        "post",
        "/api/profile/delete-child",
        this.selectedChild
      ).then((resp) => {
        if (resp.status == 200) {
          this.childs.splice(this.selectedChildIndex, 1);

          this.selectedChild = null;
          this.showModalDelete = false;
          this.selectedChildIndex = null;
        }
        //   if (resp.status == 201) {
        //     alert("يمكنك اضافة خمسة اطفال كحد اعلى");
        //     this.showModal = false;
        //   }
      });
    },
  },
  computed: {},
};
</script>

<style scoped>
@media (max-width: 767px) {
  .card {
    background: transparent;
    box-shadow: none;
  }
  .modal {
    min-width: 100%;
  }
  .child-card {
    width: 100% !important;
    padding: 0 14px;
  }
  .delete-child {
    width: 100% !important;
  }
}
.child-title {
  display: flex;
  background-color: #fff;
  width: 100%;
  padding: 10px;
}
.child-photo img {
  width: 65px;
  height: 65px;
}
.child-card {
  border-top: 1px solid #9e9e9e;
  width: 50%;
}

.child-card:last-of-type {
  border-bottom: 1px solid #9e9e9e;
}
.child-edit {
  transition: color 0.2s ease;
  /* font-size: 23px; */
  justify-content: end;
}
.child-edit a {
  transition: all 0.2s ease;
  justify-content: end;
  color: #777;
  display: flex;
  align-items: center;
  margin: 0 16px;
}

.child-edit a.edit:hover {
  justify-content: end;
  padding: 0px 32px 0px 8px;
  color: #fff;
  background-color: #47c4ff;
  margin: 0;
}

.child-edit a.delete:hover {
  margin: 0;
  justify-content: end;
  padding: 0px 32px 0px 8px;
  color: #fff;
  background-color: orangered;
}

.overlay {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal {
  position: relative;
  top: 50px;
  z-index: 9999;
  margin: 0 auto;
  padding: 20px 30px;
  background-color: #fff;
  max-height: 100vh;
  overflow-y: scroll;
  border-radius: 8px;
}
.delete-child {
  position: sticky;
  top: 140px;
  z-index: 9999;
  margin: 0 auto;
  padding: 20px 30px;
  background-color: #fff;
  max-height: 100vh;
  border-radius: 8px;
}

.close {
  transition: all 0.3s linear;
  border: 1px solid rgb(255, 255, 255);
  border-radius: 30%;
}
.close:hover {
  border-color: rgb(70, 166, 214);
  border-radius: 40%;
}

.justify-end {
  justify-content: end;
}
input[type="date"] {
  padding: 15px;

  font-family: "Roboto Mono", monospace;
  color: #777;
  font-size: 18px;
  border: none;
  outline: none;
  border-radius: 5px;
}
::-webkit-calendar-picker-indicator {
  background-color: #ffffff;
  padding: 5px;
  cursor: pointer;
  border-radius: 3px;
}
.child-birthday {
  border: 1px solid;
  border-radius: 6px;
}
input[type="radio"],
input[type="checkbox"] {
  zoom: 1.7;
  margin: 2px;
  cursor: pointer;
}
.modal button {
  background-color: #2d8cf0;
  color: #ffff;
  cursor: pointer;
}
.childs-list {
  justify-content: center;
  min-height: 60vh;
}
.child-card:nth-child(1) {
  border: none !important;
}
.file-input {
  display: none;
}
.delete-child button {
  transition: color 0.2s ease;
  background-color: #fff;
  min-width: 42%;
  cursor: pointer;
  border-radius: 3px;
  padding: 9px 35px;
  color: #777;
  border-color: #8888;
}
.delete-child button.delete-yes:hover {
  background-color: #1cb3f8;
  color: #fff;
  border-color: #1cb3f8;
}
.delete-child button.delete-no:hover {
  background-color: orangered;
  color: #fff;
  border-color: orangered;
}
.add-child:only-child {
  color: red;
}
</style>
