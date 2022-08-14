<template>
    <portal :to="portal">
        <aside :class="modalClass">
            <div v-if="show" class="w-100 h-100 backdrop" @click="tryClose"></div>
            <transition name="modal">
                <dialog
                    class="overflow-hidden bg-white w-50 w-90-p info-modal"
                    v-if="show"
                    open
                >
                    <div class="modal-body">
                        <img v-if="!fixed" @click="tryClose" class="close-icon-modal pointer" src="/images/close-icon-color.png" width="34" height="34" />
                        <slot></slot>
                    </div>
                </dialog>
            </transition>
        </aside>
    </portal>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        fixed: {
            type: Boolean,
            required: false,
            default: false
        },
        portal: {
            type: String,
            required: true
        },
        modalClass: {
            type: String,
            required: false
        },
    },
    emits: ["close","afterClose"],
    methods: {
        tryClose() {
            if (!this.fixed)
                this.forceClose()
        },
        forceClose() {
            this.$emit("close");
            this.$emit("afterClose");
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10000;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 10vh;
    left: 10%;
    z-index: 100000;
    right: 0;
    left: 0;
    margin: auto;
    width: 650px;
    box-shadow: 0px 0px 10px #0000001a;
    border-radius: 20px;
    padding: 30px;
}

.modal-enter-active {
    animation: modal 0.3s ease-out;
}

.modal-leave-active {
    animation: modal 0.3s ease-in reverse;
}
.body {
    max-height: 450px;
    overflow-y: auto;
}
.close-icon-modal {
    position: absolute;
    left: 20px;
    top: 20px;
}
.btn {
    width: 340px;
    font-size: 18px;
    font-weight: bold;
    height: 60px;
    border-radius: 25px;
}
.sticky-header .close-icon-modal{
    position: sticky;
    top: 0;
}
@keyframes modal {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
.space-between-i {
    justify-content: space-between!important;
}
@media (max-width: 767px) {
    .close-icon-modal {
        left: 18px;
        top: 18px;
    }
    dialog {
        padding: 20px 12px;
    }
    .status-img {
        width: 58px;
        height: 58px;
    }
    .modal-options {
        flex-direction: column;
    }
    .exam-page .status-img.status-false{
        display: none;
    }
}
</style>
