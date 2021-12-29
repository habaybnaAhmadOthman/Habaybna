export default {
    userId(state, payload){
        state.userID = payload
    },

    setQuiz(state, payload){
        console.log('payload',payload);
        state.courseQuiz = payload
    }
};
