<template>
    <div class="exam-question">
        <h2 class="main-color font-27 font-20-p mb-20-p bold mb-30">{{question.title}}</h2>
        <div class="quiz-box">
            <div class="form-group" v-for="item in question.options" :key="item.id">
                <label class="checkbox black-2 font-27 font-16-p" :for="item.id">
                    <input type="radio" :id="item.id" :value="item.id" v-model="answer"  />
                    {{item.title}}
                </label>
            </div>
        </div>
        <div class="submit-box d-flex flex-end">
            <button @click="submitQuestion" class="btn-main bold font-18">التالي</button>
        </div>
    </div>
</template>

<script>
    export default {
        emits: ['submitQuestion','wrongAnswerDialog'],
        props: ['question'],
        data(){
            return {
                answer: null
            }
        },
        methods: {
            submitQuestion() {
                if (!!this.answer && this.answer != this.question.correctAnswer) {
                    this.$emit('wrongAnswerDialog')
                    return
                }

                if (this.answer) {
                    this.$emit('submitQuestion',this.answer)
                    this.answer = null
                } else {
                    this.$store.commit('alertDialogMsg','يجب عليك إختيار إجابة')
                }
            }
        }
    }
</script>

<style scoped>
.checkbox {
    display: flex;
    cursor: pointer;
}
input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    margin: 0;
    min-width: 34px;
    min-height: 34px;
    width: 34px;
    height: 34px;
    border: 1px solid #707070;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
    margin-left: 14px;
    border-radius: 50%;
    cursor: pointer;
    align-self: baseline;
}

input[type="radio"]::before {
    content: "";
    width: 15px;
    height: 15px;
    transform: scale(0);
    transform-origin: center;
    transition: 120ms transform ease-in-out;
    background: url(/images/right-icon-checkbox.png) no-repeat;
}

input[type="radio"]:checked::before {
    transform: scale(1);
    width: 43px;
    height: 43px;
    background-size: 100% 100%;
}
.quiz-box .form-group:not(:last-of-type) {
    margin-bottom: 30px;
}
.submit-box {
    margin-top: 190px;
}
@media (max-width: 767px) {
    input[type="radio"] {
        min-width: 25px;
        min-height: 25px;
        width: 25px;
        height: 25px;
        margin-left: 10px;
        transform: translateY(0px);
    }
    input[type="radio"]:checked::before {
        width: 32px;
        height: 32px;
    }
    .quiz-box .form-group:not(:last-of-type) {
        margin-bottom: 20px;
    }
    .submit-box {
        margin-top: 30px;
    }
}
</style>
