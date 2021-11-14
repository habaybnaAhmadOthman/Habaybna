import {createStore} from 'vuex';

const store = createStore({
    modules: {

    },
    state(){
        return {
            test: 'hello world'
        }
    }
})

export default store