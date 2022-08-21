import { callApi } from "../../common";
export default {
    // ******** get Specialists Page (can make calls) ::: get
    async getSpecialistsList(context, payload) {
        let filters = `?page=${payload.page}`
        if (payload.filters && payload.filters.length > 0) {
            filters += `&filters=${payload.filters}`
        }
        const resp = await callApi("GET", `/api/get-calls-providers${filters}`);
        if (resp.status != 200) {
            const error = new Error("fail getSpecialistsList ::");
            throw error;
        }

        return resp.data;
    },
    // ******** get Specialist Data ::: get
    async getSpecialistDetails(context, id) {
        const resp = await callApi("GET", `/api/get-specialist-data/${id}`);
        if (resp.status != 200) {
            const error = new Error("fail getSpecialistDetails ::");
            throw error;
        }

        return resp.data;
    },
    // ******** add appointments ::: POST
    async setAppointments(context,payload) {
        const resp = await callApi("POST", `/api/set-calls-providers-appointments`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to setAppointments");
            throw error;
        }
    },

    // ******** get appointments for specialist ::: GET
    async getAppointments(context,payload) {
        const resp = await callApi("GET", `/api/get-specialist-appintments/${payload}`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to getAppointments");
            throw error;
        }
        return resp.data
    },
    // ******** remove appointments ::: POST
    async removeAppointment(context,payload) {
        const resp = await callApi("POST", `/api/remove-appointment`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to removeAppointment");
            throw error;
        }
    },
    // ******** book appointments ::: POST
    async bookAppointment(context,payload) {
        const resp = await callApi("POST", `/api/call-payment`,payload);
        if (!resp) {
            const error = new Error("something went wrong, please try again");
            throw error;
        }
        return resp.data[0]
    },
    // ******** Child info for call ::: POST
    async childInfoForAppointment(context,payload) {
        const resp = await callApi("POST", `/api/set-appointment-child-info`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail childInfoForAppointment");
            throw error;
        }
    },

    // ******** get specialist calls log ::: POST
    async getSpecialistCallsLog(context,payload) {

        let queryFilters = `?page=${payload.page}`
        if (payload.filters && payload.filters.length > 0 && payload.filters != 'all') {
            // scheduled ==> 0
            // succeeded ==> 1
            // missed ==> 2
            const statuses = {
                "scheduled": '0',
                "succeeded": '1',
                "missed": '2',
            }

            queryFilters += `&filters=${statuses[payload.filters]}`
        }

        const resp = await callApi("GET", `/api/get-specialist-call-log${queryFilters}`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to getSpecialistCallsLog");
            throw error;
        }
        return resp.data
    },

    // ******** add Recommendation ::: POST
    async addRecommendation(context,payload) {
        const resp = await callApi("POST", `/api/set-call-recommendation`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to addRecommendation");
            throw error;
        }
    },

};
