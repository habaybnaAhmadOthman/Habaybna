<template>
    <div class="mobile-form pt-50 p-side-50">
        <p class="white font-40 bold center">
            أهلا و سهلاً بك  <br> في عائلة حبايبنا
        </p>
        
        <form @submit.prevent="submitForm">
            <div class="form-group mt-50" :class="{ invalid: !tagsValid }">
                <vue-tags-input
                v-model="tag"
                :tags="tags"
                @tags-changed="newTags => tags = newTags"
                placeholder="الاهتمامات"
                class="tags-input"
                >
                </vue-tags-input>
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div class="center">
                <button class="btn font-15 mt-15 w-30">حفظ</button>
            </div>
        </form>
        <p class="font-18 mt-50 bold white">يمكنك أيضاً:</p>
        <div class="d-flex">
            <router-link to="/" class="white underline font-16">عودة الى الرئيسية</router-link>
            <router-link to="/" class="white underline mr-20 font-16">ملفي الشخصي</router-link>
        </div>
    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
    emits: ['submit-interests'],
    components: {
        VueTagsInput
    },
    data() {
        return {
            isLoading: false,
            tag: '',
            tags: [],
            tagsValid: true,
            error: null
        };
    },
    methods: {
        submitForm(){
            this.tagsValid = true;
            if (this.tags.length < 1) {
                this.tagsValid = false;
                return ;
            }
            this.$emit('submit-interests',this.tags)
        }
    }
};
</script>

<style>
  .tags-input,.ti-input {
    min-height:52px;
    border: 1px solid #606;
    border-radius: 5px;
    }
    .vue-tags-input {
        max-width: 100%!important;
    }
    .form-group p {
    display: none;
}
.form-group.invalid p {
    display: block;
}
</style>
