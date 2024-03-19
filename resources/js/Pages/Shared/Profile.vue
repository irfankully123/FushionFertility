<script setup>
import Layout from '@/Layouts/Layout.vue'
import UploadPicture from '@/Components/UploadPicture.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import InputPassword from '@/Components/InputPassword.vue'
import {Head, useForm, usePage} from "@inertiajs/vue3";
import Swal from '@/Alerts/SweetAlerts.js'
import {onMounted} from "vue";

const {user} = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    profile: '',
    name: '',
    email: '',
    new_password: '',
    old_password: '',
    confirm_password: '',
})

const successMessage = () => {
    Swal.fire({
        icon: 'success',
        title: 'Changes saved successfully',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    })
}

const handleSubmit = () => {
    form.post(route('dashboard.auth.update'), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage();
            form.new_password = '';
            form.old_password = '';
            form.confirm_password = '';
        },
    })
}

onMounted(() => {
    form.name = user.name;
    form.email = user.email;
});

const doctor = usePage().props.doctorObject;

</script>

<template>
    <Head>
        <title>Dashboard Profile</title>
    </Head>
    <Layout>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <UploadPicture @image="(image)=>form.profile=image"
                                       :image="user.profile"
                                       :error="form.errors.profile">
                        </UploadPicture>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-user'></i></span>
                            <input v-model="form.name" type="text" class="form-control" placeholder="name">
                        </div>
                        <span class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-envelope'></i></span>
                            <input v-model="form.email" type="email" class="form-control" placeholder="email"
                                   aria-label="john.doe" aria-describedby="basic-default-email2">
                            <span class="input-group-text">@example.com</span>
                        </div>
                        <span class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="old_password">Old Password</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-key'></i></span>
                            <InputPassword v-model="form.old_password" :id="'old_password'"></InputPassword>
                        </div>
                        <span class="text-danger" v-if="form.errors.old_password">{{ form.errors.old_password }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="new_password">New Password</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-key'></i></span>
                            <InputPassword v-model="form.new_password" :id="'new_password'"></InputPassword>
                        </div>
                        <span class="text-danger" v-if="form.errors.new_password">{{ form.errors.new_password }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-key'></i></span>
                            <InputPassword v-model="form.confirm_password" :id="'confirm_password'"></InputPassword>
                        </div>
                        <span class="text-danger" v-if="form.errors.confirm_password">{{form.errors.confirm_password}}</span>
                    </div>
                    <div class="text-end">
                        <SpinnerButton @click="handleSubmit" type="submit" class="btn btn-primary" :processing="form.processing">
                            Save
                        </SpinnerButton>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>



