<template>
    <div class="d-flex flex-wrap">
        <div class="container">
            <ul class="ks-cboxtags d-flex space-between mb-50">
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v1"
                        value="v1"
                    /><label class="center gray" for="v1">نطق و لغة</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v2"
                        value="v2"
                    /><label class="center gray" for="v2">صعوبات تعلم</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v3"
                        value="v3"
                    /><label class="center gray" for="v3">دردشة</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v4"
                        value="v4"
                    /><label class="center gray" for="v4">طقس اليوم</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v5"
                        value="v5"
                    /><label class="center gray" for="v5">متلازمة داون</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v6"
                        value="v6"
                    /><label class="center gray" for="v6">أمطار</label>
                </li>
                <li>
                    <input
                        @change="setFilter"
                        type="checkbox"
                        id="v7"
                        value="v7"
                    /><label class="center gray" for="v7">شتاء</label>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
  emits: ['change-filter'],
  data(){
    return {
      filters: {
        v1: false,
        v2: false,
        v3: false,
        v4: false,
        v5: false,
        v6: false,
        v7: false
      }
    }
  },
  methods:{
    setFilter(e) {
      const inputID = e.target.id;
      const isActive = e.target.checked;
      const updateFilters = {
        ...this.filters,
        [inputID] : isActive
      }
      this.filters = updateFilters;
      this.$emit('change-filter',updateFilters)
    }
  }
}
</script>

<style scoped>
ul.ks-cboxtags li label {
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(139, 139, 139, 0.3);
    border-radius: 25px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all 0.3s;
    min-width: 110px;
}

ul.ks-cboxtags li label {
    padding: 8px 12px;
    cursor: pointer;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    border: 2px solid #660066;
    background-color: #660066;
    color: #fff;
    transition: all 0.2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
    display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}
</style>
