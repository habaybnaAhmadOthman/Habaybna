<template>
    <alert-dialog :show="show" title="تغيير الصورة الشخصية" @close="closeModal" :modal-class="'user-image-modal'">
        <template>
            <div class="modal-body m-side-auto">
                <img
                    :src="userAvatar"
                    width="100"
                    height="100"
                    class="m-side-auto d-block radius-60 user-img object-fit"
                />
                <p class="main-color font-22">اختر شخصية</p>
                <div class="d-flex flex-wrap space-between images-box radius-12 p-10">
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15" >
                        <input type="radio" value="A1" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="A2" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="A3" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="A4" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A5" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A6" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A7" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A8" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1" />
                        <span class="trans"></span>
                    </label>
                </div>
                <div class="">
                    <label class="custom-file-upload d-flex align-center btn w-100 center mt-10 relative">
                        <input type="file" @change="processFile($event)" accept="image/*" />
                        <img src="/images/siteImgs/header/logo.png" width="20" height="20" class="" />
                        <span>او قم بتحميل صورة</span>
                    </label>
                </div>                
                <p v-if="!formIsValid" class="main-color font-12">يرجى إختيار أحد الشخصيات أو تحميل صورة</p>

            </div>
        </template>
        <template #actions>
            <button class="btn ml-25" @click="closeModal">إغلاق</button>
            <button class="btn" @click="submitForm">حفظ</button>
        </template>
    </alert-dialog>
</template>

<script>
import loadingMixin from './../../../mixins/loading.js'
export default {
    emits: ["close-image-modal"],
    mixins: [loadingMixin],
    props: {
        userAvatar: {
            type: String,
            default: '/images/siteImgs/header/logo.png'
        },
        show: Boolean
    },
    data() {
        return {
            uploadedImage: null ,
            selectedImage: null,
            formIsValid: true
        }
    },
    methods: {
        submitForm: function() {
            this.formIsValid = true;
            this.isLoading = true;
            // submit then
            // this.closeModal();
            if (!this.uploadedImage && !this.selectedImage) {
                this.formIsValid = false;
                return false;
            }
            if (this.uploadedImage) {
                var formData = new FormData();
                formData.append("file", this.uploadedImage, this.uploadedImage.name);
                $.ajax({
                    "url": baseUrl+"/my-profile-image",
                    "method": "PUT",
                    "timeout": 0,
                    "headers": {
                        "enctype": "multipart/form-data",
                        "Authorization": "Bearer "+getCookie('go_access_token')
                    },
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": formData
                }).done(function (response) {
                    // alert(true,'تم تغيير الصورة بنجاح ')
                    $('.user-prof-img').attr('src',blob);
                    loading(false)
                }).fail(function(err){
                    console.log('uploadAvatart ajax error::',err);
                    // alert(false,'يرجى المحاولة مرة أخرى')
                    // loading(false)
                });
            }
            this.isLoading = false;
            
        },
        closeModal() {
            this.$emit("close-image-modal");
        },
        processFile(event){
            this.uploadedImage = event.target.files[0]
        }
    }
};
// var blob = '';
//           var reader = new FileReader();
//           reader.onload = function (e) {
//             blob = e.target.result
//           }
//           reader.readAsDataURL(document.getElementById('avatar-input').files[0]);
</script>
<style scoped>
.images-box {
    border: 1px solid #707070;
}
.modal-body,.user-image-modal .modal-footer {
    width: 460px;
}
.user-image-modal dialog {
    top: 10%;
}
input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
.custom-file-upload img {
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    margin: auto;
}
.img-box {
    width: 100px;
    height: 100px;
    overflow: hidden;
}
.radio-img > input {
    position: absolute;
    left: 0;
    width: 100%;
    top: 0;
    height: 100%;
    visibility:hidden;
    z-index: 1;
}
.radio-img span {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: #660066;
    border: 1px solid #660066;
    border-radius:12px;
}
.radio-img > input:checked ~ span {
  background: transparent;
}
.user-img {
    border: 2px solid #660066;
}
</style>
