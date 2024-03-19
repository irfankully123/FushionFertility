<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Bmodal.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import {Head, router, usePage, Link, useForm} from "@inertiajs/vue3";
import moment from 'moment';
import {reactive, ref, watch} from "vue";
import {debounce} from 'lodash';
import 'moment-timezone';

const props = defineProps({
    appointments: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({})
    },
});

const state = reactive({showModal: false});

const form = useForm({
    'medication': '',
    'dosage': '',
    'frequency': '',
    'duration': '',
    'instructions': ''
});

const {id} = usePage().props.auth;

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('doctor_dashboard.appointmentsMeeting', id), {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));

const isDisabled = (appointment) => {
    const currentDateTime = new Date();
    const appointmentDateTime = new Date(`${appointment.appointment_date} ${appointment.appointment_time}`);
    return currentDateTime < appointmentDateTime;
};

const joinZoom = (appointment) => {
    if (!isDisabled(appointment)) {
        window.location.href = appointment.zoom_start_url;
    }
};

const appointment = {id: null};

const showPrescriptionModal = (id) => {
    appointment.id = id;
    state.showModal = !state.showModal;
}

const handleSubmit = () => {
    form.post(route('doctor_dashboard.appointmentsMeetingCompleted', appointment.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            state.showModal = !state.showModal;
            appointment.id = null;
        },
    });
}


const convertDateTimeZone = (date, time, day) => {
    const clientTimezone = usePage().props.clientTimeZone;
    const givenTimezone = usePage().props.timezone;

    const isSameTimezone = clientTimezone === givenTimezone;

    if (isSameTimezone) {
        return {date, time, day};
    }

    const datetime = moment.tz(`${date} ${time}`, 'YYYY-MM-DD HH:mm:ss', givenTimezone).clone().tz(clientTimezone);
    const convertedDate = datetime.format('YYYY-MM-DD');
    const convertedTime = datetime.format('HH:mm:ss');
    const convertedDay = datetime.format('dddd');

    return {date: convertedDate, time: convertedTime, day: convertedDay};
};

</script>

<template>
    <Head>
        <title>
            Zoom Meeting
        </title>
    </Head>
    <Modal v-if="state.showModal" title="Prescription">
        <template #header>
            <button class="btn-close"
                    @click="()=>{state.showModal=!state.showModal;form.clearErrors();form.reset();appointment.id=null}"></button>
        </template>
        <template #body>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="dosage">Dosage</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-data'></i></span>
                        <input v-model="form.dosage" type="text" placeholder="two table spoons"
                               class="form-control border-primary" name="dosage" id="dosage"/>
                    </div>
                    <span v-if="form.errors.dosage" class="text-danger">{{ form.errors.dosage }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="frequency">Frequency</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-sync'></i></span>
                        <input v-model="form.frequency" type="text" placeholder="twice in an hour"
                               class="form-control border-primary" name="frequency" id="frequency"/>
                    </div>
                    <span v-if="form.errors.frequency" class="text-danger">{{ form.errors.frequency }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="duration">Duration</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-adjust'></i></span>
                        <input v-model="form.duration" placeholder="24 hour" type="text"
                               class="form-control border-primary" name="duration" id="duration"/>
                    </div>
                    <span v-if="form.errors.duration" class="text-danger">{{ form.errors.duration }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="medication">Medication</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <textarea v-model="form.medication" rows="4" class="form-control border-primary"
                                  name="medication" id="medication"/>
                    </div>
                    <span v-if="form.errors.medication" class="text-danger">{{ form.errors.medication }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="instructions">Instructions</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <textarea v-model="form.instructions" rows="6" class="form-control border-primary"
                                  name="instructions" id="instructions"/>
                    </div>
                    <span v-if="form.errors.instructions" class="text-danger">{{ form.errors.instructions }}</span>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button"
                    @click="()=>{state.showModal=!state.showModal;form.clearErrors();form.reset();appointment.id=null}"
                    class="btn btn-dark">Close
            </button>
            <SpinnerButton @click="handleSubmit" type="button" class="btn btn-primary" :processing="form.processing">
                Submit
            </SpinnerButton>
        </template>
    </Modal>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                Zoom Meeting
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" type="search" class="form-control rounded" placeholder="Search"
                                       aria-label="Search" aria-describedby="search-addon"/>
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
            </table>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>patient_name</th>
                        <th>patient_email</th>
                        <th>date</th>
                        <th>time</th>
                        <th>day</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(appointment,index) in props.appointments.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ appointment.id }}</strong>
                        </td>
                        <td>{{ appointment.patient.user.name }}</td>
                        <td>
                            <Link :href="route('doctor_dashboard.patients',{'search':appointment.patient.user.email})">
                                {{ appointment.patient.user.email }}
                            </Link>
                        </td>
                        <td>
                            {{convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).date }}
                        </td>
                        <td>
                            {{convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).time}}
                        </td>
                        <td>
                            {{convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).day }}
                        </td>
                        <td><span class="badge bg-label-primary">Meeting</span></td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <button :disabled="isDisabled(appointment)" class="btn btn-primary mx-1"
                                            @click="joinZoom(appointment)">
                                        Join Zoom
                                    </button>
                                    <button @click="showPrescriptionModal(appointment.id)" type="button"
                                            class="btn btn-success mx-1">Mark As Completed
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <div v-if="props.appointments.total > 8">
                <Pagination
                    :links="props.appointments.links"
                    :first-page-url="props.appointments.links.first_page_url"
                    :last-page-url="props.appointments.links.last_page_url"
                    :last-page-check="props.appointments.links.last_page"
                ></Pagination>
            </div>
        </div>
    </Layout>
</template>



