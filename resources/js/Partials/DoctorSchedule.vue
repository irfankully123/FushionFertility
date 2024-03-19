<script setup>
import {computed} from 'vue';

const props = defineProps({
    weekly: {
        type: Object,
        required: true
    },
    errorTimeFrom: {
        type: String,
        required: true
    },
    errorTimeTo: {
        type: String,
        required: true,
    }
});

const weekly = computed(() => props.weekly)

</script>

<template>
    <hr class="bg-secondary mt-5">
    <div class="form-check mt-3">
        <label class="form-check-label"> {{ weekly.day }}</label>
        <input v-model="weekly.isChecked" type="checkbox" class="form-check-input border-primary">
    </div>
    <div v-if="weekly.isChecked" class="mt-3">
        <label class="form-check-label me-1">Time From</label>
        <input v-model="weekly.time_from" type="time" class="form-control border-primary"/>
    </div>
    <span class="text-danger" v-if="props.errorTimeFrom && weekly.isChecked">{{ props.errorTimeFrom }}</span>
    <div v-if="weekly.isChecked" class="mt-3">
        <label class="form-check-label me-1">Time To</label>
        <input v-model="weekly.time_to" type="time" class="form-control border-primary"/>
    </div>
    <span class="text-danger" v-if="props.errorTimeTo && weekly.isChecked">{{ props.errorTimeTo }}</span>
</template>
