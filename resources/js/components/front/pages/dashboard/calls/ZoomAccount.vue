<template>
  <UserProfileContent>
    <template #page-header>
      <h1>اعدادات حساب zoom</h1>
    </template>
    <template>
      <section class="pb-50">
        <div class="zoom-account">
          <div class="zoom-logo">
            <img
              src="https://d24cgw3uvb9a9h.cloudfront.net/static/93386/image/new/ZoomLogo.png"
              class="zoom-logo"
              alt="Zoom Logo"
            />
            <!--customize company logo-->
          </div>
          <div class="zoom-form">
            <form action="" @submit="checkForm">
                  <p v-if="errors.length">
                        <ul>
                        <li v-for="error in errors" :key="error">* {{ error }}</li>
                        </ul>
                    </p>
              <label for=""> رابط الزوم الخاص بك</label>
              <input v-model="form.zoomLink" type="text" class="form-control" />

              <label for=""> الرقم التعريفي</label>
              <input v-model="form.meetingID" type="text" class="form-control" />

              <label for="">كلمة السر </label>
              <input v-model="form.password" type="text" class="form-control" />

              <div class="btn-zoom">
                <button type="submit">حفظ</button>
              </div>
            </form>
              <Transition>
                  <div v-if="show" class="add-zoom-success">
                      <p>{{msg}}</p>
                  </div>
            </Transition>
          </div>
        </div>
      </section>
    </template>
    <portal-target name="show-user-recommendation"></portal-target>
    <portal-target name="recommendation-modal"></portal-target>
  </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../../views/userprofile/UserProfile_Content.vue";
import Filters from "../../../views/userprofile/calls/CallLog_Filters.vue";
import LogsTable from "../../../views/userprofile/calls/CallLog_Table.vue";
export default {
  components: { UserProfileContent, Filters, LogsTable },
  data() {
    return {
      errors: [],
      form: {
        zoomLink: "",
        meetingID: "",
        password: "",
      },
      msg: "",
      show: false,
    };
  },
  mounted() {
    this.callApi("get", "/api/get-zoom-account").then((resp) => {
        console.log(resp);
      if (resp.status == 200) {
        this.form.zoomLink = resp.data[0].zoom_link;
        this.form.meetingID = resp.data[0].meeting_id;
        this.form.password = resp.data[0].password;
      } else {
        this.msg = " يرجى اضافة حساب زوم ";
        this.show = !this.show;
        setTimeout(() => {
          this.show = !this.show;
          this.msg = ''
        }, 1900);
      }
    });
  },
  methods: {
    checkForm: function (e) {
      e.preventDefault();

      this.errors = [];

      if (this.form.zoomLink === "") {
        this.errors.push("رابط زوم الخاص بك مطلوب");
      }
      if (this.form.meetingID === "") {
        this.errors.push("الرقم التعريفي مطلوب");
      }
      if (this.form.password === "") {
        this.errors.push("كلمة السر  مطلوبة");
      }
      console.log(this.errors, this.form.zoomLink);
      if (this.errors.length == 0) {
        this.callApi("post", "/api/add-zoom-account", this.form).then(
          (resp) => {
            if (resp.status == 200) {
              this.msg = "تم اضافة رابط الزوم الخاص بك";
              this.show = !this.show;
              setTimeout(() => {
                this.show = !this.show;
              }, 1500);
            } else {
              this.msg = " لم يتم اضافة رابط زوم";
              this.show = !this.show;
              setTimeout(() => {
                this.show = !this.show;
              }, 1500);
            }
          }
        );
      }
    },
  },
};
</script>

<style scoped>
.zoom-account {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 3rem;
}
.zoom-form {
  width: 33%;
  padding: 2rem;
}

.zoom-form label {
    color: #2d8cff;
}

.zoom-form input {
  margin-bottom: 2rem;
  margin-top: 0.5rem;
}
.zoom-form p {
  color: red;
  padding: 2px;
}
.zoom-form ul > li {
  margin: 0.5px;
}
.btn-zoom {
  text-align: center;
}
.btn-zoom button {
  background: #2d8cff;
  height: 60px;
  color: #fff;
  transition: 0.3s;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  /* padding: 0 4rem; */
  width: 80%;
  border: none;
}
.btn-zoom button:hover {
  color: #2d8cff;
  height: 60px;
  background: #fff;
  transition: 0.3s;
  cursor: pointer;
  align-items: center;
  justify-content: center;

  /* padding: 0 4rem; */
  width: 80%;
  border: 1px solid #2d8cff;
  border-radius: 3px;
}
@media (max-width: 767px) {
  .card {
    background: transparent;
    box-shadow: none;
  }
  .zoom-form {
    width: 90%;
    padding: 0;
  }
  .zoom-account {
    padding: 0;
  }
  .add-zoom-success {
    left: 0%;
  }
}

/* transition */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

/* popup */
.add-zoom-success p {
  color: #009688;
}
.add-zoom-success {
  line-height: 3px;
  text-align: center;
  background: #fff;
  border-radius: 4px;
  border: 3px solid #bed8fb;
  padding: 3rem;
  position: absolute;
  margin: auto;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  max-width: 20rem;
  height: 1rem;
}
</style>
