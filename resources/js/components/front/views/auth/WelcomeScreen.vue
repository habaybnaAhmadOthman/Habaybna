<template>
    <div class="mobile-form pt-50 p-side-50">
        <p class="white font-40 bold center">
            أهلا و سهلاً بك <br />
            في عائلة حبايبنا
        </p>

        <form @submit.prevent="submitForm">
            <div class="form-group mt-50" :class="{ invalid: !tagsValid }">
                <multiselect
                    v-model="tags"
                    :options="interestsList"
                    :searchable="true"
                    :close-on-select="false"
                    :multiple="true"
                    :taggable="true"
                    label="title"
                    track-by="title"
                    placeholder="يرجى إختيار الإهتمامات"
                ></multiselect>
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div class="center">
                <button class="btn font-15 mt-15 w-30">حفظ</button>
            </div>
        </form>
        <p class="font-18 mt-50 bold white">يمكنك أيضاً:</p>
        <div class="d-flex">
            <router-link to="/" class="white underline font-16"
                >عودة الى الرئيسية</router-link
            >
            <router-link to="/" class="white underline mr-20 font-16"
                >ملفي الشخصي</router-link
            >
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
export default {
    emits: ["submit-interests"],
    props: ["interestsList"],
    components: {
        Multiselect
    },
    created() {
        // this.initAutoComplete();
    },
    data() {
        return {
            isLoading: false,
            tags: "",
            tagsValid: true,
            error: null
        };
    },
    methods: {
        submitForm() {
            this.tagsValid = true;
            if (this.tags.length < 1) {
                this.tagsValid = false;
                return;
            }
            let tagIDs = [];
            this.tags.forEach(item => tagIDs.push(item.id));
            this.$emit("submit-interests", tagIDs);
        }
    },
    computed: {}
};
</script>

<style scoped>
.form-group p {
    display: none;
}
.form-group.invalid p {
    display: block;
}
</style>
<style>
.multiselect__tags {
    border: 1px solid #606;
    min-height: 52px;
    border-radius: 4px;
    padding: 8px 8px 0 40px;
    text-align: right;
}
.multiselect__option--selected,.multiselect__option {
    text-align: right;
}
.multiselect__option--highlight:after,.multiselect__option--selected:after {
    content: none !important;
}
.multiselect__option--highlight {
    background: #606!important;
    text-align: right;
}
.multiselect__select {
    left: 1px;
    right: auto;
    height: 52px;
}
.multiselect__select:before {
    border-color: #606 transparent transparent;
}
.multiselect__tag {
    background:#606;
}
.multiselect__tag-icon:after {
    color:#fff;
}
</style>
