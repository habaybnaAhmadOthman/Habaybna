<template>
    <UserProfileContent>
        <template #page-header>
            <h1>أوقاتي المتاحة</h1>
        </template>
        <template>
            <section class="session-times-section pt-50 pb-50 pt-0-p">
                <div class="card">
                    <div class="card-body p-0-p">
                        <div class="d-flex align-center space-between mb-25">
                            <h1 class="do">إختر الأوقات التي تكون متفرغاً بها لإجراء مكالمة</h1>
                            <div class="d-flex align-center gap-10 justify-center-p">
                                <p class="font-13">اختيار هذه الأوقات بشكل أسبوعي</p>
                                <label class="--switch">
                                    <input type="checkbox" v-model="repeatWeekly">
                                    <span class="-slider round"></span>
                                </label>
                            </div>
                        </div>

                        <SessionTableTimes></SessionTableTimes>

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
            repeatWeekly: true
        }
    },
};
</script>

<style scoped>
.--switch {
    position: relative;
    display: inline-block;
    width: 43px;
    height: 27px;
}
.--switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
input:checked + .-slider {
    background-color: #780d93;
}

.-slider.round {
    border-radius: 34px;
}
.-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}
input:checked + .-slider:before {
    -webkit-transform: translateX(14px);
    -ms-transform: translateX(14px);
    transform: translateX(14px);
}

.-slider.round:before {
    border-radius: 50%;
}
.-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 3px;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    background: #ffffff 0% 0% no-repeat padding-box;
    box-shadow: -1px 1px 1px #00000014;
}
@media (max-width: 767px) {
    .card {
        background: transparent;
        box-shadow: none;
    }
}
</style>