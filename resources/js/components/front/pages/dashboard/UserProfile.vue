<template>
    <PageTemplate>
        <template #page-header>
            <h1>الحساب الشخصي</h1>
        </template>
        <template>
            <section class="profile-section pt-50 pb-50">
                <div class="container-fluid">
                    <div class="card">
                        <form class="card-body">
                            <div class="form-group">
                                <label class="form-control-label">الاسم كامل</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="الإسم الأول">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="العائلة">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-control-label">البريد الإلكتروني</label>
                                        <input class="form-control" placeholder="الإسم الأول">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-control-label">كلمة المرور</label>
                                        <input class="form-control" placeholder="الإسم الأول">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </template>
    </PageTemplate>
</template>

<script>
import PageTemplate from '../../views/userprofile/UserProfile_Template.vue'
export default {
    components: {PageTemplate}
}
</script>
