<template>
    <div class="small-card-list d-flex flex-wrap gap-20">
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
       <SmallCard></SmallCard>
    </div>
</template>

<script>
import SmallCard from './SmallCard.vue'
export default {
    components: {SmallCard}
};
</script>

<style scoped></style>
