<template>
    <!-- <router-link to="/specialist/1" class="bg-white shadow radius-12 pt-10 pb-10 p-side-15 d-flex space-between"> -->
    <router-link :to="authorURL" class="bg-white shadow radius-12 pt-10 pb-10 p-side-15 d-flex space-between">
        <div class="black-2">
            <p class="font-20 bold black-2 mb-15">{{name}}</p>
            <p class="font-15 gray">{{data.specialization}}</p>
        </div>
        <img class="box-img rounded object-fit" :src="defaultAvatar" alt="" width="110" height="110" >
    </router-link>
</template>

<script>
    export default {
        props: ['data'],
        computed: {
            name(){
                return `${this.data.firstName} ${this.data.lastName}`
            },
            authorURL(){
                var url = this.data.firstName.split(' ').join('-')
                if (this.data.lastName)
                    url += `-${this.data.lastName.split(' ').join('-')}`

                url += `--${this.data.id}`
                return `/specialist/${url}`
            },
            defaultAvatar() {
                if (this.data.avatar == 'default.jpg') return '/images/avatars/default.jpg'
                return this.data.avatar
            }
        }
    }
</script>

<style scoped>
.box-img {

}
</style>