<style  scoped>
.admin-subscribers h1 {
  font-size: 28px;
  font-weight: 500;
  letter-spacing: 0;
  line-height: 1.5em;
  padding-bottom: 15px;
  position: relative;
  color: #777;
}
.admin-subscribers h1:before {
  content: "";
  position: absolute;
  right: 0;
  bottom: 0;
  height: 5px;
  width: 55px;
  background-color: #777;
}
.admin-subscribers h1:after {
  content: "";
  position: absolute;
  right: 0;
  bottom: 2px;
  height: 1px;
  width: 95%;
  max-width: 255px;
  background-color: #333;
}
.table-button a:nth-child(1):hover {
  background-color: red;
  color: white;
}
.table-button a:nth-child(2) {
  color: rgb(54, 238, 54);
}
.table-button a:nth-child(2):hover {
  background-color: rgb(54, 238, 54);
  color: white;
}
.subscribers-pagination ul li {
  border: 2px solid #aaa;
  min-width: 30px;
  text-align: center;
  font-size: 20px;
  cursor: pointer;
  margin: 0 4px;
}
.active-paginate {
  background-color: #aaa;
  color: #fff;
  border: 4px;
  font-weight: bold;
}
.subscribers-table {
  min-height: 500px;
}
.m-w-300 {
  width: 517.5px !important;
}
.subscribers-pagination .hr {
  margin: 10px 20px;
  height: 1px;
  background-color: #aaa;
}
.shubscribers-header {
  margin-top: 20px;
  min-height: 150px;
  background-color: gainsboro;
  border: 1.5px solid darkgray;
  border-radius: 4px;
}
.shubscribers-header .search {
  width: 33%;
  text-align: right;
}
.shubscribers-header .search input {
  border: none;
  min-height: 40px;
  border-radius: 5px;
  align-items: baseline;
}
</style>
<template>
  <div class="admin-subscribers">
    <div class="subscribers-title mt-40 pr-10">
      <h1>دورات تعرض قريبا</h1>
      <Button :to="'/admin/categories/create'" type="primary" size="large" ghost
        >اضافة +</Button
      >
    </div>

    <div class="subscribers-table mt-20">
      <table class="table tablecategory">
        <thead class="thead-light">
          <th>العنوان</th>
          <th>الحالة</th>
          <th>الاجراءات</th>
        </thead>
        <tbody>
          <tr v-for="(one, index) in categories.data" :key="index">
            <td v-if="updateMood && trIndex == index" class="m-w-300">
              <input
                @input="(event) => (trData.title = event.target.value)"
                type="text"
                v-model="trData.title"
              />
            </td>
            <td v-else class="m-w-300">{{ one.title }}</td>

            <td
              v-if="updateMood && trIndex == index"
              :class="one.status ? 'text-green-500' : 'red'"
            >
              <select name="status" v-model="trData.status">
                <option
                  :selected="trData.status ?? false"
                  :value="1"
                  name="status"
                >
                  نشط
                </option>
                <option :selected="!trData.status ?? false" :value="0">
                  غير نشط
                </option>
              </select>
            </td>
            <td v-else>
              {{ one.status ? "نشط" : "غير نشط" }}
            </td>
            <td>
              <!-- <a :href="`child/${one.id}`"> عرض المزيد </a>| -->
              <div v-if="updateMood && trIndex == index" class="table-button">
                <a
                  class="table-button red border hover ivu- p-1 radius-10 red"
                  @click="
                    (handleCancelUpdate = updateMood = false), (trIndex = '')
                  "
                >
                  الغاء
                </a>
                &nbsp| &nbsp
                <a
                  class="border p-1 radius-10"
                  @click="updateRow(index, one.id)"
                >
                  حفظ
                </a>
              </div>
              <div class="relative" else>
                <a class="red" @click="handelDelete(index)"> حذف </a> &nbsp|
                &nbsp

                <a @click="handelUpdate(index)"> تعديل </a>
                <div
                  v-if="deletedIndex == index"
                  class="bg-light border d-flex flex-column p-2 position-absolute radius radius-12 z-1"
                >
                  <div class="">
                    <p>هل انت متأكد من حذف التصنيف ؟!</p>
                  </div>
                  <div>
                    <a
                      @click="deleteCategory(index, one.id)"
                      class="table-button red border hover ivu- p-1 radius-10 red"
                    >
                      حذف</a
                    >
                    <a
                      class="table-button border p-1 radius-10"
                      @click="deletedIndex = null"
                    >
                      لغاء</a
                    >
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="subscribers-pagination justify-center">
      <div class="hr"></div>
      <ul class="d-flex justify-center">
        <li
          v-for="index in categories.last_page"
          :key="index"
          :class="`${
            index == categories.current_page ? 'active-paginate' : ''
          }  `"
          @click="page = getData('?page=' + index)"
        >
          {{ index }}
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    this.getData("?page=1");
  },
  data() {
    return {
      categories: [],
      ActivePagIndex: 1,
      updateMood: false,
      trIndex: "",
      trData: {
        title: "",
        status: "",
      },
      deletedIndex: null,
    };
  },
  methods: {
    getData(page) {
      console.log(page);
      this.callApi("GET", `/api/admin/categories${page}`).then((resp) => {
        console.log("cate", resp);
        if (resp.status === 200) {
          this.categories = resp.data;
        }
      });
    },
    handelUpdate(index) {
      this.updateMood = true;
      this.trIndex = index;
      this.trData.title = this.categories.data[index].title;
      this.trData.status = this.categories.data[index].status;
    },
    updateRow(index, id) {
      this.callApi("POST", `/api/admin/category/${id}`, this.trData).then(
        (resp) => {
          console.log("updateCate", resp);
          if (resp.status === 200) {
            this.categories.data[index] = resp.data;
            this.updateMood = false;
            this.trIndex = index;
            this.trData.title = "";
            this.trData.status = "";
          }
        }
      );
    },
    handelDelete(index) {
      this.deletedIndex = index;
    },
    deleteCategory(index, id) {
      this.callApi("POST", `/api/admin/category/delete/${id}`).then((resp) => {
        console.log("DeleteeCate", resp);
        if (resp.status === 200) {
          this.categories.data.splice(index, 1);

          this.deletedIndex = null;
        }
      });
    },
  },
};
</script>













