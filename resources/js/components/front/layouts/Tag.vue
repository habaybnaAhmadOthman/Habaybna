<template>
    <router-link :to="updatedLink" v-if="link">
        <label :class="classes" class="center gray radius-60 font-18 font-16-p">{{ value  }}</label>
    </router-link>
    <div v-else>
        <label :class="classes" class="center gray radius-60 font-18 font-16-p">{{ value  }}</label>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['value',"link","classes"],
        computed: {
            updatedLink(){
                if (this.link.includes('?'))
                    return `${this.link}&newFilters=1` 
                else
                    return `${this.link}?newFilters=1` 
            }
        },
        
    }
</script>

<style scoped>
div label {
  display: inline-block;
  padding: 11px 23px;
  white-space: nowrap;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-tap-highlight-color: transparent;
  transition: all 0.3s;
  min-width: 110px;
  cursor: pointer;
  border: 1px solid #780d93;
  background-color: #660066;
  color: #fff !important;
  transition: all 0.2s;
}
div label.yellow {
  background: #ff9e00;
  border-color: #ff9e00;
}
@media (max-width: 767px) {
  div label {
    padding: 9px 23px;
    min-width: auto;
  }
}
</style>
