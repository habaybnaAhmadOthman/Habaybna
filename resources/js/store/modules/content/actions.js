import { callApi } from "../../common";
export default {
    // ******** get Contents ::: get
    async getContent(context,payload) {
        const resp = await callApi("GET", `/api/contents?page=${payload.page}`);
        if (resp.status != 200) {
            const error = new Error("fail to get contents");
            throw error;
        }
        return resp.data;
    },
    // ******** get Article By Name ::: get
    async getArticle(context,payload) {
        const resp = await callApi("POST", `/api/show-article`,payload);
        if (resp.status != 200) {
            const error = new Error("fail to get article");
            throw error;
        }
        return resp.data;
    },
};
