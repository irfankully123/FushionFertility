<script setup>
import Layout from '@/Layouts/Layout.vue'
import UploadPicture from '@/Components/UploadPicture.vue';
import DoctorSpecialityTags from '@/Partials/DoctorSpecialityTags.vue';
import DoctorSchedule from '@/Partials/DoctorSchedule.vue';
import DoctorAttachZoom from '@/Partials/DoctorAttachZoom.vue'
import DoctorInformation from '@/Partials/DoctorInformation.vue'
import DoctorExperience from '@/Partials/DoctorExperience.vue'
import DoctorCard from '@/Partials/DoctorCard.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import {Head, useForm} from '@inertiajs/vue3';
import {reactive, watch} from 'vue';

const form = useForm({
    profile: '',
    userData: {
        name: '',
        contact: '',
        gender: '0',
        address: '',
        dob: '',
        email: '',
        consultant_meeting_time: '0',
        password: '',
        confirm: '',
        fee: 0,
    },
    userExperience: {
        description: '',
        experience: '',
        qualification: '',
    },
    tags: [],
    schedule: [
        {day: 'Monday', time_from: '', time_to: '', isChecked: false},
        {day: 'Tuesday', time_from: '', time_to: '', isChecked: false},
        {day: 'Wednesday', time_from: '', time_to: '', isChecked: false},
        {day: 'Thursday', time_from: '', time_to: '', isChecked: false},
        {day: 'Friday', time_from: '', time_to: '', isChecked: false},
        {day: 'Saturday', time_from: '', time_to: '', isChecked: false},
        {day: 'Sunday', time_from: '', time_to: '', isChecked: false},
    ],
    zoom: {
        account_id: '',
        client_id: '',
        client_secret: ''
    }
});

const tagsErrors = reactive({tagError: ''});
const switchTabs = reactive({currentStep: 1});

watch(form.schedule, (newArray) => {
    newArray.forEach((item) => {
        if (!item.isChecked) {
            item.time_from = '';
            item.time_to = '';
        }
    });
}, {deep: true});

const handleSubmit = () => {
    form.clearErrors();
    form.post(route('dashboard.doctor.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const nextStep = () => {
    if (switchTabs.currentStep < 5) {
        switchTabs.currentStep++;
    }
};

const prevStep = () => {
    if (switchTabs.currentStep !== 1) {
        switchTabs.currentStep--;
    }
};
</script>


<template>
    <Head><title>Doctor Create</title></Head>
    <Layout>
        <DoctorCard>
            <template v-slot:body>
                <UploadPicture
                    @image="(file)=>form.profile=file"
                    :error="form.errors.profile">
                </UploadPicture>
                <div v-if="switchTabs.currentStep===1">
                    <DoctorInformation
                        :error="form.errors"
                        :userData="form.userData">
                    </DoctorInformation>
                </div>
                <div v-if="switchTabs.currentStep===2">
                    <DoctorExperience
                        :error="form.errors"
                        :userExperience="form.userExperience">
                    </DoctorExperience>
                </div>
                <div v-if="switchTabs.currentStep===3">
                    <h3 class="card-title text-primary mt-4">Doctor Schedule</h3>
                    <div class="row">
                        <div v-for="(object,index) in form.schedule" class="col-2">
                            <DoctorSchedule
                                :errorTimeFrom="form.errors?.[`schedule.${index}.time_from`]"
                                :errorTimeTo="form.errors?.[`schedule.${index}.time_to`]"
                                :weekly="object">
                            </DoctorSchedule>
                        </div>
                        <span v-if="form.errors.schedule" class="text-danger">{{ form.errors.schedule }}</span>
                    </div>
                </div>
                <div v-if="switchTabs.currentStep===4">
                    <h3 class="card-title text-primary mt-4">Doctor Specialities</h3>
                    <DoctorSpecialityTags
                        :error="form.errors.tags"
                        :tags="form.tags"
                        @message="(error)=>tagsErrors.tagError=error"
                        @tags="(tags)=>form.tags = tags">
                    </DoctorSpecialityTags>
                    <span v-if="tagsErrors.tagError" class="text-danger">{{ tagsErrors.tagError }}</span>
                </div>
                <div v-if="switchTabs.currentStep===5">
                    <DoctorAttachZoom :error="form.errors" :zoom="form.zoom"></DoctorAttachZoom>
                </div>
            </template>
            <template v-slot:footer>
                <button type="button" v-if="switchTabs.currentStep > 1" @click="prevStep" class="btn btn-dark me-3">
                    Back
                </button>
                <button type="button" v-if="switchTabs.currentStep < 5" @click="nextStep" class="btn btn-primary me-3">
                    Next
                </button>
                <SpinnerButton v-else @click="handleSubmit" type="submit" class="btn btn-primary"
                              :processing="form.processing">
                    Submit
                </SpinnerButton>
            </template>
        </DoctorCard>
    </Layout>
</template>
