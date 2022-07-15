<template>
    <UserProfileContent>
        <template #page-header>
            <h1>سجل المكالمات</h1>
        </template>
        <template>
            <section class="session-times-section pt-50 pb-50">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-center space-between mb-25">
                                <h1>جدول المواعيد</h1>
                            </div>
                            <Filters 
                            :filters="filters"
                            @filter-changed="updateFilters"
                            ></Filters>
                            <LogsTable></LogsTable>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </UserProfileContent>
</template>

<script>
import UserProfileContent from "../../../views/userprofile/UserProfile_Content.vue";
import Filters from "../../../views/userprofile/calls/CallLog_Filters.vue";
import LogsTable from "../../../views/userprofile/calls/CallLog_Table.vue";
export default {    
    components: {UserProfileContent,Filters,LogsTable},
    data(){
        return {
            filters: {
                all: {
                    checked: true
                },
                scheduled: {
                    checked: false
                },
                succeeded: {
                    checked:false
                },
                missed: {
                    checked:false
                }
            }
        }
    },
    methods: {
        updateFilters(updatedFilters){
            this.filters = {...updatedFilters}
        }
    }
};
</script>

<style scoped>

</style>