<template>
    <PageTemplate>
        <template #page-header>
            <h1>الحساب الشخصي</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50">
                <div class="container-fluid">
                    <div class="card">
                        <MyAccount @submitForm="submitForm" :interestsList="[]"></MyAccount>
                    </div>
                </div>
            </section>
        </template>
    </PageTemplate>
</template>

<script>
import PageTemplate from "../../views/userprofile/UserProfile_Template.vue";
import MyAccount from "../../views/userprofile/UserProfile_MyAccount.vue";
export default {
    components: { PageTemplate, MyAccount },
    methods: {
        submitForm() {

        }
    }
};
</script>
