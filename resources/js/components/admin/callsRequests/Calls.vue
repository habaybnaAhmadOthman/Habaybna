<style >
td,
tr,
th {
  direction: rtl;
  text-align: right;
  /* padding: 10px !important; */
  text-align: center !important;
  vertical-align: middle !important;
}
td > select {
  width: auto;
}
.coupon-table {
  padding: 0 2px;
  overflow-x: scroll;
}
.call-title {
  text-align: right;
  margin: 25px 5px;
  /* background: red; */
  padding: 16px;
}
.calls-filters-taps {
  /* background: blue; */
  padding: 7px;
  margin: 30px 0;
}
</style>
<template>
  <div>
    <div class="call-title">
      <h2>طلبات المكالمات</h2>
      <div class="calls-filters-taps">
        <button class="btn btn-success">جميع المكالمات</button>
        <button class="btn btn-success">مكالمات جديدة</button>
      </div>
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <!-- <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن  عنوان الحزمة"
      /> -->
    </div>
    <div class="">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">
              تاريخ المكالمة
            </th>
            <th>وقت المكالمة</th>
            <th>الاخصائي</th>
            <th>طالب المكالمة</th>
            <th class="sortted" v-on:click="sortTable('status')">
              حالة المكالمة
            </th>
            <th>رابط المكالمة</th>

            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(appointment, index) in appointments" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td>
              {{
                new Date(appointment.appointment).toLocaleDateString("ar-EG")
              }}
            </td>
            <td>
              {{
                new Date(appointment.appointment).toLocaleTimeString("ar-EG")
              }}
            </td>
            <td>ريم فرنجي</td>
            <td>احمد عبيدات</td>
            <td class="status">
              <select name="" id="">
                <option
                  :selected="appointment.calls_status == '0' ? true : false"
                  value="0"
                >
                  مجدولة
                </option>
                <option value="1">ناجحة</option>
                <option value="2">فائتة</option>
              </select>
            </td>
            <td>
              <Button @click="linkDialog(appointment.id, index)">
                <Icon
                  style="display: block"
                  size="30"
                  :color="
                    appointment.calls_status.call_zoom_link ? 'green' : 'blue'
                  "
                  type="md-link"
                />
              </Button>
            </td>
            <td>{{ appointment.appointment }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <Modal v-model="dialogLinkZoom" width="560">
      <p slot="header" style="color: #57c5f7; text-align: center">
        <Icon type="ios-link"></Icon>
        <span>رابط المكالمة </span>
      </p>
      <div style="text-align: center">
        <Input
          type="text"
          ref="zoomLink"
          v-model="zoomLink"
          placeholder="أدخل رابط المكالمة"
        />
        <span style="color: red" v-if="!linkIsValid">أدخل رابط المكالمة*</span>
      </div>
      <div slot="footer">
        <Button
          type="info"
          size="large"
          long
          :loading="modal_loading"
          @click="setZoomLink()"
          >حفظ</Button
        >
      </div>
    </Modal>
  </div>
</template>
<script>
export default {
  data() {
    return {
      appointments: [],
      //   packages: [],
      dialogLinkZoom: false,
      modal_loading: false,
      zoomLink: null,
      appointmentID: null,
      linkIsValid: true,
      appointmentIndex: null,
    };
  },
  async created() {
    this.getResults();
  },
  methods: {
    getResults() {
      const resp = this.callApi(
        "get",
        "/api/admin/get-calls-appointments"
      ).then((res) => {
        if (res.status == 200) {
          this.appointments = res.data.data;
        }
      });
    },
    linkDialog(appointmentID, index) {
      this.zoomLink = this.appointments[index].calls_status.call_zoom_link;
      this.dialogLinkZoom = true;
      this.appointmentID = appointmentID;
      this.appointmentIndex = index;
    },
    setZoomLink() {
      console.log(this.$refs.zoomLink.value);
      if (
        this.$refs.zoomLink.value != null &&
        this.$refs.zoomLink.value != ""
      ) {
        this.modal_loading = true;
        let Obj = {
          zoomLink: this.$refs.zoomLink.value,
          appointmentID: this.appointmentID,
        };
        const resp = this.callApi(
          "post",
          "/api/admin/set-calls-zoom-link",
          Obj
        ).then((res) => {
          if (res.status == 200) {
            setTimeout(() => {
                this.appointments[this.appointmentIndex].calls_status.call_zoom_link = this.$refs.zoomLink.value
              this.modal_loading = false;
              this.dialogLinkZoom = false;
              this.$Message.success("تم اضافة رابط المكالمة");
              this.appointmentIndex = null,
              this.appointmentID = null
            }, 500);
          }
        });
      } else {
        this.linkIsValid = false;
      }
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.packages.sort((a, b) =>
          isAscending
            ? a.title > b.title
              ? 1
              : b.title > a.title
              ? -1
              : 0
            : a.title < b.title
            ? 1
            : b.title < a.title
            ? -1
            : 0
        );
      }
      if (type == "status") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.packages.sort((a, b) =>
          isAscending
            ? a.status > b.status
              ? 1
              : b.status > a.status
              ? -1
              : 0
            : a.status < b.status
            ? 1
            : b.status < a.status
            ? -1
            : 0
        );
      }
      if (type == "gender") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.sort((a, b) =>
          isAscending
            ? a.gender > b.gender
              ? 1
              : b.gender > a.gender
              ? -1
              : 0
            : a.gender < b.gender
            ? 1
            : b.gender < a.gender
            ? -1
            : 0
        );
      }
    },
  },
  computed: {

  },
};
</script>
