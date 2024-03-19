<script setup>
import Layout from '@/Layouts/Layout.vue'
import UploadPicture from '@/Components/UploadPicture.vue'
import InputPassword from '@/Components/InputPassword.vue'
import {Head, Link, useForm} from '@inertiajs/vue3'

const form = useForm({
    profile: null,
    name: '',
    email: '',
    password: '',
    confirm_password: '',
})

</script>
<template>
    <Head><title>Create AppUser</title></Head>
    <Layout>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">App User </h5>
                    <h5 class="float-end">
                        <Link :href="route('dashboard.user')">
                            Back
                        </Link>
                    </h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="form.post(route('dashboard.user.store'))">
                        <div class="mb-3">
                            <UploadPicture @image="(image)=>form.profile=image"
                                          :error="form.errors.profile"></UploadPicture>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxs-user'></i></span>
                                <input v-model="form.name" type="text" class="form-control" placeholder="name" id="name" autocomplete="true">
                            </div>
                            <span class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxs-envelope'></i></span>
                                <input v-model="form.email" type="email" class="form-control" placeholder="email" id="email" autocomplete="true">
                                <span class="input-group-text">@example.com</span>
                            </div>
                            <span class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                <InputPassword v-model="form.password" :id="'password'" ></InputPassword>
                            </div>
                            <span class="text-danger" v-if="form.errors.password">{{ form.errors.password }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="confirm-password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                <InputPassword v-model="form.confirm_password" :id="'confirm-password'" ></InputPassword>
                            </div>
                            <span class="text-danger"
                                  v-if="form.errors.confirm_password">{{ form.errors.confirm_password }}</span>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }"
                                    :disabled="form.processing">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
