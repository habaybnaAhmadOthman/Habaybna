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
};
