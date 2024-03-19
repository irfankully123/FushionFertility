<script setup>
import { reactive} from 'vue';


const props = defineProps({
    error: {
        type: String,
        default:'',
        required: true
    },
    image: {
        type: String,
        default: null
    }
})


const emit = defineEmits(['image'])

const imageState = reactive({image: null})

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageState.image = e.target.result;
        };
        reader.readAsDataURL(file);
        emit('image', event.target.files[0]);
    }
};

</script>

<template>
    <img v-if="imageState.image" :src="imageState.image" class="w-px-100 h-auto rounded-circle" alt="Profile">
    <img v-else-if="props.image!==null" :src="`/storage/users/${props.image}`" class="w-px-100 h-auto rounded-circle " alt="Profile">
    <img v-else src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" class="w-px-100 h-auto rounded-circle " alt="Placeholder">
    <input type="file" class="form-control mt-3" @change="(event)=> handleFileSelect(event)">
    <span class="text-danger" v-if="props.error">{{ props.error }}</span>
</template>
