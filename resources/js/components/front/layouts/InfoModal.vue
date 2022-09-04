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
                        <img class="mb-40 mb-20-p d-block m-side-auto-p status-img" :class="`status-${success}`" :src="`/images/${statusIcon}`" width="100" height="100" />
                        <p class="title-line font-27 mb-20">{{title}}</p>
                        <p class="black-2 font-20-p font-27 mb-40">{{description}}</p>
                        <div class="d-flex modal-options flex-end" :class="optionsClass">
                            <slot></slot>
                        </div>
                    </div>
                </dialog>
            </transition>
        </aside>
    </portal>
    </template>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        title: {
            type: String,
            required: false
        },
        description: {
            type: String,
            required: false
        },
        success: {
            type: Boolean,
            required: false
        },
        modalClass: {
            type: String,
            required: false
        },
        fixed: {
            type: Boolean,
            required: false,
            default: false
        },
        optionsClass: {
            type: String,
            required: false,
            default: ''
        },
        portal: {
            type: String,
            required: false,
            default: 'info-modal'
        }
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
    },
    computed: {
        statusIcon() {
            if (!this.success) {
                return 'error-icon.svg'
            }
            return 'success-icon.png'
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
    width:800px;
    box-shadow: 0px 0px 10px #0000001A;
    border-radius: 20px;
    padding: 60px 80px;
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
    left: 50px;
    top: 50px;
}
.btn {
    width: 340px;
    font-size: 18px;
    font-weight: bold;
    height: 60px;
    border-radius: 25px;
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
