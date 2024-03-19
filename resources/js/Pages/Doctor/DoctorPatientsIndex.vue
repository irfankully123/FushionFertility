<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import {Head, router,Link} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import { debounce } from 'lodash';

const props = defineProps({
    patients: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('doctor_dashboard.patients'), { search: value }, { preserveState: true, replace: true });
}, 500));


</script>

<template>
    <Head>
        <title> Doctor Patients</title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                Patients
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
                        <th>name</th>
                        <th>email</th>
                        <th>city</th>
                        <th>address</th>
                        <th>state</th>
                        <th>contact</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(patient,index) in props.patients.data" :key="index">
                        <td>{{index + 1}}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ patient.id }}</strong></td>
                        <td>{{ patient.user.name }}</td>
                        <td>{{ patient.user.email }}</td>
                        <td>{{ patient.city }}</td>
                        <td>{{ patient.address }}</td>
                        <td>{{ patient.state }}</td>
                        <td>{{ patient.contact }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <Link :href="route('doctor_dashboard.patientsDetail',patient.id)" as="button" class="btn btn-dark mx-1">Detail</Link>
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



