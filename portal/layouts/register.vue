<template>
  <div class="d-flex registration-template h-full h-auto-p overflow-hidden">
    <div
      class="right-side bg-white w-40 w-100-p pt-0-p pt-20-p"
      :class="padding"
    >
      <Nuxt />
    </div>
    <RegisterLeftSide class="w-60 w-100-p pt-0-p"></RegisterLeftSide>
  </div>
</template>


<script>
export default {
  props: { padding: { default: "pt-100" } },
};
</script>