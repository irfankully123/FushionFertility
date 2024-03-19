<script setup>
import Layout from '@/Layouts/Layout.vue'
import {Head, Link} from "@inertiajs/vue3"

const props = defineProps({
    detail: {
        type: Object,
        default: () => ({}),
    }
});

const checkGender = (gender) => gender === 'M' ? 'Male' : 'Female';


</script>


<template>
    <Head>
        <title>
            Patient Detail
        </title>
    </Head>
    <Layout>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Patient Detail</h5>
                <h5 class="float-end">
                    <Link :href="route('doctor_dashboard.patients')">Back</Link>
                </h5>
            </div>
            <div class="card-body">
                <img v-if="props.detail.user.profile!==null" :src="`/storage/users/${props.detail.user.profile}`"
                     class="w-px-100 h-auto rounded-circle " alt="Profile">
                <img v-else
                     src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541"
                     class="w-px-100 h-auto rounded-circle " alt="Placeholder">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-user'></i></span>
                                <input :value="props.detail.user.name" type="text" class="form-control border-primary"
                                       id="name" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-envelope'></i></span>
                                <input :value="props.detail.user.email" type="email" class="form-control border-primary"
                                       id="email" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="contact">Contact <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-contact'></i></span>
                                <input :value="props.detail.patient.contact" type="number"
                                       class="form-control border-primary"
                                       id="contact" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="blood-group">Blood Group <span
                                class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-donate-blood'></i></span>
                                <input :value="props.detail.patient.blood_group" type="text"
                                       class="form-control border-primary" name="blood-group" id="blood-group"
                                       disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i
                                    class='bx bx-male-sign fw-bold'></i></span>
                                <input
                                    :value="checkGender(props.detail.patient.gender)"
                                    type="text"
                                    class="form-control border-primary" name="gender" id="gender" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i
                                    class='bx bxs-location-plus'></i></span>
                                <input :value="props.detail.patient.address" type="text"
                                       class="form-control border-primary"
                                       id="address" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="zip-code">Zip Code <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxl-discourse'></i></span>
                                <input :value="props.detail.patient.zip_code" type="number"
                                       class="form-control border-primary"
                                       id="zip-code" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bx-calendar'></i></span>
                                <input :value="props.detail.patient.dob" type="text" class="form-control border-primary"
                                       id="dob" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="age">Age <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bx-male'></i></span>
                                <input :value="props.detail.patient.age" type="text" class="form-control border-primary"
                                       id="age" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">City <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-city'></i></span>
                                <input :value="props.detail.patient.city" type="text"
                                       class="form-control border-primary"
                                       id="city" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="state">State <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bx-buildings'></i></span>
                                <input :value="props.detail.patient.state" type="text"
                                       class="form-control border-primary"
                                       id="state" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="primary-care-physician">Primary Care Physician</label>
                            <div class="input-group input-group-merge">
                                <textarea name="physician"
                                          class="form-control border-primary" cols="30" rows="4"
                                          id="primary-care-physician" disabled>{{props.detail.patient.primary_care_physician}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="medical-history">Medical History</label>
                            <div class="input-group input-group-merge">
                                <textarea name="medical" class="form-control border-primary"
                                          cols="30" rows="4" id="medical-history" disabled>{{props.detail.patient.medical_history}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="current-medications">Current Medications</label>
                            <div class="input-group input-group-merge">
                                <textarea name="medications"
                                          class="form-control border-primary" cols="30" rows="4"
                                          id="current-medications"
                                          disabled>{{props.detail.patient.current_medications}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>




