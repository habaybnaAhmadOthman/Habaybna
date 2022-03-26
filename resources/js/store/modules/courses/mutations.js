export default {
    setAllCourses(state,courses) {
        state.courses = courses;
    },
    setMyCourses(state,courses) {
        state.myCourses = courses;
    },
    lectureComplete(state,payload) {
        state.myCourses.filter(course=> {
            course.course_progress
        })
    },
    // setCourseID(state,courseID) {
    //     state.courseID = courseID
    // },
    setCourse(state,courseData) {
        state.course = courseData
    },
    infoModal(state,isShow) {
        state.infoModal.show = isShow;
    },
    courseLectures(state,videos) {
        state.courseLectures = videos;
    },
    currentLecture(state,data) {
        state.currentLecture = data;
    },
    
};
