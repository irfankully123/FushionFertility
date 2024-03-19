<script setup>
import {ref, computed, watch} from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    id: {
        type: String,
        required: true,
    },
    border:{
        type:Boolean,
        default:false,
    }
});

const emit = defineEmits(['update:modelValue']);

const passwordValue = ref(props.modelValue);
const showPassword = ref(false);

const inputType = computed(() => showPassword.value ? 'text' : 'password');

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

// Watch for changes to the passwordValue and emit it to the parent component
watch(passwordValue, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>

<template>
    <input :id="props.id" v-model="passwordValue" :type="inputType"  :class="border ? 'form-control border-primary' : 'form-control'" name="password"
           placeholder="············" aria-describedby="password">
    <span  :class="border ? 'input-group-text border-primary' : 'input-group-text'" type="button" @click="togglePasswordVisibility">
          <i :class="{'bx bx-show': showPassword, 'bx bx-hide': !showPassword}"></i>
    </span>
</template>



