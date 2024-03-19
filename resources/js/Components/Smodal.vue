<script setup>
import {Teleport} from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Teleport to="body">
        <Transition name="fade">
            <div class="modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>{{ title }}</h3>
                        <slot name="header"></slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>


<style scoped>
.modal {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-overlay {
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    max-width: 500px;
    max-height: 300px;
    overflow: hidden;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.modal-header h3 {
    margin: 0;
}

.modal-close {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
}

.modal-body {
    margin-bottom: 10px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
