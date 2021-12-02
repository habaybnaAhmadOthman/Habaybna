<template>
    <div class="">
        <form @submit.prevent="submitForm" class="card-body">
            <div class="form-group mb-0-p">
                <label class="form-control-label">الاسم كامل</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group m-0-i">
                            <input
                                class="form-control"
                                placeholder="الإسم الأول"
                                id="firstName"
                                v-model="firstName"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-0-i">
                            <input
                                class="form-control"
                                placeholder="العائلة"
                                id="lastName"
                                v-model="lastName"
                                disabled
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group m-0-i">
                            <label class="form-control-label"
                                >البريد الإلكتروني</label
                            >
                            <input
                                class="form-control"
                                placeholder="البريد الإلكتروني"
                                id="email"
                                v-model="email"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">رقم الهاتف</label>
                        <div class="">
                            <input
                                class="form-control plaintext"
                                placeholder="رقم الهاتف"
                                id="phoneNumber"
                                v-model="phoneNumber"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-0-i">
                            <label class="form-control-label">الجنس</label>
                           <input
                                class="form-control plaintext"
                                placeholder="الجنس"
                                id="gender"
                                :value="gender.parsed"
                                disabled
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-control-label">مجال العمل</label>
                        <select
                            class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                            v-model="employment.val"
                            id="employment"
                        >
                            <option value="no" disabled hidden
                                >مجال العمل</option
                            >
                            <option value="قطاع التعليم">قطاع التعليم</option>
                            <option value="قطاع الصحة">قطاع الصحة</option>
                            <option value="منظمات المجتمع المدني"
                                >منظمات المجتمع المدني</option
                            >
                            <option value="القطاع الحكومي"
                                >القطاع الحكومي</option
                            >
                            <option value="القطاع الخاص">القطاع الخاص</option>
                            <option value="مجال الإعلام">مجال الإعلام</option>
                            <option value="عمل حر">عمل حر</option>
                            <option value="التدريب والإستشارات"
                                >التدريب والإستشارات</option
                            >
                            <option value="طلاب جامعية">طلاب جامعية</option>
                            <option value="طالب مدرسة">طالب مدرسة</option>
                            <option value="ربة منزل">ربة منزل</option>
                            <option value="لا أعمل">لا أعمل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <!-- work place -->

                        <label class="form-control-label">مكان العمل</label>
                        <input
                            class="form-control"
                            placeholder="مكان العمل"
                            id="workPlace"
                            v-model="workPlace.val"
                        />

                    </div>
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-control-label">سنة الميلاد</label>
                        <select
                            class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                            v-model="birthdate.val"
                            id="birthdate"
                        >
                            <option value="no" disabled hidden
                                >سنة الميلاد</option
                            >
                            <option v-for="year in years" :value="year" :key="year">{{year}}</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-control-label">التحصيل العلمي</label>
                        <select
                            class="form-control"
                            id="education"
                            v-model="education.val"
                        >
                            <option value="no" disabled hidden
                                >التحصيل العلمي</option
                            >
                            <option value="school">ثانوية عامة</option>
                            <option value="diploma">دبلوم</option>
                            <option value="Bachelor">بكالوريوس</option>
                            <option value="master">ماجستير</option>
                            <option value="doctorate">دكتوراه</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">المسمى الوظيفي</label>
                        <input
                            class="form-control"
                            placeholder="المسمى الوظيفي"
                            v-model.trim="jobTitle.val"
                        />
                    </div>
                </div>
            </div>
            <div class="form-group admin-control">
                <div class="">
                    <div class="w-100">
                        <label class="form-control-label">الإهتمامات</label>
                        <multiselect
                            v-model="tags"
                            :options="interestsList"
                            :searchable="true"
                            :close-on-select="false"
                            :multiple="true"
                            :taggable="true"
                            label="title"
                            track-by="title"
                            placeholder="يرجى إختيار الإهتمامات"
                        ></multiselect>
                        <p class="main-color mt-5 font-12" v-if="!tagsValid">
                            لا يمكنك ترك هذا الحقل فارغ
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-100 form-group">
                <label class="form-control-label">لماذا ترغب بالإنضمام لعائلة حبايبنا (150) كلمة</label>
                <textarea
                    rows="5"
                    type="text"
                    class="form-control trans"
                    placeholder="لماذا ترغب بالإنضمام لعائلة حبايبنا (150) كلمة"
                    id="whyToJoin"
                    @blur="checkValidity"
                    v-model.trim="whyToJoin.val"
                ></textarea>
            </div>

            <div class="">
                <div class="d-flex">
                    <button class="btn-2 flex-all font-20 ml-20">
                        حفظ
                    </button>
                    <button
                        class="bg-none border-0 main-color font-20 pointer font-16-p"
                        @click.prevent="showPasswordDialog"
                    >
                        تغيير كلمة المرور
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
    emits: ["submit-form", "open-password-dialog"],
    components: { Multiselect },
    props: ['years'],
    mounted() {
        this.getProfileData();
    },
    data() {
        return {
            tags: "",
            tagsValid: true,
            interestsList: [],
            firstName: "",
            lastName: "",
            email: "",
            phoneNumber: "",
            gender: {
                val: "no",
                parsed: null
            },
            employment: {
                val: "no",
                isValid: true
            },
            education: {
                val: "no",
                isValid: true
            },
            whyToJoin: {
                val: "",
                isValid: true
            },
            jobTitle: {
                val: "",
                isValid: true
            },
            workPlace: {
                val: "",
                isValid: true
            },
            birthdate: {
                val: "",
                isValid: true
            },
            formIsValid: true
        };
    },
    methods: {
        async getProfileData() {
            const obj = await this.$store.dispatch("user/getProfileData");
            const data = obj.userData;
            this.firstName = data.firstName;
            this.lastName = data.lastName;
            this.phoneNumber = data.phone;
            this.email = data.email;
            this.birthdate.val = new Date(data.dob).getFullYear();
            this.workPlace.val = data.work_place ;
            this.gender.val = data.gender;
            this.gender.parsed = data.gender == 'f' ? 'أنثى' : ('ذكر') ;
            this.education.val = data.edu_level || 'no';
            this.jobTitle.val = data.job_title;
            this.whyToJoin.val = data.why_to_join;
            this.employment.val = data.employment || 'no';
        },
        showPasswordDialog() {
            this.$emit("open-password-dialog");
        },
        validateForm() {
            this.formIsValid = true;
            this.tagsValid = true;
            // if (this.tags.length < 1) {
            //     this.tagsValid = false;
            // }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
        },
        submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            let employmentValue = this.employment.val;
            if (employmentValue == "no") {
                employmentValue = "";
            }
            let educationValue = this.education.val;
            if (educationValue == "no") {
                educationValue = "";
            }

            // let tagIDs = [];
            // this.tags.forEach(item => tagIDs.push(item.id));

            this.$emit("submitForm", {
                firstName: this.firstName,
                lastName: this.lastName,
                phone: this.phoneNumber,
                email: this.email,
                dob: this.birthdate.val,
                gender: this.gender.val,
                education: educationValue,
                employment: employmentValue,
                jobTitle: this.jobTitle.val,
                workPlace: this.workPlace.val,
                whyToJoin: this.whyToJoin.val,
                interests: []
            });
        }
    }
};
</script>
<style scoped>
.profile textarea {
    height: auto !important;
}
</style>
