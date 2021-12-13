<template>
    <alert-dialog :show="show" title="تغيير الصورة الشخصية" @close="closeModal" :modal-class="'user-image-modal'">
        <template>
            <div class="modal-body m-side-auto">
                <img
                    :src="userAvatarTemp"
                    width="100"
                    height="100"
                    class="m-side-auto d-block radius-60 user-img object-fit"
                />
                <p class="main-color font-22">اختر شخصية</p>
                <div class="d-flex flex-wrap space-between images-box radius-12 p-10">
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15" >
                        <input type="radio" value="/images/siteImgs/header/logo.png" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="/images/siteImgs/home-banner.jpg" v-model="selectedImage" />
                        <img src="/images/siteImgs/home-banner.jpg" width="88" height="83" class="z-1 radius-12" />
                        <span></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="A3" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative mb-15">
                        <input type="radio" value="A4" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A5" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A6" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A7" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
                        <span class="trans"></span>
                    </label>
                    <label class="img-box radio-img pointer flex-all radius-12 relative">
                        <input type="radio" value="A8" v-model="selectedImage" />
                        <img src="/images/siteImgs/header/logo.png" width="88" height="83" class="z-1 radius-12" />
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
    emits: ["close-image-modal","popup-alert"],
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
            userAvatarTemp: null,
            formIsValid: true
        }
    },
    watch: {
        userAvatar(newV) {
            this.userAvatarTemp = newV;
        }
    },
    methods: {
        async submitForm() {
            this.formIsValid = true;
            self = this
            // submit then
            // this.closeModal();
            if (!this.uploadedImage && !this.selectedImage) {
                this.formIsValid = false;
                return false;
            }
            self.$emit('loading',true);
            var formData = new FormData();
            if (this.uploadedImage) {
                formData.append("url", this.uploadedImage, this.uploadedImage.name);
            } else {
                formData.append("avatar", this.selectedImage);
            }

            await $.ajax({
                "url": "/api/edit-profile-image",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "enctype": "multipart/form-data",
                    "X-CSRF-TOKEN": document.querySelector('[name="csrf-token"]').getAttribute('content')
                },
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": formData
            }).done(function (response) {
                self.$emit('popup-alert','showUserImageModal','تم حفظ التغييرات')
                response = JSON.parse(response)
                self.$store.commit('user/userAvatar',response.url);
                self.userAvatarTemp = response.url;
                document.querySelector('.user-avatar-get').setAttribute('src',response.url)
            }).fail(function(err){
                self.$emit('popup-alert','showUserImageModal','حصل خطأ ما')
                self.$emit('loading',false);
            });
            
            self.$emit('loading',false);

        },
        closeModal() {
            this.$emit("close-image-modal");
        },
        processFile(event){
            self = this
            if (event.target.files[0]) {
                self.$emit('loading',true);
                this.uploadedImage = event.target.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    self.$emit('loading',false);
                    self.userAvatarTemp = e.target.result
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    }
};

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
