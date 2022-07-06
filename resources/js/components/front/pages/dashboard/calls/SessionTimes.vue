<template>
    <UserProfileContent>
        <template #page-header>
            <h1>أوقاتي المتاحة</h1>
        </template>
        <template>
            <section class="session-times-section pt-50 pb-50">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-center space-between mb-25">
                                <h1>إختر الأوقات التي تكون متفرغاً بها لإجراء مكالمة</h1>
                                <div>
                                    اختيار هذه الأوقات بشكل أسبوعي
                                    <input type="checkbox">
                                </div>
                            </div>

                            <SessionTableTimes></SessionTableTimes>

                        </div>
                    </div>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../../views/userprofile/UserProfile_Content.vue";
import SessionTableTimes from "../../../views/userprofile/calls/SessionTableTimes.vue";
export default {    
    components: {UserProfileContent,SessionTableTimes},
    data(){
        return {
            
        }
    },
};
</script>

