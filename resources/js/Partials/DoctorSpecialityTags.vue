<script setup>
import { reactive,onMounted } from 'vue';

const props=defineProps({
    tags:{
        type:Array,
        required:true
    },
    error:{
        type:Object,
        required:true,
    }
});

const inputs=reactive({
    tags:[],
    newTag:''
});

const emit = defineEmits(['tags','message'])

const addTag=()=>{
    emit('message','');
    if (inputs.newTag && !inputs.tags.includes(inputs.newTag)) {
        inputs.tags.push(inputs.newTag);
        inputs.newTag='';
    }
    else{
        emit('message','Dont Repeat Same Value');
    }
    emit('tags',inputs.tags);
}

const removeTag=(index)=>{
    inputs.tags.splice(index, 1);
    emit('tags',inputs.tags);
}

onMounted(()=>{
    if(props.tags!=null){
        inputs.tags=props.tags;
    }
});



</script>

<template>
    <div class="tags-input mt-4">
        <div class="tags">
        <span  class="tag" v-for="(tag, index) in inputs.tags" :key="index" >
          {{ tag }}
          <button class="tag-remove" @click="removeTag(index)">
            &times;
          </button>
        </span>
        </div>
        <input  type="text" class="tag-input" v-model="inputs.newTag" @keydown.enter="addTag" placeholder="Add Speciality" name="tags"/>
    </div>
    <span v-if="props.error" class="text-danger">{{ props.error  }}</span>
</template>

<style scoped>
.tag-input{
    border: 1px solid #999;
    padding: 6px;
    border-radius: 4px;
}
.tag-input:focus{
    border: 1px solid #666;
}
.tags-input {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    padding: 7px;
    border: 1px solid #999;
    border-radius: 10px;
}

.tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}

.tag {
    display: inline-block;
    margin-right: 5px;
    padding: 3px 5px;
    background-color: #eee;
    border-radius: 4px;
}

.tag-remove {
    margin-left: 6px;
    color: #999;
    font-weight: 50;
    cursor: pointer;
    border: none;
}

.tag-remove:hover {
    color: #666;
}
</style>
