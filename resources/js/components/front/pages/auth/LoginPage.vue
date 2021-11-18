<template>
    <div>
        <FormTemplate>
            <MobileLogin></MobileLogin>
        </FormTemplate>
    </div>
</template>

<script>

// forms
import FormTemplate from "./../../layouts/FormTemplate.vue";
import MobileLogin from "./../../views/auth/MobileLogin.vue";
export default {
    components:{
        FormTemplate,
        MobileLogin
    }
}
</script>