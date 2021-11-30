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
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-control-label">سنة الميلاد</label>
                        <input
                            class="form-control"
                            placeholder="1999"
                            v-model="birthdate.val"
                        />
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-0-i">
                            <label class="form-control-label">الجنس</label>
                            <select
                                class="form-control"
                                id="gender"
                                v-model="gender.val"
                            >
                                <option value="no" disabled hidden
                                    >الجنس</option
                                >
                                <option value="m">ذكر</option>
                                <option value="f">أنثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">صلة القرابة</label>
                        <select
                            class="form-control"
                            id="relative"
                            v-model="relative.val"
                        >
                            <option value="no" disabled hidden
                                >صلة القرابة</option
                            >
                            <option value="parent">أب / أم</option>
                            <option value="brother">أخ / آخت</option>
                            <option value="relative">أقرباء</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-control-label">المدينة</label>
                        <input
                            class="form-control"
                            placeholder="المدينة"
                            v-model="city.val"
                        />
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">عدد الأبناء</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="عدد الأبناء"
                            v-model.trim="noChilds.val"
                        />
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label"
                            >عدد الأبناء المتأخرين في التطور</label
                        >
                        <input
                            type="number"
                            class="form-control"
                            placeholder="عدد الأبناء المتأخرين في التطور"
                            v-model.trim="noChildsSpecialNeeds.val"
                        />
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
                        <label class="form-control-label">مجال العمل</label>
                        <select
                            class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans"
                            v-model="empolyment.val"
                            id="empolyment"
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

            <div class="form-group d-flex">
                <label class="checkbox main-color font-16">
                    <input
                        type="checkbox"
                        name="checkbox-checked"
                        v-model="privateMode"
                    />
                    تفعيل نظام الخصوصية
                </label>
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
    mounted() {
        this.getProfileData();
    },
    data() {
        return {
            tags: "",
            tagsValid: true,
            firstName: "",
            lastName: "",
            email: "",
            phoneNumber: "",
            interestsList: [],
            privateMode: false,
            gender: {
                val: "no",
                isValid: true
            },
            relative: {
                val: "no",
                isValid: true
            },
            empolyment: {
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
            city: {
                val: "",
                isValid: true
            },
            jobTitle: {
                val: "",
                isValid: true
            },
            birthdate: {
                val: "",
                isValid: true
            },
            noChilds: {
                val: "",
                isValid: true
            },
            noChildsSpecialNeeds: {
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
            this.gender.val = data.gender;
            this.relative.val = data.relative;
            this.noChildsSpecialNeeds.val = data.speci_childs_count;
            this.whyToJoin.val = data.why_to_join;
            this.city.val = data.city;
            this.noChilds.val = data.childs_count;
            this.education.val = data.edu_level || 'no';
            this.empolyment.val = data.employment || 'no';
            this.jobTitle.val = data.job_title;
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
            if (this.empolyment.val == "no") {
                this.empolyment.isValid = false;
                this.empolyment.val = "";
            }
            if (this.education.val == "no") {
                this.education.isValid = false;
                this.education.val = "";
            }

            // let tagIDs = [];
            // this.tags.forEach(item => tagIDs.push(item.id));
            this.$emit("submitForm", {
                firstName: this.firstName,
                lastName: this.lastName,
                phone: this.phoneNumber,
                email: this.email,
                birthdate: this.birthdate.val,
                gender: this.gender.val,
                relative: this.relative.val,
                noChildsSpecialNeeds: this.noChildsSpecialNeeds.val,
                whyToJoin: this.whyToJoin.val,
                city: this.city.val,
                noChilds: this.noChilds.val,
                education: this.education.val,
                empolyment: this.empolyment.val,
                jobTitle: this.jobTitle.val,
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
.checkbox {
    font-weight: bold;
    line-height: 1.1;
    display: flex;
    cursor: pointer;
    align-items: center;
}
input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    margin: 0;
    width: 25px;
    height: 25px;
    border: 1px solid #660066;
    border-radius: 3px;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
    margin-left: 12px;
}

input[type="checkbox"]::before {
    content: "";
    width: 15px;
    height: 15px;
    -webkit-clip-path: polygon(
        14% 44%,
        0 65%,
        50% 100%,
        100% 16%,
        80% 0%,
        43% 62%
    );
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    transform: scale(0);
    transform-origin: bottom left;
    transition: 120ms transform ease-in-out;
    /* Windows High Contrast Mode */
    background-color: CanvasText;
}

input[type="checkbox"]:checked::before {
    transform: scale(1);
}
</style>
