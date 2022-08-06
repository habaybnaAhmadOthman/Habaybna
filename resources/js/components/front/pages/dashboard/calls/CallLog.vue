<template>
    <UserProfileContent>
        <template #page-header>
            <h1>سجل المكالمات</h1>
        </template>
        <template>
            <section class="session-times-section pb-50">
                <div class="">
                    <div class="card">
                        <div class="card-body p-0-p">
                            <Filters 
                            :filters="filters"
                            @filter-changed="updateFilters"
                            ></Filters>
                            <LogsTable :filters="activeFilters"></LogsTable>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <portal-target name="show-user-recommendation"></portal-target>
        <portal-target name="recommendation-modal"></portal-target>
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
            },
            activeFilters: 'all'
        }
    },
    methods: {
        updateFilters(updatedFilters,activeFilter){
            this.filters = {...updatedFilters};
            this.activeFilters = activeFilter
        }
    }
};
</script>

<style scoped>
@media (max-width: 767px) {
    .card {
        background: transparent;
        box-shadow: none;
    }
}
</style>