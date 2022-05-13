<style>
.flexxx {
  display: flex;
  align-items: center;
  /* flex-direction: ; */
  flex-wrap: wrap;
  justify-content: center;
}

.question-form {
  /* flex: 40% !important; */
  width: 40%;
  text-align: right;
  padding: 0 14px;
  margin: 14px 0;
}
.question-form label {
  margin: 0 !important;
}
.question-form-title {
  margin: 14px 0;
  display: flex;
  flex: 100%;
  flex-direction: row;
  padding: 10px;
}
.question-submit {
  flex: 100%;
  display: flex;
  margin: 15px 0px;
}
.question-form-title .right-side {
  /* background-color: blue; */
  flex: 50%;
  display: flex;
}
.right-side h3 {
  text-align: center;
  color: #74747f;
  font-size: 22px;
  font-family: revert;
}
.question-form-title .left-side {
  flex: 50%;
  display: flex;
  justify-content: flex-end;
  /* background-color: rgb(0, 255, 13); */
}
.ivu-form-item-error-tip {
  position: inherit !important;
  line-height: 1;
  padding-top: 3px !important;
}
.select-answer {
  text-align: right !important;
  direction: rtl !important;
}
</style>
<template>
  <div class="flexxx">
    <Form
      ref="formValidate"
      :model="formValidate"
      :rules="ruleValidate"
      :label-width="80"
      class="flexxx"
    >
      <div class="question-form-title">
        <div class="right-side">
          <h3>الاختبار - اضافة سؤال</h3>
        </div>
        <div class="left-side">
          <Button type="info" :to="'/admin/course-quiz/' + course_id"
            >رجوع</Button
          >
        </div>
      </div>
      <div class="question-form">
        <label for="question"> السؤال : </label>
        <Input
          id="question"
          v-model="formValidate.question"
          placeholder="ما هي عاصمة الاردن ؟"
        ></Input>
        <span class="error" v-if="!this.ruleValidate.question">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for="answer1"> الخيار الاول: </label>
        <Input
          id="answer1"
          v-model="formValidate.answers.answer1"
          placeholder="اربد"
        ></Input>
        <span class="error" v-if="!this.ruleValidate.answer1">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for=""> الخيار الثاني: </label>
        <Input
          v-model="formValidate.answers.answer2"
          placeholder="عمان"
        ></Input>
        <span class="error" v-if="!this.ruleValidate.answer2">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for=""> الخيار الثالث: </label>

        <Input
          v-model="formValidate.answers.answer3"
          placeholder="الزرقاء"
        ></Input>
        <span class="error" v-if="!this.ruleValidate.answer3">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="one-item-in-row">
        <label for="">
          الحالة :

          <RadioGroup v-model="formValidate.status">
            <Radio label="1">نشط</Radio>
            <Radio label="0">غير نشط</Radio>
          </RadioGroup>
        </label>
        <div for="">
          <span class="error" v-if="!this.ruleValidate.status">
            * يجب اختيار الحالة
          </span>
        </div>
      </div>

      <FormItem class="question-submit">
        <Button type="primary" @click="handleSubmit()">حفظ</Button>
        <!-- <Button @click="handleReset('formValidate')" style="margin-left: 8px"
          >افرغ الحقول</Button
        > -->
      </FormItem>
      <Modal
        v-model="correctAnswerModal"
        title="اختر الاجابة الصحية"
        @on-ok="ok(correctAnswer)"
        class="select-answer"
      >
        <Form ref="formValidate" :model="formValidate" :label-width="80">
          <h2 :style="{ margin: '25px' }">
            {{ question.title }}
          </h2>
          <FormItem>
            <Select v-model="correctAnswer" required>
              <Option
                :style="{ textAlign: 'right' }"
                v-for="(one, index) in question.answers"
                :key="index"
                :value="one.id"
                >{{ one.title }}</Option
              >
            </Select>
          </FormItem>
        </Form>
      </Modal>
    </Form>
  </div>
</template>
<script>
export default {
  created() {
    this.course_id = this.$router.currentRoute.params.data;
    this.formValidate.course_id = this.course_id ;
  },
  data() {
    return {
      course_id: "",
      formValidate: {
        question: "",
        answers: {
          answer1: "",
          answer2: "",
          answer3: "",
        },
        course_id: "",
        status: "",
      },
      ruleValidate: {
        question: true,
        answer1: true,
        answer2: true,
        answer3: true,
        status: true,
      },
      correctAnswerModal: false,
      question: "",
      correctAnswer: "",
      isValid: true,
    };
  },
  methods: {
    handleSubmit() {
      this.validForm();

      if (this.isValid) {
        axios
          .post("/api/admin/question-store", this.formValidate)
          .then((resp) => {
            this.correctAnswerModal = true;
            if (resp.status == 200) {
              this.question = resp.data.question[0];
              this.$Message.success(" تم اضافة السؤال");
            }
          })
          .catch((e) => {
            this.$Message.error("حدث خطأ ما");
          });
      }
    },
    // handleReset(name) {
    //   this.$refs[name].resetFields();
    // },
    ok(id) {
      axios.post("/api/admin/set-correct-answer/" + id).then((resp) => {
        if (resp.status == 200) {
          this.formValidate = {
            title: "",
            question: "",
            answers: {
              answer1: "",
              answer2: "",
              answer3: "",
            },
            course_id: "",
            status: "",
          };
          this.$Message.success(" تم اضافة السؤال ");
          this.$router.push("/admin/course-quiz/"+this.course_id);
        }
      });
    },
    validForm() {
      if (this.formValidate.question == "") {
        this.ruleValidate.question = false;
      } else {
        this.ruleValidate.question = true;
      }
      if (this.formValidate.answers.answer1 == "") {
        this.ruleValidate.answer1 = false;
      } else {
        this.ruleValidate.answer1 = true;
      }
      if (this.formValidate.answers.answer2 == "") {
        this.ruleValidate.answer2 = false;
      } else {
        this.ruleValidate.answer2 = true;
      }
      if (this.formValidate.answers.answer3 == "") {
        this.ruleValidate.answer3 = false;
      } else {
        this.ruleValidate.answer3 = true;
      }
      if (this.formValidate.status == "") {
        this.ruleValidate.status = false;
      } else {
        this.ruleValidate.status = true;
      }

      for (const prob in this.ruleValidate) {
        if (Object.hasOwnProperty.call(this.ruleValidate, prob)) {
          const element = this.ruleValidate[prob];
          if (!element) {
            this.isValid = false;
            this.$Message.error("يرجى التحقق من الحقول");
            break;
          }
        }
      }
    },
  },
};
</script>

