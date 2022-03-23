<template>
    <div class="status-bar p-side-20 d-flex align-center">
        <div class="status-prog relative overflow-hidden mb-5-p"><span class="progress" :style="calculateProgress"></span></div>
        <p class="main-color font-20 mr-20 top-2 font-14-p current-q"><span class="from">{{currentQuestion + 1}}</span>/<span class="to">{{questionsCount + 1}}</span></p>
    </div>
</template>

<script>
    export default {
        props: ['currentQuestion','questionsCount'],
        data(){
            return {
                
            }
        },
        computed: {
            calculateProgress(){
                return `width:${((this.currentQuestion + 1) / (this.questionsCount + 1)) * 100}%;`
            }
        }
    }
</script>

<style scoped>
.status-prog {
    width: 100%;
    height: 10px;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 4px;
}
.progress {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: #3FC4E0;
    border-radius: 4px;
    transition: .3s;
}
@media (max-width: 767px) {
    .status-bar {
        flex-direction: column;
    }
    .current-q {
        align-self: end;
    }
}
</style>