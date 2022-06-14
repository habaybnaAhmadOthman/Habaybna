<template>
  <div>
    <h1>Hello Vue!</h1>
    <p>
      <router-link to="/about">About</router-link>
    </p>
    <p>
      <router-link to="/users">Users</router-link>
    </p>
    <pre>
      {{message}}
    </pre>
  </div>
</template>

<script>
export default {
  name: "IndexPage",
  data() {
    return {
      message: null,
    };
  },
  methods: {
    onClick() {
      this.message = "Hello Vue!";
    },
  },
  async asyncData({ store }) {
    const data = await store.dispatch("courses/getAllCourses");
    return {
      message: data,
    };
  },
  async mounted() {
    // const data = await this.$store.dispatch("courses/getAllCourses");
    // console.log(data)
    // return {
    //   message: "Hello Vue!",
    // };
    // this.message = resp.data.courses;
  },
  head() {
    return {
      title: "About page"
    };
  }
};
</script>
