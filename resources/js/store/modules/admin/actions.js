import {
    callApi
} from "../../common";
export default {
    // get-user-data-admin
    async getParentProfileDataAdmin(context, id) {
        // console.log(id);
        const resp = await callApi("GET", "/api/admin/parent/" + id);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        context.commit('userId', id)
        return resp.data
    },
    async editParentData(context, payload) {
        const resp = await callApi('POST', '/api/admin/parent/update/' + context.getters.userID, payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp.data

    },
    async createParent(context, payload) {
        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/parent/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data
    },
    async createSpecialist(context, payload) {
        const resp = await callApi('POST', '/api/admin/specialist/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data
    },
    async createOther(context, payload) {
        const resp = await callApi('POST', '/api/admin/other/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async deleteUser(context, payload) {
        const resp = await callApi('POST', '/api/admin/delete-user/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async changeStatus(context, payload) {
        const resp = await callApi('POST', '/api/admin/user-status/' + payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async previewCourse(context, payload) {
        const resp = await callApi('POST', '/api/admin/course-preview/' + payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async CourseCertificate(context, payload) {
        const resp = await callApi('GET', '/api/admin/course-certificate/' + payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data
    },
    async getCourseQuiz(context, payload) {
        const resp = await callApi('GET', '/api/admin/get-quiz/' + payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        // console.log('resp.data: ',resp.data);
        context.commit('setQuiz', {
            courseTitle: resp.data.course_title,
            quiz: resp.data.quiz,
            quizTitle: resp.data.quiz_title

        })
        return resp.data

    },
    async EditQuestion(context, payload) {
        console.log(payload);

        // console.log(id);
        const resp = await callApi("POST", "/api/admin/edit-answer/" + payload.question_id, payload);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    async editTestimonials(context, payload) {

        const resp = await callApi("POST", "/api/admin/edit-testimonials", payload);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp
    },

    // edit testamoial
    async changeQuestionStatus(context, payload) {
        console.log(payload);

        // console.log(id);
        const resp = await callApi("POST", "/api/admin/question-status/" + payload);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    async deleteQuestion(context, payload) {
        console.log(payload);

        // console.log(id);
        const resp = await callApi("POST", "/api/admin/question-delete/" + payload);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    async getSpecialisDataAdmin(context, id) {
        // console.log(id);
        const resp = await callApi("GET", "/api/admin/specialist/" + id);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        context.commit('userId', id)
        return resp.data
    },
    async editSpecialistData(context, payload) {
        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/specialist/update/' + context.getters.userID, payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp.data

    },
    async getotherDataAdmin(context, id) {
        // console.log(id);
        const resp = await callApi("GET", "/api/admin/other/" + id);

        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        context.commit('userId', id)
        return resp.data
    },
    async editOtherData(context, payload) {
        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/other/update/' + context.getters.userID, payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp.data

    },
    async storeCourseInfo(context, payload) {

        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/storeCourseInfo', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp

    },
    async createMedia(context, payload) {
        const resp = await callApi('POST', '/api/admin/create-media', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp

    },
    async updateMediaCover(context, payload) {
        const resp = await callApi('POST', '/api/admin/edit-media', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update cover data");
            throw error;
        }
        return resp

    },
    async editContent(context, payload) {
        console.log('in');
        const resp = await callApi('POST', '/api/admin/content/edit', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp

    },
    // create new article
    async createNewArticle(context, payload) {
        const resp = await callApi('POST', '/api/admin/content/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create new content");
            throw error;
        }
        return resp

    },

    // create new testimonials
    async createNewtestimonials(context, payload) {
        console.log('in');
        const resp = await callApi('POST', '/api/admin/testimonials/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create new content");
            throw error;
        }
        return resp

    },

    // create update certificate
    async createUpdateCertificate(context, payload) {
        console.log('in');
        const resp = await callApi('POST', '/api/admin/certificate', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create new content");
            throw error;
        }
        return resp

    },
    ////
    async deleteCourse(context, payload) {
        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/delete-course', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp

    },
    async uploadVideo(context, payload) {
        console.log('context', context);
        const resp = await callApi('POST', '/api/admin/course/upload-video', payload)
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
        return resp.data

    },
    // coupons
    async createCoupon(context, payload) {
        const resp = await callApi('POST', '/api/admin/coupon/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async assignCouponToUsers(context, payload) {
        const resp = await callApi('POST', '/api/admin/coupon/assign-to-users', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async editCoupon(context, payload) {
        const resp = await callApi('POST', '/api/admin/coupon/edit/' + payload.coupon_id, payload, )
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async deleteCoupon(context, payload) {
        const resp = await callApi('POST', '/api/admin/delete-coupon/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async CouponChangeStatus(context, payload) {
        const resp = await callApi('POST', '/api/admin/change-coupon-status/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    // call packages
    async createCallPackage(context, payload) {
        const resp = await callApi('POST', '/api/admin/calls/create', payload)
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async callPackageChangeStatus(context, payload) {
        const resp = await callApi('POST', '/api/admin/change-call-package-status/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async deleteCallPackge(context, payload) {
        const resp = await callApi('POST', '/api/admin/delete-call-package/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async deleteMediaCover(context, payload) {
        const resp = await callApi('POST', '/api/admin/media-delete/' + payload)

        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },
    async updateCallPackage(context, payload) {
        const resp = await callApi('POST', '/api/admin/calls/package/' + payload.id, payload, )
        if (resp.status != 200) {
            const error = new Error("fail to create profile data");
            throw error;
        }
        return resp.data

    },

    // get all users
    async getAllUsers() {
        const resp = await callApi('GET', '/api/admin/get-all-users');
        if (resp.status != 200) {
            const error = new Error('fail to load all users')
            throw error;
        }
        return resp;
    }
};
