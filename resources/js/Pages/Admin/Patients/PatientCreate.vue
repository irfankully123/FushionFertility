<script setup>
import Layout from '@/Layouts/Layout.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import UploadPicture from '@/Components/UploadPicture.vue'
import InputPassword from '@/Components/InputPassword.vue'
import {Head,Link,useForm} from "@inertiajs/vue3";


const form=useForm({
    profile:null,
    name:'',
    email:'',
    password:'',
    confirm:'',
    contact:'',
    blood_group:'0',
    gender:'0',
    address:'',
    zip_code:'',
    dob:'',
    age:0,
    city:'',
    state:'',
    primary_care_physician:'',
    medical_history:'',
    current_medications:''
});

const handleSubmit = () => {
    form.post(route('dashboard.patients.store'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('form submitted');
        },
    })
}
</script>


<template>
    <Head>
        <title>
            Patient Create
        </title>
    </Head>
    <Layout>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Patient form </h5>
                <h5 class="float-end">
                    <Link :href="route('dashboard.patients')">
                        Back</Link>
                </h5>
            </div>
            <div class="card-body">
                <UploadPicture
                    @image="(file)=>form.profile=file"
                    :error="form.errors.profile">
                </UploadPicture>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                  <span class="input-group-text border-primary"><i
                      class='bx bxs-user'></i></span>
                                <input v-model="form.name" type="text" class="form-control border-primary" placeholder="name" id="name" autocomplete="true"/>
                            </div>
                        </div>
                        <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>
                    </div>
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-envelope'></i></span>
                                <input v-model="form.email"  type="email" class="form-control border-primary" placeholder="example@gmail.com" id="email" autocomplete="true">
                            </div>
                            <span v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-key'></i></span>
                                <InputPassword v-model="form.password" :border="true" :id="'password'" ></InputPassword>
                            </div>
                            <span v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <label class="form-label" for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-key'></i></span>
                                <InputPassword v-model="form.confirm" :border="true" :id="'confirm-password'" ></InputPassword>
                            </div>
                            <span v-if="form.errors.confirm" class="text-danger">{{ form.errors.confirm }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="contact">Contact <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                  <span class="input-group-text border-primary"><i
                      class='bx bxs-contact'></i></span>
                                <input v-model="form.contact"  type="number" class="form-control border-primary"
                                       placeholder="(555) 555-1234" id="contact"/>
                            </div>
                            <span v-if="form.errors.contact" class="text-danger">{{ form.errors.contact }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="blood-group">Blood Group <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-donate-blood'></i></span>
                                <select v-model="form.blood_group"  class="form-select border-primary" name="gender" id="blood-group">
                                    <option value="0">select blood group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <span v-if="form.errors.blood_group" class="text-danger">{{ form.errors.blood_group }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                  <span class="input-group-text border-primary"><i
                      class='bx bx-male-sign fw-bold'></i></span>
                                <select v-model="form.gender"  class="form-select border-primary" name="gender" id="gender">
                                    <option value="0" >select gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <span v-if="form.errors.gender" class="text-danger">{{ form.errors.gender }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                  <span class="input-group-text border-primary"><i
                      class='bx bxs-location-plus'></i></span>
                                <input v-model="form.address"  type="text" class="form-control border-primary"
                                       placeholder="address" id="address" autocomplete="true">
                            </div>
                            <span v-if="form.errors.address" class="text-danger">{{ form.errors.address }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="zip-code">Zip Code <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxl-discourse'></i></span>
                                <input v-model="form.zip_code"  type="number" class="form-control border-primary"
                                       placeholder="e.g ( 71601 )" id="zip-code" autocomplete="true">
                            </div>
                            <span v-if="form.errors.zip_code" class="text-danger">{{ form.errors.zip_code }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input v-model="form.dob"  type="date" class="form-control border-primary" id="dob">
                            </div>
                            <span v-if="form.errors.dob" class="text-danger">{{ form.errors.dob }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="age">Age <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bx-male'></i></span>
                                <input v-model="form.age"  type="number" class="form-control border-primary"
                                       placeholder="your age" id="age">
                            </div>
                            <span v-if="form.errors.age" class="text-danger">{{ form.errors.age }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">City <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bxs-city'></i></span>
                                <input v-model="form.city"  type="text" class="form-control border-primary"
                                       placeholder="city" id="city">
                            </div>
                            <span v-if="form.errors.city" class="text-danger">{{ form.errors.city }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="state">State <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text border-primary"><i class='bx bx-buildings'></i></span>
                                <input v-model="form.state"  type="text" class="form-control border-primary"
                                       placeholder="state" id="state">
                            </div>
                            <span v-if="form.errors.state" class="text-danger">{{ form.errors.state }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="primary-care-physician">Primary Care Physician</label>
                            <div class="input-group input-group-merge">
                            <textarea v-model="form.primary_care_physician" name="physician" class="form-control border-primary" cols="30"
                                      rows="4" id="primary-care-physician"></textarea>
                            </div>
                            <span v-if="form.errors.primary_care_physician" class="text-danger">{{ form.errors.primary_care_physician }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="medical-history">Medical History</label>
                            <div class="input-group input-group-merge">
                           <textarea v-model="form.medical_history" name="medical" class="form-control border-primary"
                                     cols="30"
                                     rows="4" id="medical-history"></textarea>
                            </div>
                            <span v-if="form.errors.medical_history" class="text-danger">{{ form.errors.medical_history }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mt-3">
                            <label class="form-label" for="current-medications">Current Medications</label>
                            <div class="input-group input-group-merge">
                           <textarea  v-model="form.current_medications"  name="medications" class="form-control border-primary"
                                      cols="30"
                                      rows="4" id="current-medications"></textarea>
                            </div>
                            <span v-if="form.errors.current_medications" class="text-danger">{{ form.errors.current_medications }}</span>
                        </div>
                    </div>
                    <div class="col-12 text-end mt-3">
                        <SpinnerButton @click="handleSubmit" class="btn btn-primary" type="submit" :processing="form.processing" >
                            create
                        </SpinnerButton>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>




