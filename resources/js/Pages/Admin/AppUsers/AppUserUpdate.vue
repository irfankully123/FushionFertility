<script setup>
import Layout from '@/Layouts/Layout.vue'
import UploadPicture from '@/Components/UploadPicture.vue'
import {Head, Link,useForm} from '@inertiajs/vue3'
import { onMounted} from 'vue'


const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    image: {
        type: String,
        default: null
    }
});

const form = useForm({
    profile: null,
    id: null,
    name: '',
    email: '',
})

const handleUpdate = () => {
    form.clearErrors();
    form.post(route('dashboard.user.update',props.user.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    })
}

onMounted(() => {
    form.name = props.user.name;
    form.email = props.user.email;
    form.id = props.user.id;
})


</script>
<template>
    <Head>
        <title>Update User</title>
    </Head>
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
                    <div class="mb-3">
                        <UploadPicture
                            @image="(image)=>form.profile=image"
                            :image="user.profile"
                            :error="form.errors.profile">
                        </UploadPicture>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Name</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-user'></i></span>
                            <input v-model="form.name" type="text" class="form-control" placeholder="John Doe">
                        </div>
                        <span class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class='bx bxs-envelope'></i></span>
                            <input v-model="form.email" type="email" class="form-control" placeholder="john.doe"
                                   aria-label="john.doe" aria-describedby="basic-default-email2">
                            <span class="input-group-text" id="basic-default-email2">@example.com</span>
                        </div>
                        <span class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</span>
                    </div>
                    <div class="text-end">
                        <button @click="handleUpdate" type="submit" class="btn btn-primary"
                                :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
