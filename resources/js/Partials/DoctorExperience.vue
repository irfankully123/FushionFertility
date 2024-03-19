<script setup>

const props=defineProps({
    userExperience:{
        type:Object,
        required:true
    },
    error:{
        type:Object,
        required:true
    }
})

</script>

<template>
    <div class="row mt-4 gy-2">
        <h3 class="card-title text-primary">Qualifications & Experience</h3>
        <hr class="bg-secondary mt-5">
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="description">Description</label>
                <div class="input-group input-group-merge">
                <textarea v-model="props.userExperience.description" name="description" class="form-control border-primary" cols="30"
                          rows="4" id="description"></textarea>
                </div>
                <span class="text-danger" v-if="props.error['userExperience.description']">{{ props.error['userExperience.description'] }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="experience">Experience <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                <textarea v-model="props.userExperience.experience" required name="experience" class="form-control border-primary" cols="30"
                          rows="4" id="experience"></textarea>
                </div>
                <span class="text-danger" v-if="props.error['userExperience.experience']">{{ props.error['userExperience.experience'] }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="qualification">Qualifications <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                <textarea v-model="props.userExperience.qualification" required name="qualification" class="form-control border-primary" cols="30"
                          rows="2" id="qualification"></textarea>
                </div>
                <span class="text-danger" v-if="props.error['userExperience.qualification']">{{ props.error['userExperience.qualification'] }}</span>
            </div>
        </div>
    </div>
</template>
