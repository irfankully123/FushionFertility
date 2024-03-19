<script setup>
import InputPassword from "@/Components/InputPassword.vue";

const props = defineProps({
    userData: {
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
        <h3 class="card-title text-primary">Doctor Information</h3>
        <hr class="bg-secondary mt-5">
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-user'></i></span>
                    <input v-model="props.userData.name" name="name" type="text" class="form-control border-primary" placeholder="name" id="name" autocomplete="true"/>
                </div>
                <span class="text-danger" v-if="props.error['userData.name']">{{ props.error['userData.name'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="consultant_meeting_time">Consultant Timing<span
                    class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-alarm fw-bold'></i></span>
                    <select v-model="props.userData.consultant_meeting_time" class="form-select border-primary"
                            name="consultant_meeting_time" id="consultant_meeting_time">
                        <option value="0">Select Consultant Timing</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="60">60</option>
                    </select>
                </div>
                <span class="text-danger" v-if="props.error['userData.consultant_meeting_time']">{{props.error['userData.consultant_meeting_time'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="contact">Contact <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-contact'></i></span>
                    <input v-model="props.userData.contact" type="tel" class="form-control border-primary" placeholder="(555) 555-1234" id="contact" autocomplete="true"/>
                </div>
                <span class="text-danger" v-if="props.error['userData.contact']">{{ props.error['userData.contact'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="fee">Fee <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary">$</span>
                    <input type="number" class="form-control border-primary" placeholder="Amount" v-model="props.userData.fee" name="fee" id="fee" autocomplete="true"/>
                    <span class="input-group-text border-primary">.00</span>
                </div>
                <span class="text-danger" v-if="props.error['userData.fee']">{{ props.error['userData.fee'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bx-male-sign fw-bold'></i></span>
                    <select v-model="props.userData.gender" class="form-select border-primary" name="gender" id="gender">
                        <option value="0">Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <span class="text-danger" v-if="props.error['userData.gender']">{{ props.error['userData.gender'] }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mt-3">
                <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-location-plus'></i></span>
                    <input v-model="props.userData.address" type="text" class="form-control border-primary" placeholder="address" id="address" autocomplete="true">
                </div>
                <span class="text-danger" v-if="props.error['userData.address']">{{ props.error['userData.address'] }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <input v-model="props.userData.dob" type="date" class="form-control border-primary" id="dob"/>
                    <span class="text-danger" v-if="props.error?.dob">{{ props.error?.dob }}</span>
                </div>
            </div>
            <span class="text-danger" v-if="props.error['userData.dob']">{{props.error['userData.dob'] }}</span>
        </div>
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text border-primary"><i class='bx bxs-envelope'></i></span>
                    <input v-model="props.userData.email" type="email" class="form-control border-primary" placeholder="example@gmail.com" id="email" autocomplete="true"/>
                </div>
                <span class="text-danger" v-if="props.error['userData.email']">{{ props.error['userData.email'] }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mt-3">
                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge b">
                    <span class="input-group-text border-primary"><i class='bx bxs-key'></i></span>
                    <InputPassword v-model="props.userData.password" :id="'password'" :border="true"></InputPassword>
                </div>
                <span class="text-danger" v-if="props.error['userData.password']">{{props.error['userData.password'] }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mt-3 ">
                <label class="form-label" for="confirm-password">Confirm Password <span
                    class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text  border-primary"><i class='bx bxs-key'></i></span>
                    <InputPassword v-model="props.userData.confirm" :border="true" :id="'confirm-password'"></InputPassword>
                </div>
                <span class="text-danger" v-if="props.error['userData.confirm']">{{ props.error['userData.confirm'] }}</span>
            </div>
        </div>
    </div>
</template>
