<script setup>
import Layout from '@/Layouts/Layout.vue'
import {Head,Link} from '@inertiajs/vue3';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => ([]),
    },
    user_name:{
        type:String,
        default:''
    }
});



const dateOnly = (date) => date.split("T")[0];

</script>
<template>
    <Head>
        <title>User Permissions</title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <h5 class="float-end">
                    <Link :href="route('dashboard.user')">Back</Link>
                </h5>
                <h5>{{ props.user_name }}</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>guard</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(permission,index) in props.permissions" :key="index">
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ permission.id }}</strong>
                        </td>
                        <td>{{ permission.name }}</td>
                        <td>{{ permission.guard_name }}</td>
                        <td>{{ dateOnly(permission.created_at ) }}</td>
                        <td>{{ dateOnly(permission.updated_at)  }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>
