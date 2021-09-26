<template>
  <Table border :columns="columns7" :data="data6"></Table>
</template>
<script>
export default {
  data() {
    return {
      columns7: [
        {
          title: "Title",
          key: "name",
          width: "auto",
          //   align: "center",
          render: (h, params) => {
            return h("div", [
              h("Icon", {
                props: {
                  type: "person",
                },
              }),
              h("strong", params.row.courseTitle),
            ]);
          },
        },
        {
          title: "Category",
          key: "category_id",
        },

        {
          title: "Price",
          key: "price",
          width: 100,
        },
        {
          title: "Publish",
          key: "is_publish",
          width:100

        },
        {
          title: "Free",
          key: "is_free",
          width:100
        },
        {
          title: "Action",
          key: "action",
          width: 300,
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                  },
                  style: {
                    marginRight: "5px",
                  },
                  on: {
                    click: () => {
                      this.show(params.index);
                    },
                  },
                },
                "View"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                 to:{
                     path:"/admin/uploadVideos/"+params.row.id,

                 }

                  },
                  style: {
                    marginRight: "5px",
                  },
                },
                "Videos"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                  },
                  style: {
                    marginRight: "5px",
                  },
                  on: {
                    click: () => {
                      this.show(params.index);
                    },
                  },
                },
                "View"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                  },
                  style: {
                    marginRight: "5px",
                  },
                  on: {
                    click: () => {
                      this.show(params.index);
                    },
                  },
                },
                "View"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "error",
                    size: "small",
                  },
                  on: {
                    click: () => {
                      this.remove(params.index);
                    },
                  },
                },
                "Delete"
              ),
            ]);
          },
        },
      ],
      data6: [],
    };
  },
  async created() {
    const resp = await this.callApi("get", "/admin/onlineCourse");
    if (resp.status == 200) {
        console.log(resp.data);
      this.data6 = resp.data.courses;
    }
  },
  methods: {
    show(index) {
      this.$Modal.info({
        title: "User Info",
        content: `Name：${this.data6[index].name}<br>Age：${this.data6[index].age}<br>Address：${this.data6[index].address}`,
      });
    },
    remove(index) {
      this.data6.splice(index, 1);
    },
  },
};
</script>
