<style>
.title {
  text-align: left;
  margin: 15px 0;
}
.sub-title {
  padding: 5px 15px;
  margin-top: 10px;
  background: #d6d6d6;
  border-radius: 5px;
  color: black;
  font-weight: 500;
  min-height: 500px;
}
.no-quiz {
  padding: 5px 15px;
  margin-top: 10px;
  background: #d6d6d6;
  border-radius: 5px;
  color: black;
  font-weight: 500;
  min-height: 200px;
  /* text-align: justify; */
}
.correct {
  background: lightgreen;
  font-weight: 600;
}
.title h1 {
  /* background: #515a6e; */
  color: #515a6e;
  border-radius: 4px;
  padding: 2px 16px;
  text-align: center;
  margin: 20px 0;
  display: inline-block;
}
select {
  width: 40%;
  border-radius: 4px;
  padding: 3px 7px;

  margin-bottom: 20px;
}
.question-answers {
}
.ivu-divider-horizontal {
  height: 2px !important;
  background: #a0939385 !important;
  margin: 18px 0px !important;
}
.question {
  display: inline-block;
  margin: auto;
  width: 100%;
  background-color: #fff;
  padding: 1%;
  border-radius: 5px;
  position: relative;
}
.options .ivu-icon {
  opacity: 0.6;
  display: inline-block;
  font-family: Ionicons;
  speak: none;
  font-style: normal;
  font-weight: 400;
  font-variant: normal;
  text-transform: none;
  text-rendering: optimizeLegibility;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  vertical-align: -0.125em;
  text-align: center;
  font-size: 30px;
  color: #7c7777;
  cursor: pointer;
}
.ivu-icon:hover {
  /* background-color: rgb(82, 199, 207); */
  border-radius: 5px;
  opacity: 1;
  /* padding: 1px; */
}

.question label {
  display: block;
  width: max-content;
  border-radius: 4px;
  padding: 2px 12px;
}

.options {
  position: absolute;
  left: 2%;
  /* border: 1px solid #bfbfbf; */
  padding: 10px 0px;
  border-radius: 3px;
}

.options .delete {
  color: #ff0a0a;
}
.ivu-divider-vertical {
  margin: 0 8px;
  display: inline-block;
  height: 29px !important;
  width: 3px !important;
  vertical-align: baseline;
  position: relative;
  top: -0.06em;
  background: #d6d6d6 !important;
}
</style>
<template>
  <div>
    <div class="title">
      <h1>{{ courseTitle }} - الاختبار</h1>
      <Button
        :to="'/admin/add-question/' + course_id"
        size="large"
        type="primary"
        >اضافة سؤال
      </Button>
      <div v-if="hasQuiz" class="sub-title">
        <div class="all-questions">
          <div
            class="question"
            v-for="(question, index) in questions"
            :key="index"
          >
            <div class="question-title">
              <h3>{{ index + 1 }} - {{ question.title }}</h3>
              <div class="options">
                <Button
                  @click="changeStatus(question.id, index)"
                  v-if="question.status"
                  size="small"
                  type="success"
                  >Enable</Button
                >
                <Button
                  @click="changeStatus(question.id, index)"
                  v-else
                  size="small"
                  type="error"
                  >Disable</Button
                >

                <Divider type="vertical" />

                <Icon
                  type="ios-build"
                  v-on:click="editAnswerForm(index, question.id)"
                />
                <Divider type="vertical" />
                <Icon
                  class="delete"
                  type="md-trash"
                  v-on:click="deleteQuestionDialog(index, question.id)"
                />
              </div>
            </div>
            <div class="question-answers">
              <label
                :class="{ correct: answer.is_correct }"
                v-for="(answer, i) in question.answers"
                :key="i"
              >
                <input
                  type="radio"
                  :checked="answer.is_correct"
                  disabled
                  :name="index"
                  v-on:change="setAnswerIndex(index, i)"
                />
                {{ answer.title }}
              </label>
              <Button
                :style="{ display: 'none', margin: '0 3%' }"
                size="small"
                type="primary"
                :name="index"
                @click="setNewAnswerID(index)"
              >
                حفظ
              </Button>
            </div>
            <Divider v-if="index !== questions.length - 1" />
          </div>
        </div>
      </div>
      <div v-else class="no-quiz">
        <h3>لا يوجد اسئلة !! قم باضافة سؤال</h3>
      </div>
    </div>
    <Modal v-model="dialogDelete" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span>حذف</span>
      </p>
      <div style="text-align: center">
        <p>هل انت متأكد من حذف السؤال ؟</p>
      </div>
      <div slot="footer">
        <Button
          type="error"
          size="large"
          long
          :loading="modal_loading"
          @click="deleteQuestion(deletedQuestion)"
          >حذف</Button
        >
      </div>
    </Modal>
  </div>
</template>
<script>
export default {
  created() {
    let course_id = this.$router.currentRoute.params.data;
    if (course_id) {
      this.course_id = course_id;
      this.getQuiz(course_id);
    }
  },
  updated() {},
  data() {
    return {
      value1: "",
      correct_answer: "",
      course_id: "",
      quizTitle: "",
      courseTitle: "",
      questions: [],
      hasQuiz: false,
      editedQuestion: null,
      dialogDelete: false,
      modal_loading: false,
      deletedQuestion: {
        question_id: null,
        index: null,
      },
    };
  },
  methods: {
    changeStatus(qId, index) {
      this.$store.dispatch("admin/changeQuestionStatus", qId);
      this.questions[index].status = !this.questions[index].status;
    },
    deleteQuestionDialog(index, qId) {
      this.dialogDelete = true;
      this.deletedQuestion.question_id = qId;
      this.deletedQuestion.index = index;
      //   this.questions[index].status = !this.questions[index].status;
      //   this.$store.dispatch("admin/deleteQuestion", qId);
    },
    deleteQuestion(data) {
      const resp = this.$store.dispatch(
        "admin/deleteQuestion",
        data.question_id
      );
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف السؤال");
        this.questions.splice(data.index, 1);
      }, 1500);
    },
    setAnswerIndex(qIndex, aIndex) {
      let qID = this.questions[qIndex].id;
      let aId = this.questions[qIndex].answers[aIndex].id;

      let newAswer = {
        question_id: qID,
        answer_id: aId,
      };

      this.editedQuestion = newAswer;
    },
    setNewAnswerID(index) {
      if (!this.editedQuestion) {
        this.questions[index].answers.forEach((answer) => {
          if (answer.is_correct) {
            let editedQ = {
              question_id: answer.question_id,
              answer_id: answer.id,
            };
            this.editedQuestion = editedQ;
          }
        });
      }
      this.questions[index].answers.forEach((answer) => {
        answer.is_correct =
          answer.id == this.editedQuestion.answer_id ? true : false;
      });
      this.$store
        .dispatch("admin/EditQuestion", this.editedQuestion)
        .then((res) => {
          var ele = this.questions.map((question, index) => {
            if (question.id == res.question_id) {
              document.getElementsByName(index).forEach((e) => {
                e.disabled = true;
                if (e.tagName !== "INPUT") e.style.display = "none";
              });
            }
          });
        })
        .catch((e) => {});
    },
    getQuiz(course_id) {
      this.$store.dispatch("admin/getCourseQuiz", course_id).then((res) => {
        if (!res.quiz) {
          this.hasQuiz = false;
        } else {
          this.questions = res.quiz;
          this.courseTitle = res.course_title;
          this.hasQuiz = true;
        }
      });
    },
    editAnswerForm(index, questionId) {
      let enableIds = document.getElementsByName(index);
      enableIds.forEach((e) => {
        e.disabled = false;
        e.style.display = "inline-block";
      });
      this.questions[index];
    },
    changeAnswer(e, index) {
      let data = { answerId: e.target.value };
      let questionId = this.edit_answer.questionId;
      axios.post("/admin/edit-answer/" + questionId, data).then((resp) => {
        if (resp.status == 200) {
          this.edit_answer.inEditMood = false;
          this.edit_answer.questionId = "";
          //   this.edit_answer.index = "";
          //   this.correct_answer = resp.data[0].title;

          let answers = this.questions[index].answers;
          for (let i = 0; i < answers.length; i++) {
            answers[i].is_correct = 0;
          }

          this.questions[index].answers[this.edit_answer.index].is_correct = 1;
          this.edit_answer.index = "";
        }
      });
    },
  },
};
</script>
