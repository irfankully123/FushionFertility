<script setup>
const props = defineProps({
    zoom: {
        type: Object,
        required: true
    },
    error: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="row mt-4 gy-2">
        <h3 class="card-title text-primary">Attach Zoom Application</h3>
        <hr class="bg-secondary mt-5">
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="account_id">Account ID<span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-user'></i></span>
                    <input v-model="zoom.account_id" name="account_id" type="text" placeholder="Enter Doctor's Account ID" class="form-control border-primary" id="account_id"/>
                </div>
                <span class="text-danger" v-if="props.error['zoom.account_id']">{{ props.error['zoom.account_id'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="client_id">Client ID<span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-user'></i></span>
                    <input v-model="zoom.client_id" name="client_id" type="text" placeholder="Enter Doctor's Client ID" class="form-control border-primary" id="client_id"/>
                </div>
                <span class="text-danger" v-if="props.error['zoom.client_id']">{{ props.error['zoom.client_id'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="client_secret">Client Secret <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-lock'></i></span>
                    <input v-model="zoom.client_secret" name="client_secret" placeholder="Enter Doctor's Client Secret" type="text" class="form-control border-primary"  id="client_secret" />
                </div>
                <span class="text-danger" v-if="props.error['zoom.client_secret']">{{ props.error['zoom.client_secret'] }}</span>
            </div>
        </div>
    </div>
</template>



