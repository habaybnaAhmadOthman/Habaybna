<template>
<div>
    <alert-dialog :show="show" title="نظام الخصوصية" @close="closeModal">
        <template>
            <p>عند تفعيل نظام الخصوصية لن يظهر إسمك للمستخدمين الآخرين ذلك حرصاً على راحتكم</p>
            <div class="form-group d-flex mt-30">
                <label class="checkbox main-color font-16">
                    <input
                        type="checkbox"
                        name="checkbox-checked"
                        v-model="privateModeInput"
                    />
                    تفعيل نظام الخصوصية
                </label>
            </div>
        </template>
        <template #actions>
            <button class="btn ml-25" @click="closeModal">إغلاق</button>
            <button class="btn" @click="submitForm">حفظ</button>
        </template>
    </alert-dialog>
    <div v-if="isLoading">
        <loading-spinner></loading-spinner>
    </div>
</div>
</template>

<script>
import loadingMixin from "../../../mixins/loading.js";
export default {
    emits: ["close-special-dialog","popup-alert"],
    mixins: [loadingMixin],
    props: ['show','private-mode'],
    data(){
        return {
            privateModeInput: null
        }
    },
    mounted(){
        this.privateModeInput = this.privateMode
    },
    methods: {
        async submitForm() {
            this.isLoading = true;
            try {
                await this.$store.dispatch('user/privateMode',this.privateModeInput)
                this.$emit('popup-alert','specialModeDialog','تم حفظ التغييرات')
            } catch (e) {
                this.$emit('popup-alert','specialModeDialog','حصل خطأ ما')
            }
            this.isLoading = false;
        },
        closeModal(){
            this.$emit('close-special-dialog')
        }
    }
};
</script>
<style scoped>
.checkbox {
    font-weight: bold;
    line-height: 1.1;
    display: flex;
    cursor: pointer;
    align-items: center;
}
input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    margin: 0;
    width: 25px;
    height: 25px;
    border: 1px solid #660066;
    border-radius: 3px;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
    margin-left: 12px;
    cursor: pointer;
}

input[type="checkbox"]::before {
    content: "";
    width: 15px;
    height: 15px;
    -webkit-clip-path: polygon(
        14% 44%,
        0 65%,
        50% 100%,
        100% 16%,
        80% 0%,
        43% 62%
    );
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    transform: scale(0);
    transform-origin: bottom left;
    transition: 120ms transform ease-in-out;
    /* Windows High Contrast Mode */
    background-color: CanvasText;
    cursor: pointer;
}

input[type="checkbox"]:checked::before {
    transform: scale(1);
}
</style>
