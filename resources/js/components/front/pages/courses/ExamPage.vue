<template>
    <div class="exam-page">
        <TheHeader></TheHeader>
        <div class="container">
            <h1 class="title-line font-27 mb-20 mb-30-p mt-50 m-side-12-p">يمكنك الآن الالتحاق بالإختبار</h1>
            <div class="exam-container card-1 pt-50 m-side-12-p pt-20-p pb-40" v-if="isDataReady">
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
        <button v-if="isExamFinished" @click="getCertificate" class="btn-main bold font-18">إصدار الشهادة</button>
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
        isLoading(status) {
            this.$store.commit("isLoading", status);
        },
        submitQuestion(answer) {
            if (this.currentQuestion < this.questionsCount - 1) {
                this.questions[this.currentQuestion].userAnswer = answer;
                this.currentQuestion += 1;
            } else {
                this.passExam()    
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
            this.setInfoModal('إجابة خاطئة','عليك المحاولة مرة أخرى  للوصول للإجابة الصحيحة', false,false,true)
        },
        correctAnswerDialog(){
            this.setInfoModal('لقد اجتزت الامتحان بنجاح','يمكنك إصدار الشهادة الآن',true,true,true)
        },
        // pass exam
        async passExam(){
            this.isLoading(true);
            let isPassed = await this.$store.dispatch('courses/passExam',{
                courseID: this.courseData.id
            })
            this.isExamFinished = true
            this.isLoading(false);
            if (isPassed)
                this.correctAnswerDialog()
        },
        getCertificate(){
            this.$router.replace(`/course/${this.course}/certificate`)
        },
        async getQuestions() {
            try {
                this.isLoading(true);
                this.courseData = await this.$store.dispatch('courses/getMyCourseData',this.course);
                let exam = await this.$store.dispatch('courses/getExam',{
                    courseID: this.courseData.id
                })
                
                this.questions = this.shuffle(exam)
                this.questionsCount = this.questions.length
                
                this.isDataReady = true;
            } catch (e) {
                console.log('error')
            }
            this.isLoading(false);
        }
    },
    data() {
        return {
            questionsCount: 1,
            currentQuestion:0,
            courseData: null,
            questions: [],
            isDataReady: false,
            isExamFinished: false
        }
    },
    async created(){
        await this.getQuestions();
        
        
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
