<style >
td,
tr,
th {
  direction: rtl;
  text-align: right;
  padding: 10px !important;
  text-align: center !important;
  vertical-align: middle !important;
}
.coupon-table {
  padding: 0 2px;
  overflow-x: scroll;
}
.cat-tag {
  background-color: #348eff;
  color: #fff;
  width: 72%;
  border-radius: 4px;
  font-size: 11px;
  padding: 1px 0;
  margin-bottom: 1.5px;
}
.phone-td {
  direction: ltr !important;
}
</style>
<template>
  <div>
    <div class="title">
      <h2>طلبات شراء الدورات التدريبية</h2>
      <Button type="success" size="large" ghost v-on:click="exportToExcel()">
        export to excel</Button
      >
      <Button type="error" size="large" ghost v-on:click="exportToPdf()">
        export to pdf</Button
      >
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <Input type="text" v-model="keyword" placeholder="ابحث عن رمز الكوبون" />
    </div>
    <div class="coupon-table" ref="toPdf">
      <table class="table" id="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">عنوان الدورة</th>
            <th>فئة الدورة</th>
            <th class="sortted" v-on:click="sortTable('status')">حالة الطلب</th>
            <th>مدة الدورة</th>
            <th>سعر الدورة</th>
            <th>اسم المستخدم</th>
            <th>رقم الهاتف</th>
            <th>تاريخ الطلب</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in filteredList" :key="index">
            <th scope="row">{{ index + 1 }} -</th>
            <td>{{ order.course_title }}</td>
            <td>
              <ul v-if="order.course_categories.length > 0">
                <li
                  v-for="(cat, i) in order.course_categories"
                  :key="i"
                  class="cat-tag"
                >
                  {{ cat.title }}
                </li>
              </ul>
            </td>
            <td class="status">
              <Button type="success" ghost v-if="order.order_status">
                <span>دفع بنجاح</span>
              </Button>
              <Button type="error" ghost v-if="!order.order_status">
                <span> دفع مرفوض</span>
              </Button>
            </td>
            <td>{{ order.course_length }}</td>
            <td>{{ order.course_price }}</td>
            <td>{{ order.user_name }}</td>
            <td class="phone-td">{{ order.user_phone }}</td>
            <td>{{ order.date }}</td>
            <td>
              <!-- <Button
                :to="'/admin/coupon/' + coupon.id"
                type="dashed"
                size="small"
                >عرض</Button
              >
              <Button @click="deleteDaialog(coupon.id, index)">
                <Icon size="20" color="red" type="md-trash" />
              </Button> -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import * as XLSX from "xlsx";
import { jsPDF } from "jspdf";

export default {
  data() {
    return {
      orders: [],
      //   dialogDelete: false,
      //   modal_loading: false,
      //   idDeleteUser: "",
      //   indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/orders/courses");
    if (resp.status == 200) {
      this.orders = resp.data;
    }
  },
  methods: {
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.orders.sort((a, b) =>
          isAscending
            ? a.course_title > b.course_title
              ? 1
              : b.course_title > a.course_title
              ? -1
              : 0
            : a.course_title < b.course_title
            ? 1
            : b.course_title < a.course_title
            ? -1
            : 0
        );
      }
      if (type == "status") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.orders.sort((a, b) =>
          isAscending
            ? a.order_status > b.order_status
              ? 1
              : b.order_status > a.order_status
              ? -1
              : 0
            : a.order_status < b.order_status
            ? 1
            : b.order_status < a.order_status
            ? -1
            : 0
        );
      }
    },
    exportToExcel() {
      /* generate workbook object from table */
      var wb = XLSX.utils.table_to_book(document.getElementById("table"));
      /* generate file and force a download*/
      XLSX.writeFile(wb, "courses_orders.xlsx");
    },
    exportToPdf() {
      // Default export is a4 paper, portrait, using millimeters for units
      const doc = new jsPDF();
    //   doc.addFont("Roboto-Regular",9 ,"Roboto-Regular", "normal");
      doc.setFont("Baloo Bhaijaan 2");
      doc.text('Arabic Text Not Available Rania but pdf work i will add arabic font later', 10, 10);
      doc.save("a4.pdf");
    },
  },
  computed: {
    filteredList() {
      return this.orders.filter((order) => {
        return order.course_title
          .toLowerCase()
          .includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
