<template>
    <div class="contact-us-section pt-30 pb-30">
        <div class="container p-side-12-p">
            <h2 class="font-27 bold white mb-20 font-20-p">تواصلوا معنا</h2>
            <p class="white mb-30 font-24 font-16-p">نسعد بالإجابة عن استفسارتكم ومشاركتنا اقتراحاتكم أو تقديم المساعدة، يمكنكم التواصل معنا بأي وقت وسيقوم أحد أعضاء فريق حبايبنا بالرد عليكم في أقرب وقت</p>
            <div class="d-flex contact-row flex-wrap-p">
                <form @submit.prevent="submitForm" class="w-70 w-100-p">
                    <div class="d-flex gap-20 mb-20">
                        <div
                            class="form-group relative w-50"
                        >
                            <input
                                v-model.trim="name.val"
                                id="name"
                                type="text"
                                class="form-control font-18 holder-center w-100"
                                placeholder="الاسم"
                            />
                        </div>
                        <div
                            class="form-group relative w-50"
                            :class="{ invalid: !email.isValid }"
                        >
                            <input
                                v-model.trim="email.val"
                                id="email"
                                type="email"
                                class="form-control font-18 holder-center w-100"
                                placeholder=" البريد الالكتروني"
                            />
                            <p class="white-i mt-5 font-12">هذا الحقل مطلوب</p>
                        </div>
                    </div>
                    <div
                            class="form-group mb-20 relative"
                            :class="{ invalid: !message.isValid }"
                        >
                            <textarea
                                v-model.trim="message.val"
                                id="message"
                                class="form-control font-18 holder-center w-100"
                                placeholder="الرسالة"
                                rows="5"
                            ></textarea>
                            <p class="white-i mt-5 font-12">هذا الحقل مطلوب</p>
                    </div>
                    <div class="">
                        <button class="btn w-40 w-100-p">أرسل</button>
                    </div>
                </form>
                <div class="w-30 info w-100-p mt-15-p">
                    <div class="icons font-20 font-16-p bold ltr">
                        <div class="white d-flex align-center mb-15">
                            <figure class="mr-20">
                                <img class="email-icon"  src="/images/email-icon.svg" alt="" width="28" height="21">
                            </figure>
                            community@habaybna.net
                        </div>
                        <div class="white d-flex align-center mb-15">
                            <figure class="mr-20">
                                <img class="location-icon" src="/images/location-icon.svg" alt="" width="22" height="38">
                            </figure>
                            عمان - الأردن
                        </div>
                            <!-- <a class="whatsapp-float whatapp from-bottom" href="https://api.whatsapp.com/send?phone=+962779383333&amp;text=Hello ,I want a ride." data-action="share/whatsapp/share" target="_blank"> </a> -->
                        <a class="white d-flex align-center" href="https://api.whatsapp.com/send?phone=00962799760238" data-action="share/whatsapp/share" target="_blank">
                            <figure class="mr-20">
                                <img class="phone-icon" src="/images/whatsapp.png" alt="" width="28" height="28">
                            </figure>
                            00962 799760238
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                email: {
                    val: '',
                    isValid: true,
                },
                name: {
                    val: '',
                    isValid: true,
                },
                message: {
                    val: '',
                    isValid: true,
                },
                formIsValid: true,
            }
        },
        methods: {
            validateForm() {
                this.formIsValid = true;
                this.message.isValid = true;
                this.email.isValid = true;
                if (this.message.val == "") {
                    this.message.isValid = false;
                    this.formIsValid = false;
                }

                if (this.email.val == "") {
                    this.email.isValid = false;
                    this.formIsValid = false;
                }

            },
            submitForm(){
                this.validateForm();
                if (!this.formIsValid) {
                    return;
                }
                try {
                    this.$store.dispatch('content/contactUS', {
                        email: this.email.val,
                        message: this.message.val,
                        name: this.name.val,
                    });
                    this.$store.commit("alertDialogMsg", 'تم ارسال طلبك بنجاح');
                    this.email.val = '';
                    this.message.val = '';
                    this.name.val = '';
                } catch (e) {
                    this.$store.commit("alertDialogMsg", e.message);
                }
                // this.sendMail()
            },
            sendMail(){
                //update this with your $form selector
                var data = {
                    "access_token": "----"
                };

                function onSuccess() {
                }

                function onError(error) {
                    // remove this to avoid redirect
                    // window.location = window.location.pathname + "?message=Email+could+not+be+sent.&isError=1";
                }


                function send() {
                    var subject = 'Contact Us Form';
                    var message = $('#message').val();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    data['subject'] = subject;
                    data['text'] = message;
                    data['name'] = name;
                    data['email'] = email;

                    $.post('/api/contact-us',
                        data,
                        onSuccess
                    ).fail(onError);

                    return false;
                }

                send()
            }
        }
    }
</script>

<style scoped>
.contact-us-section {
    background: #823175;
}
input,textarea {
    box-shadow: 0px 3px 6px #00000029;
    border: 0.5px solid #B7B7B7;
    border-radius: 10px;
    padding: 33px;
    font-size: 20px;
}
textarea {
    height:auto;
}
.btn {
    background: #3FC4E0;
    border-color: #3FC4E0;
    font-size: 18px;
    color: #fff!important;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 25px;
    height: 60px;
}
.btn:hover {
    color: #823175!important;
}
.icons figure {
    width: 28px;
    display:flex;
}
@media (max-width: 767px) {
    input,textarea {
        padding: 10px;
        font-size: 15px;
    }
    .icons figure {
        width: 17px;
        display:flex;
    }
    .email-icon {
        width: 17px;
        height: 13px;
    }
    .location-icon {
        width: 14px;
        height: 24px;
    }
    .phone-icon {
        width: 17px;
        height: 17px;
    }
}
</style>
