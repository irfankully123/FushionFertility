<script setup>
import Layout from '@/Layouts/Layout.vue'
import {Head} from '@inertiajs/vue3';
import {computed} from 'vue';

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
        default: () => ([])
    },
    tags: {
        type: Array,
        default: () => ([])
    },
    image: {
        type: String,
        default: ""
    }
});


const schedules = computed(() => props.schedules);

const tags = computed(() => props.tags);


</script>

<template>
    <Head><title>Doctor Edit</title></Head>
    <Layout>
        <div class="card">
            <div class="card-body ">
                <div class="d-flex justify-content-center">
                    <div class="row w-100 shadow p-5 mx-5">
                        <div class="col-2">
                            <img :src="props.image" class="img-fluid rounded-3" width="180">
                        </div>
                        <div class="col-10">
                            <p class="h2 text-dark fw-bold m-0">{{ props.user.name }}</p>
                            <p class="mt-1 p-0 my-2">
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bx-star text-warning'></i>
                            </p>
                            <p class="text-primary font-monospace h6">{{ props.doctor.qualification }}</p>
                            <div class="row">
                                <div class="col-3"><i class='bx bxs-location-plus text-primary'></i><span
                                    class="fw-bold">{{ props.doctor.address }}</span></div>
                                <div class="col-3"><i class='bx bxs-phone text-primary'></i> <span
                                    class="fw-bold">{{ props.doctor.contact }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  mx-5 mt-2">
                    <div class="px-5">
                        <div class="demo-inline-spacing">
                            <div class="list-group list-group-horizontal-md text-md-center">
                                <a class="list-group-item list-group-item-action active fw-bold" id="home-list-item"
                                   data-bs-toggle="list" href="#overview">Overview</a>
                                <a class="list-group-item list-group-item-action fw-bold" id="profile-list-item"
                                   data-bs-toggle="list" href="#experience">Experience</a>
                                <a class="list-group-item list-group-item-action fw-bold" id="messages-list-item"
                                   data-bs-toggle="list" href="#personal">Personal</a>
                                <a class="list-group-item list-group-item-action fw-bold" id="settings-list-item"
                                   data-bs-toggle="list" href="#schedule">Schedule</a>
                            </div>
                            <div class="tab-content px-0 mt-0">

                                <div class="tab-pane fade show active" id="overview">
                                    <p class="h2 fw-bold">Description</p>
                                    <p>{{ props.doctor.description }}</p>

                                    <p class="h2 fw-bold mt-5">Specialities</p>
                                    <div>
                                        <ul class="list-group">
                                            <li v-for="(tag, index) in tags" :key="index" class="list-group-item"><i
                                                class='bx bxs-quote-single-left'></i>{{ tag.name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="experience">
                                    <p class="h2 fw-bold">Experience</p>
                                    <p><i class='bx bxs-quote-single-left'></i> {{ props.doctor.experience }} <i
                                        class='bx bxs-quote-single-right'></i></p>
                                </div>
                                <div class="tab-pane fade" id="personal">
                                    <p class="h3 fw-bold">Personal Informations</p>
                                    <div class="ps-3 mt-4">
                                        <ul>
                                            <span class="fw-bold text-primary"><i class='bx bxs-cake'></i> Date of Birth</span>
                                            <li class="font-monospace">{{ props.doctor.dob }}</li>
                                        </ul>
                                        <ul>
                                            <span class="fw-bold text-primary"><i
                                                class='bx bxs-envelope'></i> Email</span>
                                            <li class="font-monospace">{{ props.user.email }}</li>
                                        </ul>
                                        <ul>
                                            <span class="fw-bold text-primary"><i
                                                class='bx bx-male-sign'></i> Gender</span>
                                            <li v-if="props.doctor.gender === 'M'" class="font-monospace">Male</li>
                                            <li v-else class="font-monospace">Female</li>
                                        </ul>
                                        <ul>
                                            <span class="fw-bold text-primary"><i class='bx bxs-phone text-primary'></i>Contact</span>
                                            <li class="font-monospace">{{ props.doctor.contact }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="schedule">
                                    <p class="h3 fw-bold">Schedule Timings</p>
                                    <div class="mt-3">
                                        <div class="row shadow p-3">
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Monday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Tuesday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Wednesday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Thursday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Friday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                            <div class="col-6 text-start"><i class='bx bxs-stopwatch text-primary'></i>
                                                Saturday
                                            </div>
                                            <div class="col-6 text-end">Time: <span
                                                class="font-monospace">03:00 - 05:45</span></div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


