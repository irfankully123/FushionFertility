<script setup>
const props = defineProps({
    processing: {
        type: Boolean,
        default: false,
        required: true,
    },

});
</script>

<template>
    <button type="button" :class="{ 'text-white-50': props.processing }" :disabled="props.processing">
        <div v-show="props.processing" class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <slot></slot>
    </button>
</template>


