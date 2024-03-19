<script setup>
import Layout from '@/Layouts/Layout.vue'
import Modal from '@/Components/Smodal.vue'
import {Link, Head, router, useForm} from '@inertiajs/vue3'
import Swal from '@/Alerts/SweetAlerts.js'
import {reactive} from 'vue'

const props = defineProps({
    users: {
        type: Array,
        default: () => ([])
    },
    permissions: {
        type: Array,
        default: () => ([])
    }

});

const form = useForm({
    permission: '0',
})

const userId = {id: null};

const state = reactive({showModalAssign: false, showModelRevoke: false})

const successMessage = (message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
}

const assign = () => {
    form.post(route('dashboard.user.assignPermission', userId.id), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage('Assigned');
            state.showModalAssign = !state.showModalAssign;
            userId.id = null;
            form.reset();
            form.clearErrors();
        },
    })
}

const revoke = () => {
    form.delete(route('dashboard.user.revokePermission', userId.id), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage('Revoked');
            state.showModelRevoke = !state.showModelRevoke;
            userId.id = null;
            form.reset();
            form.clearErrors();
        },
    })
}

const destroy = (id) => {router.delete(route('dashboard.user.destroy', id))};

const showAlert = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this ' + id,
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
    })
}


</script>

<template>
    <Head><title>App User</title></Head>
    <Modal v-if="state.showModalAssign" :title="'Assign Permission'">
        <template #header>
            <button class="btn-close"
                    @click="()=>{state.showModalAssign=!state.showModalAssign;form.clearErrors();form.reset();userId.id=null}"></button>
        </template>
        <template #body>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <select v-model="form.permission" class="form-select" aria-label="Default select example">
                        <option value="0">Select</option>
                        <option v-for="(permission,index) in permissions" :key="index">{{ permission.name }}</option>
                    </select>
                    <span class="text-danger">{{ form.errors.permission }}</span>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button"
                    @click="()=>{state.showModalAssign=!state.showModalAssign;form.clearErrors();form.reset();userId.id=null}"
                    class="btn btn-dark">Close
            </button>
            <button type="submit" @click="assign()" class="btn btn-primary"
                    :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Save
            </button>
        </template>
    </Modal>
    <Modal v-if="state.showModelRevoke" :title="'Revoke Permission'">
        <template #header>
            <button class="btn-close"
                    @click="()=>{state.showModelRevoke=!state.showModelRevoke;form.clearErrors();form.reset();userId.id=null}"></button>
        </template>
        <template #body>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <select v-model="form.permission" class="form-select" aria-label="Default select example">
                        <option value="0">Select</option>
                        <option v-for="(permission,index) in permissions" :key="index">{{ permission.name }}</option>
                    </select>
                    <span class="text-danger">{{ form.errors.permission }}</span>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button"
                    @click="()=>{state.showModelRevoke=!state.showModelRevoke;form.clearErrors();form.reset();userId.id=null}"
                    class="btn btn-dark">Close
            </button>
            <button type="submit" @click="revoke()" class="btn btn-danger" :class="{ 'text-white-50': form.processing }"
                    :disabled="form.processing">
                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Revoke
            </button>
        </template>
    </Modal>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <Link :href="route('dashboard.user.showStoreForm')" as="button" class="btn btn-success">Create</Link>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>profile</th>
                        <th>name</th>
                        <th>email</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(user,index) in props.users" :key="index">
                        <td>{{index + 1}}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ user.id }}</strong></td>
                        <td>
                            <img v-if="user.profile!=null" :src="`/storage/users/${user.profile}`" alt=""
                                 class="w-px-40 h-auto rounded-circle"/>
                            <img v-else src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="" class="w-px-40 h-auto rounded-circle"/>
                        </td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <Link as="button" :href="route('dashboard.user.showEditForm',user.id)" type="button"
                                          class="btn btn-warning mx-1">Edit
                                    </Link>
                                    <button
                                        @click="()=>{state.showModalAssign=!state.showModalAssign;userId.id=user.id}"
                                        type="button"
                                        class="btn btn-primary mx-1">Assign Permission
                                    </button>
                                    <button
                                        @click="()=>{state.showModelRevoke=!state.showModelRevoke;userId.id=user.id}"
                                        type="button"
                                        class="btn btn-danger mx-1">Revoke Permission
                                    </button>
                                    <Link :href="route('dashboard.user.permissions',user.id)" as="button"
                                          class="btn btn-dark mx-1">All Permissions
                                    </Link>
                                    <button @click="showAlert(user.id)" type="button" class="btn btn-danger mx-1">
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
    </Layout>
</template>
