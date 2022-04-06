<template>
    <div class="exam-page">
        <TheHeader></TheHeader>
        <div class="container">
            <h1 class="title-line font-27 mb-20 mb-30-p mt-50 m-side-12-p">يمكنك الآن الالتحاق بالإختبار</h1>
            <div class="exam-container card-1 pt-50 m-side-12-p pt-20-p pb-40">
                <div class="mb-40">
                    <StatusBar :questionsCount="questionsCount" :currentQuestion="currentQuestion"></StatusBar>
                </div>
                <div class="questions-box">
                    <ExamQuestion @wrongAnswerDialog="wrongAnswerDialog" @submitQuestion="submitQuestion" :question="questions[currentQuestion]"></ExamQuestion>
                </div>
            </div>
        </div>

        <div class="page-footer">
            <TheFooter></TheFooter>
        </div>
        <info-modal
          :show="infoModal.show"
          :title="infoModal.title"
          @close="closeInfoModal"
          :description="infoModal.description"
          :success="infoModal.status"
          :fixed="infoModal.isFixed"
        >
        <router-link v-if="infoModal.status" to="/certificate" class="btn-main bold font-18">إصدار الشهادة</router-link>
        </info-modal>
    </div>
</template>

<script>
import TheFooter from '../../layouts/TheFooter.vue'
import TheHeader from '../../layouts/header/TheHeader.vue'
import StatusBar from '../../views/coursepage/exampage/StatusBar.vue'
import ExamQuestion from '../../views/coursepage/exampage/ExamQuestion.vue'

import infoModalMixin from '../../mixins/infoModal'
export default {
    props: ['course'],
    mixins: [infoModalMixin],
    components: {TheFooter,TheHeader,StatusBar,ExamQuestion},
    methods: {
        submitQuestion(answer) {
            if (this.currentQuestion < this.questionsCount) {
                this.questions[this.currentQuestion].userAnswer = answer;
                this.currentQuestion += 1;
            } else {
                // api call to get user result
                this.correctAnswerDialog()
            }
        },
        shuffle(arr) {
            for (let i = arr.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arr[i], arr[j]] = [arr[j], arr[i]];
            }
            return arr;
        },
        wrongAnswerDialog(){
            this.setInfoModal('إجابة خاطئة','يرجى التأكد من الإجابة', false,false,true)
        },
        correctAnswerDialog(){
            this.setInfoModal('لقد اجتزت الامتحان بنجاح','يمكنك إصدار الشهادة الآن',true,true,true)
        },
        async getQuestions(){
            this.courseData = await this.$store.dispatch('courses/getMyCourseData',this.course);
            let ExamQuestions = await this.$store.dispatch('courses/getExam',{
                courseID: this.courseData.id
            })
            console.log(ExamQuestions);
            this.questions = this.shuffle(ExamQuestions)
        }
    },
    data() {
        return {
            questionsCount: 1,
            currentQuestion:0,
            courseData: null,
            questions: [],
        }
    },
    async created(){
        await this.getQuestions();
        var temp = [{
                    title: 'ما هو تعريف مرض التوحد',
                    userAnswer: null,
                    correctAnswer:1,
                    options:
                    [
                        {
                            id: 1,
                            title: 'هو اضطراب عصبي نمائي مهم تظهر فيه أعراض في مرحلة الطفولة المبكرة.',
                        },
                        {
                            id: 2,
                            title: 'هو اضطراب عصبي نمائي مهم تظهر فيه أعراض في مرحلة الطفولة المبكرة.',
                        },
                    ],

                },
                {
                    title: 'ما هو ',
                    userAnswer: null,
                    correctAnswer: 2,
                    options:
                    [
                        {
                            id: 1,
                            title: 'هو اضطراب عصبي نمائي مهم تظهر فيه أعراض في مرحلة الطفولة المبكرة.',

                        },
                        {
                            id: 2,
                            title: 'هو اضطراب عصبي نمائي مهم تظهر فيه أعراض في مرحلة الطفولة المبكرة.',
                        },
                    ],

                }
            ]
        this.questions = this.shuffle(temp)
    },

};
</script>
<style scoped>
.page-footer {
    margin-top: 120px;
}
.questions-box {
    padding: 0 90px 0 80px;
}
@media (max-width: 767px) {
    .questions-box {
        padding: 0 12px;
    }
}
</style>
