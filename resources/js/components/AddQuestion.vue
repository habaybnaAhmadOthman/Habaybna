<template>
  <Form
    ref="formValidate"
    :model="formValidate"
    :rules="ruleValidate"
    :label-width="80"
  >
    <!-- <FormItem label="Title" prop="title">
      <Input
        v-model="formValidate.title"
        placeholder="Enter Quiz title"
      ></Input>
    </FormItem> -->
    <FormItem prop="question">
      <label for="">
        السؤال
        <Input
          v-model="formValidate.question"
          placeholder="Enter your Question"
        ></Input>
      </label>
    </FormItem>
    <FormItem label="Answer 1" prop="answers.answer1">
      <Input
        v-model="formValidate.answers.answer1"
        placeholder="Enter first answer"
      ></Input>
    </FormItem>
    <FormItem label="Answer 2" prop="answers.answer2">
      <Input
        v-model="formValidate.answers.answer2"
        placeholder="Enter second answer"
      ></Input>
    </FormItem>
    <FormItem label="Answer 3" prop="answers.answer3">
      <Input
        v-model="formValidate.answers.answer3"
        placeholder="Enter third answer"
      ></Input>
    </FormItem>
    <FormItem label="Status" prop="status">
      <RadioGroup v-model="formValidate.status">
        <Radio label="1">Active</Radio>
        <Radio label="0">Inactive</Radio>
      </RadioGroup>
    </FormItem>

    <FormItem>
      <Button type="primary" @click="handleSubmit('formValidate')"
        >Submit</Button
      >
      <Button @click="handleReset('formValidate')" style="margin-left: 8px"
        >Reset</Button
      >
    </FormItem>
    <Modal
      v-model="correctAnswerModal"
      title="Select the correct answer"
      @on-ok="ok(correctAnswer)"
    >
      <Form
        ref="formValidate"
        :model="formValidate"
        :rules="ruleValidate"
        :label-width="80"
      >
        <h2 :style="{ textAlign: 'right', margin: '25px' }">
          {{ question.title }}
        </h2>
        <FormItem>
          <Select v-model="correctAnswer">
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
</template>
<script>
export default {
  data() {
    return {
      formValidate: {
        title: "",
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
        question: [
          {
            required: true,
            message: "The question cannot be empty",
            trigger: "blur",
          },
        ],
        answer1: [
          {
            required: true,
            message: "The first answer cannot be empty",
            trigger: "blur",
          },
        ],
        answer2: [
          {
            required: true,
            message: "The second answer cannot be empty",
            trigger: "blur",
          },
        ],
        answer3: [
          {
            required: true,
            message: "The third answer cannot be empty",
            trigger: "blur",
          },
        ],
        // answer3: [
        //   {
        //     required: true,
        //     message: "The third answer cannot be empty",
        //     trigger: "blur",
        //   },
        // ],
        status: [
          {
            required: true,
            message: "The status cannot be empty",
            trigger: "blur",
          },
        ],
      },
      correctAnswerModal: false,
      question: "",
      correctAnswer: "",
    };
  },
  methods: {
    handleSubmit(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.formValidate.course_id = this.$router.currentRoute.params.data;
          axios
            .post("/admin/question-store", this.formValidate)
            .then((resp) => {
              this.correctAnswerModal = true;
              if (resp.status == 200) {
                this.question = resp.data.question[0];
                console.log(this.question);
              }
            });
        } else {
          this.$Message.error("Fail!");
        }
      });
    },
    handleReset(name) {
      this.$refs[name].resetFields();
    },
    ok(id) {
      axios.post("/admin/set-correct-answer/" + id).then((resp) => {
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
          this.$Message.success("question added successfully");
        }
      });
    },
  },
};
</script>

