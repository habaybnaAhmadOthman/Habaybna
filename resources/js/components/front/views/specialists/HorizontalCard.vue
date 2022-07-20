<template>
    <router-link to="/specialist/1" class="bg-white shadow radius-12 pt-10 pb-10 p-side-15 d-flex space-between">
    <!-- <router-link :to="authorURL" class="bg-white shadow radius-12 pt-10 pb-10 p-side-15 d-flex space-between"> -->
        <div class="black-2">
            <p class="font-20 bold black-2 mb-15">د.محمد الأحمد</p>
            <p class="font-15 gray">أخصائي توحد</p>
        </div>
        <img class="box-img rounded object-fit" src="/images/test.jpg" alt="" width="110" height="110" >
    </router-link>
</template>

<script>
    export default {
        computed: {
            authorURL(){
                var url = this.author.firstName.split(' ').join('-')
                if (this.author.lastName)
                    url += `-${this.author.lastName.split(' ').join('-')}`

                url += `--${this.author.user_id}`
                return `/specialist/${url}`
            },
        }
    }
</script>

<style scoped>
.box-img {

}
</style>