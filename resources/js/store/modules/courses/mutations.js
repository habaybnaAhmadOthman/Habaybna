export default {
    setAllCourses(state,courses) {
        state.courses = courses;
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
