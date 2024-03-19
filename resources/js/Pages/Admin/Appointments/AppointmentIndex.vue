<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Bmodal.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import Swal from '@/Alerts/SweetAlerts.js'
import {Head, router, useForm, Link, usePage} from "@inertiajs/vue3";
import {ref, watch, reactive, computed} from "vue";
import {debounce} from 'lodash';


const props = defineProps({
    appointments: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({}),
    }
});


const state = reactive({createModal: false, editModal: false});

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('dashboard.appointments'), {search: value}, {preserveState: true, replace: true});
}, 500));

const form = useForm({
    doctor_id: null,
    patient_id: null,
    day: '0',
    time: '',
    date: '',
    status: '0',
    reason: '',
});

const successMessage = (message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
};

const handleSubmit = () => {
    form.post(route('dashboard.appointments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            state.createModal = !state.createModal;
            successMessage('Created');
        },
    });
};

let appointment_id = null;

const openEditModal = (index) => {
    const appointment = props.appointments.data[index];
    state.editModal = !state.editModal;
    form.day = appointment.day;
    form.time = appointment.appointment_time.substring(0, 5);
    form.date = appointment.appointment_date;
    form.status = appointment.status;
    form.reason = appointment.appointment_reason;
    appointment_id = appointment.id;
}

const handleUpdate = () => {
    form.post(route('dashboard.appointments.update', appointment_id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            state.editModal = !state.editModal;
            appointment_id = null;
            successMessage('Updated');
        },
    });
}

const destroy = (id) => router.delete(route('dashboard.appointments.destroy', id));

const showAlert = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: `You will not be able to recover this ${id}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.value) {
            destroy(id);
            successMessage('Deleted');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // User clicked cancel button
        }
    });
};

const authPermissions = usePage().props.authPermissions;

const hasPermission = (permission) => computed(() => authPermissions.includes(permission));

const createPermission = hasPermission('create');

const updatePermission = hasPermission('update');

const showPermission = hasPermission('show');

const deletePermission = hasPermission('delete');

</script>


<template>
    <Head>
        <title>
            Appointments
        </title>
    </Head>
    <Modal v-if="state.createModal" title="Create Appointment">
        <template #header>
            <button class="btn-close"
                    @click="()=>{state.createModal=!state.createModal;form.clearErrors();form.reset()}"></button>
        </template>
        <template #body>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="doctor_id">Doctor Id</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-plus-medical'></i></span>
                        <input v-model="form.doctor_id" type="number" class="form-control border-primary"
                               name="doctor_id" id="doctor_id"/>
                    </div>
                    <span v-if="form.errors.doctor_id" class="text-danger">{{ form.errors.doctor_id }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="patient_id">Patient Id</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-user-plus'></i></span>
                        <input v-model="form.patient_id" type="number" class="form-control border-primary"
                               name="patient_id" id="patient_id"/>
                    </div>
                    <span v-if="form.errors.patient_id" class="text-danger">{{ form.errors.patient_id }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="day">Day</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-calendar-event'></i></span>
                        <select v-model="form.day" class="form-select border-primary" name="day" id="day">
                            <option value="0">Appointment Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <span v-if="form.errors.day" class="text-danger">{{ form.errors.day }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="time">Time</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-time'></i></span>
                        <input v-model="form.time" type="time" class="form-control border-primary" name="time"
                               id="time"/>
                    </div>
                    <span v-if="form.errors.time" class="text-danger">{{ form.errors.time }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date">Date</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-user-plus'></i></span>
                        <input v-model="form.date" type="date" class="form-control border-primary" name="date"
                               id="date"/>
                    </div>
                    <span v-if="form.errors.date" class="text-danger">{{ form.errors.date }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="status">Day</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-menu-alt-right'></i></span>
                        <select v-model="form.status" class="form-select border-primary" name="status" id="status">
                            <option value="0">Appointment Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Paid">Paid</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <span v-if="form.errors.status" class="text-danger">{{ form.errors.status }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="reason">Reason</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <textarea v-model="form.reason" class="form-control border-primary" cols="30" rows="4"
                                  name="reason" id="reason"></textarea>
                    </div>
                    <span v-if="form.errors.reason" class="text-danger">{{ form.errors.reason }}</span>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button" @click="()=>{state.createModal=!state.createModal;form.clearErrors();form.reset()}"
                    class="btn btn-dark">Close
            </button>
            <SpinnerButton @click="handleSubmit" type="button" class="btn btn-primary" :processing="form.processing">
                Submit
            </SpinnerButton>
        </template>
    </Modal>
    <Modal v-if="state.editModal" title="Edit Appointment">
        <template #header>
            <button class="btn-close"
                    @click="()=>{state.editModal=!state.editModal;form.clearErrors();form.reset();appointment_id=null}"></button>
        </template>
        <template #body>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="edit_day">Day</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-calendar-event'></i></span>
                        <select v-model="form.day" class="form-select border-primary" name="edit_day" id="edit_day">
                            <option value="0">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <span v-if="form.errors.day" class="text-danger">{{ form.errors.day }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="edit_time">Time</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-time'></i></span>
                        <input v-model="form.time" type="time" class="form-control border-primary" name="edit_time"
                               id="edit_time"/>
                    </div>
                    <span v-if="form.errors.time" class="text-danger">{{ form.errors.time }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="edit_date">Date</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-user-plus'></i></span>
                        <input v-model="form.date" type="date" class="form-control border-primary" name="edit_date"
                               id="edit_date"/>
                    </div>
                    <span v-if="form.errors.date" class="text-danger">{{ form.errors.date }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="edit_status">Day</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <span class="input-group-text border-primary"><i class='bx bx-menu-alt-right'></i></span>
                        <select v-model="form.status" class="form-select border-primary" name="edit_status"
                                id="edit_status">
                            <option value="0">Appointment Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <span v-if="form.errors.status" class="text-danger">{{ form.errors.status }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="edit_reason">Reason</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge b">
                        <textarea v-model="form.reason" class="form-control border-primary" cols="30" rows="4"
                                  name="edit_reason" id="edit_reason"></textarea>
                    </div>
                    <span v-if="form.errors.reason" class="text-danger">{{ form.errors.reason }}</span>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button"
                    @click="()=>{state.editModal=!state.editModal;form.clearErrors();form.reset();appointment_id=null}"
                    class="btn btn-dark">Close
            </button>
            <SpinnerButton @click="handleUpdate" type="button" class="btn btn-primary" :processing="form.processing">
                Update
            </SpinnerButton>
        </template>
    </Modal>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <button v-if="createPermission" @click="()=>state.createModal=!state.createModal" type="button"
                        class="btn btn-success">Create
                </button>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" type="search" class="form-control" placeholder="Search"
                                       aria-label="Search" aria-describedby="search-addon" id="search" name="search"/>
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
                        <th>patient</th>
                        <th>doctor</th>
                        <th>amount</th>
                        <th>date</th>
                        <th>time</th>
                        <th>day</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(appointment,index) in props.appointments.data" :key="index">
                        <td> {{ index + 1 }}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ appointment.id }}</strong>
                        </td>
                        <td>
                            <Link :href="route('dashboard.patients',{'search':appointment.patient.user.name})">
                                {{ appointment.patient.user.name }}
                            </Link>
                        </td>
                        <td>
                            <img v-if="appointment.doctor.user.profile!=null"
                                 :src="`/storage/users/${appointment.doctor.user.profile}`"
                                 alt="doctor"
                                 class="w-px-40 h-auto rounded-circle"/>
                            <img v-else
                                 src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg"
                                 alt="placeholder" class="w-px-40 h-auto rounded-circle"/>
                            <Link :href="route('dashboard.doctor',{'search':appointment.doctor.user.name})">
                                <span class="ms-3">{{ appointment.doctor.user.name }}</span>
                            </Link>
                        </td>
                        <td>${{ appointment.amount }}</td>
                        <td>{{ appointment.appointment_date }}</td>
                        <td>{{ appointment.appointment_time }}</td>
                        <td>{{ appointment.day }}</td>
                        <td>
                            <span v-if="appointment.status==='Pending'" class="badge bg-label-warning">
                                {{ appointment.status }}
                            </span>
                            <span v-if="appointment.status==='Paid'" class="badge bg-label-info">
                                {{ appointment.status }}
                            </span>
                            <span v-if="appointment.status==='Meeting'" class="badge bg-label-primary">
                                {{ appointment.status }}
                            </span>
                            <span v-if="appointment.status==='Completed'" class="badge bg-label-success">
                                {{ appointment.status }}
                            </span>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <button v-if="updatePermission" @click="openEditModal(index)" type="button"
                                            class="btn btn-warning mx-1">
                                        Edit
                                    </button>
                                    <button v-if="deletePermission" @click="showAlert(appointment.id)" type="button"
                                            class="btn btn-danger mx-1">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="props.appointments.total > 8">
            <Pagination
                :links="props.appointments.links"
                :first-page-url="props.appointments.links.first_page_url"
                :last-page-url="props.appointments.links.last_page_url"
                :last-page-check="props.appointments.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>



