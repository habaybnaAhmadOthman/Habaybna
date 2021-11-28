<template>
    <component :is="activeComponent" :interestsList="[]" @submitForm="submitForm"></component>
</template>
<script>
import parentAccount from './myaccount/Parent.vue'
export default {
    emits: ["submit-form"],
    components: { parentAccount },
    data() {
        return {
            activeComponent: 'parentAccount'
        };
    },
    methods: {
        submitForm(data) {
            console.log(data);
        }
    }
};
</script>
