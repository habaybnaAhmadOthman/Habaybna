<template>
    <aside>
        <div v-if="show" class="w-100 h-100 backdrop" @click="tryClose"></div>
        <transition name="modal">
            <dialog
                class="overflow-hidden bg-white w-80 radius-12 border-0 m-0 p-0"
                v-if="show" open
            >
                <div class="header white w-100 p-side-15 pt-15 pb-15">
                    <slot name="header">
                        <p class="bold font-20">{{ title }}</p>
                    </slot>
                </div>
                <section class="p-side-15 pt-15 pb-15">
                    <slot></slot>
                </section>
                <menu  class="d-flex flex-end m-0">
                    <slot name="actions">
                        <button class="btn mb-10 ml-10" @click="tryClose">حسنا</button>
                    </slot>
                </menu>
            </dialog>
        </transition>
    </aside>
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
        }
    },
    emits: ["close"],
    methods: {
        tryClose() {
            this.$emit("close");
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 20vh;
    left: 10%;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
    right: 0;
    left: 0;
    margin: auto;
}
.header {
    background-color: #3a0061;
}
.modal-enter-active {
  animation: modal 0.3s ease-out;
}

.modal-leave-active {
  animation: modal 0.3s ease-in reverse;
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
</style>
