export default {
    bookInfo(state,bookAppointmentInfo) {
        state.bookAppintmentInfo = bookAppointmentInfo;
    },
    callPrice(state,newPrice) {
        state.callPrice = Math.round(newPrice);
    },
};
