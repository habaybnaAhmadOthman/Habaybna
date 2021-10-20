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
}
.correct-answer {
  text-align: center;
  background: lightgreen;
  padding: 7px;
  border-radius: 5px;
  margin: 20px 0;
  font-size: 17px;
  font-weight: 600;
}
h1 {
  background: #515a6e;
  color: #fff;
  border-radius: 4px;
  padding: 2px 16px;
  text-align: center;
  margin: 20px 0;
}
select {
  width: 40%;
  border-radius: 4px;
  padding: 3px 7px;

  margin-bottom: 20px;
}
</style>
<template>
  <div>
    <div class="title">
      <h1>Course Quiz</h1>
      <div class="sub-title">
        <Button
          :to="'/admin/add-question/' + course_id"
          size="small"
          type="primary"
          :style="{ float: 'right' }"
          >Add Qutestion</Button
        >

        <p>Course Title : {{ courseTitle }}</p>
        <p>Quiz Title : {{ quizTitle }}</p>
      </div>
    </div>
    <Collapse v-model="value1">
      <Panel v-if="hasQuiz" v-for="(question, index) in questions" :key="index">
        {{ question.title }}
        <div slot="content">
          <div v-for="(answer, i) in question.answers" :key="i">
            <strong v-if="answer.is_correct">Correct Answer: </strong>
            <p class="correct-answer" v-if="answer.is_correct">
              {{ correct_answer ? correct_answer : answer.title }}
            </p>
          </div>
          <div v-if="edit_answer.index === index && edit_answer.inEditMood">
            <select @change="changeAnswer($event, index)" id="ansers">
              <option value="" selected>Select correct answer</option>
              <option
                v-for="(answer, index) in question.answers"
                :key="index"
                :value="answer.id"
              >
                {{ answer.title }}
              </option>
            </select>
          </div>
          <div v-if="edit_answer.inEditMood === false">
            <Button type="info" @click="editAnswerForm(index, question.id)"
              >edit</Button
            >
          </div>
        </div>
      </Panel>
    </Collapse>
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
  updated() {
    console.log("update");
  },
  data() {
    return {
      value1: "",
      correct_answer: "",
      course_id: "",
      quizTitle: "",
      courseTitle: "",
      questions: [],
      hasQuiz: false,
      edit_answer: {
        questionId: "",
        index: "",
        newAnswer: "",
        inEditMood: false,
      },
    };
  },
  methods: {
    getQuiz(course_id) {
      axios.get("/admin/get-quiz/" + course_id).then((resp) => {
        if (resp.status == 200) {
          this.quizTitle = resp.data[0].quiz_title;
          this.courseTitle = resp.data[0].course_title;
          this.questions = resp.data[0].quesiotns;
          console.log(this.questions[0].answers);
          this.hasQuiz = true;
        }
      });
    },
    editAnswerForm(index, questionId) {
      this.edit_answer.inEditMood = true;
      this.edit_answer.questionId = questionId;
      this.edit_answer.index = index;
      console.log(this.edit_answer);
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
