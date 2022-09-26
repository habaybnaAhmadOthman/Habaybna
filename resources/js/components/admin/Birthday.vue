
<template>
  <div class="container mb-">
    <h1 class="text-center mt-20 text-uppercase">siraj & nadeem gifts</h1>
    <div class="row justify-content-center mt-30 mb-20">
      <div class="col-5 box b-success">
        <th class="d-block">مجموع الهدايا الناجحة</th>
        <th class="d-block">{{ successTransaction }}</th>
      </div>
      <div class="col-5 box b-faild">
        <th class="d-block">مجموع الهدايا غير الناجحة</th>
        <th class="d-block">{{ faildTransaction }}</th>
      </div>
      <div class="col-5 box b-all">
        <th class="d-block">مجموع الهدايا الكلي</th>
        <th class="d-block">{{ allTranactions }}</th>
      </div>
      <div class="col-5 box b-money">
        <th class="d-block">المجموع الكلي &nbsp;(JD)</th>
        <th class="d-block">JD&nbsp;{{ totalMoney }}</th>
      </div>
    </div>
    <div class="row justify-content-end">
      <Button type="success" size="large" ghost v-on:click="exportToExcel()">
        export to excel</Button
      >
    </div>
    <div class="row" id="">
      <div class="col-1 mt-20 border border-dark d-flex justify-content-center">
        <th class="">#</th>
      </div>
      <div
        class="
          col-2
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">الاسم الاول</th>
      </div>
      <div
        class="
          col-2
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">الاسم الثاني</th>
      </div>
      <div
        class="
          col-2
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">الايميل</th>
      </div>
      <div
        class="
          col-2
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">حالة الدفع</th>
      </div>
      <div
        class="
          col-1
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">السعر</th>
      </div>
      <div
        class="
          col-2
          mt-20
          border border-dark
          d-flex
          justify-content-center
          p-title
        "
      >
        <th class="">تاريخ الدفع</th>
      </div>
    </div>
    <div v-for="(row, index) in data" :key="index" class="row">
      <td class="col-1 border">{{ index + 1 }}</td>
      <td class="col-2 border">{{ row.firstName }}</td>
      <td class="col-2 border">{{ row.lastName }}</td>
      <td class="col-2 border">{{ row.email }}</td>
      <td :class="`col-2 border ${row.status ? 'p-success' : 'p-faild'}`">
        {{ row.status ? "ناجح" : "غير ناجح" }}
      </td>
      <td class="col-1 border">{{ row.amount }}</td>
      <td class="col-2 border">{{ row.created_at }}</td>
    </div>
    <table id="table" class="d-none">
      <thead>
        <tr>
          <th> #</th>
          <th>لاسم الاول</th>
          <th>الاسم الثاني</th>
          <th>الايميل</th>
          <th>جالة الدفع</th>
          <th>القيمة</th>
          <th>تاريخ الدفع</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in data" :key="index">
          <td class="col-1 border">{{ index + 1 }}</td>
          <td class="col-2 border">{{ row.firstName }}</td>
          <td class="col-2 border">{{ row.lastName }}</td>
          <td class="col-2 border">{{ row.email }}</td>
          <td :class="`col-2 border ${row.status ? 'p-success' : 'p-faild'}`">
            {{ row.status ? "ناجح" : "غير ناجح" }}
          </td>
          <td class="col-1 border">{{ row.amount }}</td>
          <td class="col-2 border">{{ row.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import * as XLSX from "xlsx";

export default {
  data() {
    return {
      data: null,
      totalMoney: null,
      allTranactions: null,
      successTransaction: null,
      faildTransaction: null,
    };
  },
  methods: {
    getGifts() {
      const resp = this.callApi("get", "/api/admin/get-gifts").then((res) => {
        this.data = res.data;
        var allTranactions = 0;
        var totalMoney = 0;
        var successTransaction = 0;
        var faildTransaction = 0;

        this.data.forEach((element) => {
          parseInt(allTranactions++);
          if (element.status) {
            totalMoney += parseInt(element.amount);
            parseInt(successTransaction++);
          } else {
            parseInt(faildTransaction++);
          }
        });
        this.totalMoney = totalMoney;
        this.allTranactions = allTranactions;
        this.successTransaction = successTransaction;
        this.faildTransaction = faildTransaction;
        console.log(
          "totalMoney:",
          this.totalMoney,
          "allTranactions:",
          this.allTranactions,
          "success:",
          this.successTransaction,
          "faild:",
          this.faildTransaction
        );
        // console.log(this.data);
      });
    },
    exportToExcel() {
      var wb = XLSX.utils.table_to_book(document.getElementById("table"));
      /* generate file and force a download*/
      XLSX.writeFile(wb, "birthday gifts.xlsx");
    },
  },
  mounted() {
    this.getGifts();
  },
};
</script>
<style scoped>
.p-title {
  background-color: #8080803d;
}
.p-faild {
  color: red;
}
.p-success {
  color: green;
}

.box {
  font-size: 20px;
  margin: 14px 14px;
  max-width: 31%;
  padding: 28px 0;
  border-radius: 23px;
  color: #fff;
}
.b-success {
  background-color: #29cd00;
}
.b-faild {
  background-color: #ff4136;
}
.b-all {
  background-color: #7fdbff;
}
.b-money {
  background-color: #001f3f;
}
</style>
