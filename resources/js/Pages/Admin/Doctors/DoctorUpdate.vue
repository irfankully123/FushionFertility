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

import {reactive, watch, onMounted} from 'vue';

const props = defineProps({
    doctor: {
        type: Object,
        default: () => ({}),
    },
    user: {
        type: Object,
        default: () => ({}),
    },
    schedules: {
        type: Array,
        default: () => ([]),
    },
    tags: {
        type: Array,
        default: () => ([]),
    },
    zoom: {
        type: Object,
        default: () => ({}),
    },
    image: {
        type: String,
        default: '',
    },
});

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

watch(form.schedule, (newArray) => {
    newArray.forEach((item) => {
        if (!item.isChecked) {
            item.time_from = '';
            item.time_to = '';
        }
    });
}, {deep: true});

const tagsErrors = reactive({tagError: ''});
const switchTabs = reactive({currentStep: 1});

const handleUpdate = () => {
    form.post(route('dashboard.doctor.update', props.doctor.id), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('form submitted');
        },
        onError: () => {
            console.log(form.errors.tags);
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

const findScheduleObject = (schedules, value) => {
    return schedules.find((schedule) => schedule.day === value);
};

const forceFillArray = () => {
    return form.schedule.map((item) => {
        const propObject = findScheduleObject(props.schedules, item.day);
        if (propObject) {
            return {...item, time_from: propObject.time_from, time_to: propObject.time_to, isChecked: true};
        } else {
            return item;
        }
    });
};

onMounted(() => {
    const {
        contact,
        address,
        dob,
        description,
        fee,
        gender,
        experience,
        qualification,
        consultant_meeting_time
    } = props.doctor;
    const {name, email} = props.user;
    form.userData = {...form.userData, name, email, contact, address, dob, fee, gender, consultant_meeting_time};
    form.userExperience = {...form.userExperience, description, experience, qualification};
    form.schedule = forceFillArray();
    props.tags.forEach((tag) => form.tags.push(tag.name));
    form.zoom.account_id = props.zoom.account_id;
    form.zoom.client_id = props.zoom.client_id;
    form.zoom.client_secret = props.zoom.client_secret;
});

</script>

<template>
    <Head><title>Doctor Edit</title></Head>
    <Layout>
        <DoctorCard>
            <template v-slot:body>
                <UploadPicture
                    :image="props.image"
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
                <button v-if="switchTabs.currentStep > 1" @click="prevStep" class="btn btn-dark me-3">Back</button>
                <button v-if="switchTabs.currentStep < 5" @click="nextStep" class="btn btn-primary me-3">Next</button>
                <SpinnerButton v-else @click="handleUpdate" class="btn btn-primary" :processing="form.processing">
                    Update
                </SpinnerButton>
            </template>
        </DoctorCard>
    </Layout>
</template>
