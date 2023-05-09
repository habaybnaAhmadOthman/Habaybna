import {
    callApi
} from "../../common";
export default {
    async setPosts(context) {
        await callApi("GET", "/api/posts").then(res => {
            if (res.status != 200) {
                const error = new Error("fail to get profile data ");
                throw error;
            }
            context.commit('setPosts', {

                posts: res.data
            })

            return res.data
        })


    }
}
