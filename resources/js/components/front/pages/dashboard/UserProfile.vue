<template>
    <UserProfileContent>
        <template #page-header>
            <h1>البيانات الشخصية</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50">
                <div class="container-fluid">
                    <div class="card">
                        <MyAccount :interestsList="[]"></MyAccount>
                    </div>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../views/userprofile/UserProfile_Content.vue";
import MyAccount from "../../views/userprofile/UserProfile_MyAccount.vue";
export default {
    components: { UserProfileContent,MyAccount }
};
</script>
