<script setup>
import Layout from '@/Layouts/Layout.vue'
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
import Swal from '@/Alerts/SweetAlerts.js'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Smodal.vue'
import {computed, reactive, ref, watch} from "vue";
import {debounce} from "lodash";

const props = defineProps({
    blogcategories: {
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
    router.get(route('dashboard.blog.category'), {search: value}, {preserveState: true, replace: true});
}, 500));


const state = reactive({showModalCreate: false, showModalEdit: false});

const form = useForm({category_name: ''});

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
    form.post(route('dashboard.blog.categoryStore'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            state.showModalCreate = !state.showModalCreate;
            successMessage('Created');
        },
    });
}

const category = {id: null};

const handleEdit = (index) => {
    state.showModalEdit = !state.showModalEdit;
    form.category_name = props.blogcategories.data[index].category_name;
    category.id = props.blogcategories.data[index].id;
}


const handleUpdate = () => {
    form.post(route('dashboard.blog.categoryUpdate', category.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            category.id = null;
            state.showModalEdit = !state.showModalEdit;
            successMessage('Updated');
        },
    });
}

const destroy = (id) => router.delete(route('dashboard.blog.categoryDestroy', id));

const handleDelete = (id) => {
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
            Blogs Category
        </title>
    </Head>
    <Layout>
        <Modal v-if="state.showModalCreate" title="Create Category">
            <template #header>
                <button class="btn-close"
                        @click="()=>{state.showModalCreate=!state.showModalCreate;form.clearErrors();form.reset()}"></button>
            </template>
            <template #body>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge b">
                            <span class="input-group-text border-primary"><i class='bx bx-category'></i></span>
                            <input v-model="form.category_name" type="text" class="form-control border-primary"
                                   name="category_name" id="category_name"/>
                        </div>
                        <span v-if="form.errors.category_name" class="text-danger">{{form.errors.category_name }}</span>
                    </div>
                </div>
            </template>
            <template #footer>
                <button type="button"
                        @click="()=>{state.showModalCreate=!state.showModalCreate;form.clearErrors();form.reset()}"
                        class="btn btn-dark">Close
                </button>
                <button type="submit" @click="handleSubmit()" class="btn btn-primary"
                        :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Save
                </button>
            </template>
        </Modal>
        <Modal v-if="state.showModalEdit" title="Edit Category">
            <template #header>
                <button class="btn-close"
                        @click="()=>{state.showModalEdit=!state.showModalEdit;form.clearErrors();form.reset();category.id=null}"></button>
            </template>
            <template #body>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge b">
                            <span class="input-group-text border-primary"><i class='bx bx-category'></i></span>
                            <input v-model="form.category_name" type="text" class="form-control border-primary"
                                   name="category_name" id="category_name"/>
                        </div>
                        <span v-if="form.errors.category_name" class="text-danger">{{
                                form.errors.category_name
                            }}</span>
                    </div>
                </div>
            </template>
            <template #footer>
                <button type="button"
                        @click="()=>{state.showModalEdit=!state.showModalEdit;form.clearErrors();form.reset();category.id=null}"
                        class="btn btn-dark">Close
                </button>
                <button type="submit" @click="handleUpdate()" class="btn btn-primary"
                        :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Update
                </button>
            </template>
        </Modal>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <button v-if="createPermission" @click="state.showModalCreate=!state.showModalCreate" type="button"
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
                                <input v-model="search" type="search" class="form-control rounded" placeholder="Search"
                                       id="search" name="search"/>
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
                        <th>category_name</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(category,index) in props.blogcategories.data" :key="index">
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ index + 1 }}</strong></td>
                        <td>{{ category.id }}</td>
                        <td>{{ category.category_name }}</td>
                        <td>{{ splitDateTime(category.created_at)['date'] }}</td>
                        <td>{{ splitDateTime(category.updated_at)['date'] }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <button v-if="updatePermission" @click="handleEdit(index)" type="button"
                                            class="btn btn-warning mx-1">Edit
                                    </button>
                                    <button v-if="deletePermission" @click="handleDelete(category.id)" type="button"
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
        <div v-if="props.blogcategories.total > 8">
            <Pagination
                :links="props.blogcategories.links"
                :first-page-url="props.blogcategories.links.first_page_url"
                :last-page-url="props.blogcategories.links.last_page_url"
                :last-page-check="props.blogcategories.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>
