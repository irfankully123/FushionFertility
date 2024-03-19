<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import {Head, router, usePage, Link} from "@inertiajs/vue3";
import Swal from '@/Alerts/SweetAlerts.js'
import moment from 'moment';
import {ref, watch} from "vue";
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

const {id} = usePage().props.auth;

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('doctor_dashboard.appointmentsSchedule', id), {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));

const showAttachedImage = (url) => {
    if (url != null) {
        const fullUrl = `/storage/prescription/${url}`
        Swal.fire({
            imageUrl: fullUrl,
            imageHeight: 500,
            width: 800,
            imageAlt: 'prescription_image',
            text: 'Patients Provided Prescription',
        })
    }
}

const downloadPDF = (url) => {
    if (url != null) {
        const fullUrl = `/storage/prescription/${url}`
        const link = document.createElement('a');
        link.href = fullUrl;
        link.target = '_blank';
        link.download = 'prescription.pdf';
        link.click();
        link.remove();
    }
}

const showAppointmentReason = (reason) => {
    Swal.fire({
        title: 'Patient Appointment Reason',
        text: reason,
        icon: 'info',
        confirmButtonText: 'OK'
    });
}
const showPrescriptionDescription = (description) => {
    Swal.fire({
        title: 'Patient Appointment Reason',
        text: description,
        icon: 'info',
        confirmButtonText: 'OK'
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
            Today's Appointments
        </title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                Today's Appointments
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
                        <th>Patient Details</th>
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
                            {{
                                convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).date
                            }}
                        </td>
                        <td>
                            {{ convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).time }}
                        </td>
                        <td>
                            {{
                                convertDateTimeZone(appointment.appointment_date, appointment.appointment_time, appointment.day).day
                            }}
                        </td>
                        <td>
                            <span v-if="appointment.status==='Paid'" class="badge bg-label-info">
                                {{ appointment.status }}
                            </span>
                            <span v-if="appointment.status==='Meeting'" class="badge bg-label-primary">
                                {{ appointment.status }}
                            </span>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6">
                                    <button
                                        type="button"
                                        @click="showAttachedImage(appointment.prescription_image_url)"
                                        class="btn rounded-pill btn-icon btn-outline-primary mx-1 lighten-button"
                                        :disabled="!appointment.prescription_image_url">
                                        <span class="tf-icons bx bx-image"></span>
                                    </button>
                                    <button
                                        type="button"
                                        @click="downloadPDF(appointment.prescription_pdf_url)"
                                        class="btn rounded-pill btn-icon btn-outline-primary mx-1 lighten-button"
                                        :disabled="!appointment.prescription_pdf_url">
                                        <span class="tf-icons bx bxs-file-pdf"></span>
                                    </button>
                                    <button type="button"
                                            @click="showAppointmentReason(appointment.appointment_reason)"
                                            class="btn rounded-pill btn-icon btn-outline-primary mx-1 lighten-button">
                                        <span class="tf-icons bx bx-comment-check"></span>
                                    </button>

                                    <button type="button"
                                            @click="showPrescriptionDescription(appointment.prescription_description)"
                                            :disabled="!appointment.prescription_description"
                                            class="btn rounded-pill btn-icon btn-outline-primary mx-1 lighten-button">
                                        <span class="tf-icons bx bx-comment-check"></span>
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


<style scoped>
.lighten-button:disabled {
    opacity: 0.5;
    background-color: #f2f2f2;
    border-color: #f2f2f2;
    color: #777777;
}

.lighten-button:disabled:hover {
    opacity: 0.7;
}

.lighten-button:disabled:focus {
    outline: none;
}
</style>

