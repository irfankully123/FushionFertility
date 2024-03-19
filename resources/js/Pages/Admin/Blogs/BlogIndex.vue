<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import Swal from '@/Alerts/SweetAlerts.js'
import {Head, router, Link, usePage} from "@inertiajs/vue3";
import {computed, ref, watch} from "vue";
import {debounce} from "lodash";


const props = defineProps({
    blogs: {
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
    router.get(route('dashboard.blogs'), {search: value}, {preserveState: true, replace: true});
}, 500));


const destroy = (id) => router.delete(route('dashboard.blog.destroy', id));

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


const splitDateTime = (dateTimeString) => {
    let dateTimeParts = dateTimeString.split('T');
    let date = dateTimeParts[0];
    let time = dateTimeParts[1].split('.')[0]; // Remove milliseconds and 'Z'

    return {
        date: date,
        time: time
    };
}

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
            Blogs
        </title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <Link v-if="createPermission" :href="route('dashboard.blogs.create')" type="button"
                      class="btn btn-success">Create
                </Link>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" type="search" class="form-control"
                                       placeholder="Search"
                                       aria-label="Search" aria-describedby="search-addon" id="search"
                                       name="search"/>
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
                        <th>category name</th>
                        <th>title</th>
                        <th>author name</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(blog,index) in props.blogs.data" :key="index">
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ index + 1 }}</strong></td>
                        <td>{{ blog.id }}</td>
                        <td>{{ blog.category.category_name }}</td>
                        <td>{{ blog.title }}</td>
                        <td>{{ blog.author_name }}</td>
                        <td>{{ splitDateTime(blog.created_at)['date'] }}</td>
                        <td>{{ splitDateTime(blog.updated_at)['date'] }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <Link v-if="updatePermission" :href="route('dashboard.blogs.edit',blog.id)"
                                          as="button" class="btn btn-warning mx-1">Edit
                                    </Link>
                                    <button v-if="deletePermission" @click="showAlert(blog.id)" type="button"
                                            class="btn btn-danger mx-1">Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="props.blogs.total > 8">
            <Pagination
                :links="props.blogs.links"
                :first-page-url="props.blogs.links.first_page_url"
                :last-page-url="props.blogs.links.last_page_url"
                :last-page-check="props.blogs.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>
