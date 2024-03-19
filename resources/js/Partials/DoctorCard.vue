<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form</h5>
                <h5 class="float-end">
                    <Link :href="route('dashboard.doctor')">Back</Link>
                </h5>
            </div>
            <div class="card-body">
                <slot name="body"></slot>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>


