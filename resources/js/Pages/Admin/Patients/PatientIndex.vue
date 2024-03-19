<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import {Head, router, Link, usePage} from "@inertiajs/vue3";
import Swal from '@/Alerts/SweetAlerts.js'
import {computed, ref, watch} from "vue";
import { debounce } from 'lodash';


const props = defineProps({
    patients: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('dashboard.patients'), { search: value }, { preserveState: true, replace: true });
}, 500));


const destroy = (id) => router.delete(route('dashboard.patients.delete', id));

const successMessage = (message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
};

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
            Patients
        </title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <Link v-if="createPermission" :href="route('dashboard.patients.storeForm')" as="button" type="button" class="btn btn-success">Create</Link>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" type="search" class="form-control rounded" placeholder="Search" id="search" name="search"/>
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
                        <th>profile</th>
                        <th>name</th>
                        <th>email</th>
                        <th>city</th>
                        <th>contact</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(patient,index) in props.patients.data" :key="index">
                        <td>{{index + 1}}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ patient.id }}</strong></td>
                        <td>
                            <img v-if="patient.user.profile!=null" :src="`/storage/users/${patient.user.profile}`" alt="patient_profile" class="w-px-40 h-auto rounded-circle"/>
                            <img v-else src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="placeholder" class="w-px-40 h-auto rounded-circle"/>
                        </td>
                        <td>{{ patient.user.name }}</td>
                        <td>{{ patient.user.email }}</td>

                        <td>{{ patient.city }}</td>
                        <td>{{ patient.contact }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <Link v-if="updatePermission" as="button" :href="route('dashboard.patients.editForm',patient.id)"  type="button"  class="btn btn-warning mx-1">Edit</Link>
                                    <button  v-if="deletePermission" @click="showAlert(patient.id)" type="button"  class="btn btn-danger mx-1">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="props.patients.total > 8">
            <Pagination
                :links="props.patients.links"
                :first-page-url="props.patients.links.first_page_url"
                :last-page-url="props.patients.links.last_page_url"
                :last-page-check="props.patients.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>




