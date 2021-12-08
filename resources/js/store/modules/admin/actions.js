import {callApi} from "../../common";
export default {
        // get-user-data-admin
        async getParentProfileDataAdmin(context,id) {
            // console.log(id);
            const resp = await callApi("GET", "/api/admin/parent/"+id);

            if (resp.status != 200) {
                const error = new Error("fail to get profile data");
                throw error;
            }
            context.commit('userId',id)
            return resp.data
        },

        async editParentData(context,payload){
            console.log('context',context);
            const resp = await callApi('POST','/api/admin/parent/update/'+context.getters.userID,payload)
            if(resp.status != 200){
                const error = new Error("fail to update profile data");
                throw error;
            }
            return resp.data

        }
};
