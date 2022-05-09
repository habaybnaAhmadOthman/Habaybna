export default {
    setAllCourses(state,courses) {
        state.courses = courses;
    },
    setMyCourses(state,courses) {
        state.myCourses = courses;
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
    completeLecture(state, payload) {
        var isLectureHasProgress = state.course.course_progress.findIndex(lesson=> lesson.video_id == +payload.videoID)
        if (isLectureHasProgress > -1){
            state.course.course_progress[isLectureHasProgress].is_complete = 1
        } else {
            state.course.course_progress.push({
                ...state.course.course_progress[0],
                is_complete:1,
                video_id:payload.videoID
            })
        }
    }
};
