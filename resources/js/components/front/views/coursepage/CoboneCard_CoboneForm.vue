<template>
    <div class="w-100">
        <form
            @submit.prevent="submitCoubon"
            class="cobone-form relative d-flex w-100"
        >
            <input
                type="text"
                v-model="promoCode"
                class="w-80 cobone-input"
                placeholder="هل لديك كوبون أو قسيمة شرائية استخدمها الآن ؟"
            />
            <input type="submit" value="" class="apply-cobone w-10 pointer" />
        </form>
        <info-modal
            :show="infoModal.show"
            :title="infoModal.title"
            @close="closeInfoModal"
            :description="infoModal.description"
            :success="infoModal.status"
            :fixed="infoModal.isFixed"
            :optionsClass="!infoModal.isFixed ?  'space-between-i' : '' "
            portal="cobone-modal"
        >
            <div class="d-flex" v-if="discountVal && coursePrice && !infoModal.isFixed">
                <span class="gray font-35 before-discount bold ml-30">
                    <template >{{ coursePrice }} $</template>
                </span>
                <span class="bold font-35 main-color"
                    v-if="coursePrice"
                    >{{ discountVal }} $</span
                >
            </div>
            <button v-if="infoModal.isFixed" @click="goToClassRoom" class="btn">مشاهدة</button>
            <button v-else @click="buyCourse" class="btn">
                إشترك الآن
            </button>
        </info-modal>
    </div>
</template>

<script>
import infoModalMixin from '../../mixins/infoModal'
export default {
    mixins:[infoModalMixin],
    emits: ["buyCourse"],
    props: ["courseID", "isLoggedIn","coursePrice","courseName"],
    data() {
        return {
            promoCode: "",
            discountVal: null
        };
    },
    methods: {
        isLoading(status) {
            this.$store.commit("isLoading", status);
        },
        buyCourse(){
            this.$emit('buyCourse');
        },
        async submitCoubon() {
            this.infoModal.isFixed = false
            if (!this.isLoggedIn) {
                this.$store.commit("loginModal", true);
                return false;
            }
            if (this.promoCode == "") {
                this.$store.commit("alertDialogMsg", "يرجى إدخال كود الخصم");
                return false;
            }
            let checkPromoCode;

            this.isLoading(true);
            try {
                checkPromoCode = await this.$store.dispatch(
                    "courses/promoCode",
                    {
                        courseID: this.courseID(),
                        promoCode: this.promoCode,
                        usage: "Course"
                    }
                );
                if (checkPromoCode.isValid) {
                    this.$emit("getPromoCode", checkPromoCode.id);
                }
            } catch (error) {
                console.log(error);
            }
            this.isLoading(false);
            if (!checkPromoCode) {
                this.$store.commit("alertDialogMsg", "كود الخصم غير صحيح");
                return;
            }
            if (checkPromoCode.discount_perc == 100) { // free
                await this.$store.dispatch('courses/getFreeCourse',{
                        courseID: this.courseID(),
                        hasPromoCode: {
                            id: checkPromoCode.id
                        },
                        usage: "Course"
                })
                await this.$store.dispatch('courses/getAllCourses')
                this.setInfoModal('يمكنك الآن مشاهدة الدورة','لقد قمت بإدخال رقم الكوبون بنجاح',true,true,true)
            } else { // discount success
            
                this.discountVal = this.coursePrice - (this.coursePrice * (checkPromoCode.discount_perc / 100));
                this.setInfoModal('يمكنك إتمام عملية الشراء','لقد قمت بإدخال رقم الكوبون بنجاح',true,false,true)
            }
        },
        async goToClassRoom() {
            const courseLectures = await this.$store.dispatch('courses/getCourseLectures',{
                courseID: this.courseID()
            })
            this.$router.replace(`/courses/${this.courseName.split(' ').join('-')}/${courseLectures[0].title.split(' ').join('-')}`)
        },
    }
};
</script>

<style scoped>
.cobone-form {
    height: 60px;
}
.cobone-input {
    border: 1px solid #939598;
    border-radius: 0 25px 25px 0;
    color: #939598;
    font-size: 12px;
    padding: 20px 8px;
}
.apply-cobone {
    background-color: #632f63;
    position: relative;
    border-radius: 25px 0 0 25px;
    border: 0;
    width: 20%;
    background-image: url(/images/arrow-left.svg);
    background-repeat: no-repeat;
    background-position: center;
}
.before-discount {
    position: relative;
    top: 1px;
}
.before-discount:after {
    content: '';
    position: absolute;
    left: -4px;
    top: -3px;
    bottom: 0;
    margin: auto;
    width: 108%;
    height: 1px;
    background: red;
}
.btn {
    width: 340px;
    font-size: 18px;
    font-weight: bold;
    height: 60px;
    border-radius: 25px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (max-width: 767px) {
    .cobone-form {
        height: 50px;
    }
}
</style>
