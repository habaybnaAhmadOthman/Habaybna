<template>
    <div class="about-coach mt-50 pt-10">
        <h3 class="title-line mb-40">عن المدربين</h3>
        <div class="d-flex specialist-list flex-wrap row-3">
            <SpecialistCard></SpecialistCard>
            <!-- <img class="rounded object-fit" :src="avatar" :alt="name" width="200" height="200">
            <div class="mr-30">
                <p class="main-color font-40">{{name}}</p>
                <p class="font-30 mb-10">{{speciality}}</p>
                <p>{{description}}</p>
            </div> -->
        </div>
    </div>
</template>

<script>
import SpecialistCard from '../../views/specialists/SpecialistCard.vue'
export default {
    components: {SpecialistCard},
    props: ['specialistID'],
    data(){
        return {
            name: '',
            speciality: '',
            description: '',
            avatar: ''
        }
    },
    created(){
        this.getSpecialistDetails()
    },
    methods: {
        async getSpecialistDetails(){
            try {
                const data = await this.$store.dispatch('specialist/getSpecialistDetails',this.specialistID);
                this.name = data.specialistName;
                this.speciality = data.speciality;
                this.description  = data.description;
                this.avatar  = data.avatar;
            } catch (e){
                console.log(e);
            }
        },
    }
}
</script>
<style scoped>

</style>