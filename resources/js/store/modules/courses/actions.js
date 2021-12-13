import {callApi} from "../../common";
export default {
    // ******** get all courses ::: get
    async getAllCourses() {
        const resp = await callApi("GET", "/api/all-courses");
        if (resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        return resp.data.courses;
    },
    // ******** get all categories ::: get
    async getCategories() {
        const resp = await callApi("GET", "/api/get-categories");
        if (resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        return resp.data;
    },
    async getCourseDetails(context,payload) {
        // const resp = await callApi("GET", "/api/get-course-details",courseID);
        const resp = await {
            "courseName": "Bessie Hamill",
            "trailerSrc": "trailerSrc 1",
            "specialistName": "coachName 1",
            "courseDescription": "courseDescription 1",
            "lectureInfo": "أولاً : التعرف على السلوك المدخلي : يعتمد بناء مناهج الأطفال ذوي الاحتياجات الخاصة على معرفتنا بخصائص هؤلاء الأطفال فالأطفال ذوي الإعاقة الذهنية الشديدة يختلفون في احتياجاتهم عن الأطفال ذوي الإعاقة الذهنية المتوسطة أو البسيطة ، وكذلك الأطفال ذوي بطء التعلم يختلفون في احتياجاتهم عن الأطفال ذوي صعوبات التعلم وهكذا ، وبالتالي فنحن بحاجة منذ البداية إلى معلومات أولية سريعة عن الفئة التي نتعامل معها بشكل عام ، حتى نتمكن من السير قدما في بناء المنهاج . ثانياً : قياس مستوى الأداء الحالي : أن منهاج الطالب ذوي الاحتياجات التربوية الخاصة يوضع بعد مرحلة التعرف على الأداء الحالي للطالب .",
            "documents": [
                {
                    "title": "الملف الاول",
                    "link": "http://localhost:8000/courses/1/1"
                },
                {
                    "title": "الملف الثاني",
                    "link": "http://localhost:8000/courses/1/1"
                }
            ],
            "lectures": [
             {
              "title": "الخطة التربوية",
              "time": "12"
             },
             {
              "title": "العمل التطوعي",
              "time": "2"
             },
             {
              "title": "العمل",
              "time": "22"
             },
             {
              "title": "التطوعي",
              "time": "12"
             },
             {
              "title": "السباحة المنيحة",
              "time": "23"
             },
             {
              "title": "السباحة",
              "time": "43"
             },
             {
              "title": "المنيحة",
              "time": "25"
             }
            ],
            "id": "1"
           }
        // if (resp.status != 200) {
        //     const error = new Error("fail to get course details")
        //     throw error;
        // }
        return resp;
    }
};
