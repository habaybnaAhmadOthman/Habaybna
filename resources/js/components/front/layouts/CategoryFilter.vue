<template>
    <li class="">
        <input
            @change="setFilter"
            type="checkbox"
            :id="id"
            :value="value"
        />
        <label class="center gray radius-60 font-18 font-16-p" :for="id">{{ value  }}</label>
    </li>
</template>

<script>
export default {
    emits: ['change-filter'],
    props: ['id','value'],
    data(){
        return {
            filter: {}
        }
    },
    methods: {
        setFilter(e) {
            //   const inputID = e.target.id;
            const isActive = e.target.checked;
            const index = +e.target.parentNode.parentNode.getAttribute("index");
            this.filter.isChecked = isActive;
            //   const updateFilters = {
            //     ...this.filters,
            //     [inputID] : isActive
            //   }
            //   this.filters = updateFilters;
            this.$emit("change-filter", this.filter,index);
        },
    },
    mounted(){
        this.filter = {
            id: this.id,
            isChecked: false,
            value: this.value
        }
    }
};
</script>

<style scoped>
li label {
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
}

li input[type="checkbox"]:checked + label {
    background-color: #660066;
    color: #fff !important;
    transition: all 0.2s;
}

li input[type="checkbox"] {
    display: absolute;
}
li input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}
@media (max-width: 767px) {
    li label {
        padding: 9px 23px;
        min-width: auto;
    }
}
</style>
