<script setup>
import Layout from '@/Layouts/Layout.vue'
import ActiveUserLineChart from '@/Graphs/MonthlyActiveUsers.vue'
import TransactionChart from '@/Graphs/MonthlyTransactions.vue'
import {Head} from '@inertiajs/vue3'


const props = defineProps({
    doctors: {
        type: Number,
        default: 0
    },
    patients: {
        type: Number,
        default: 0
    },
    appointments: {
        type: Number,
        default: 0
    },
    transactions: {
        type: Number,
        default: 0
    }

})


const transactions = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
        {
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }
    ]
};


</script>
<template>
    <Head>
        <title>Home</title>
    </Head>
    <Layout>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="user-plus">
                                    <path fill="#6563FF"
                                          d="M21,10.5H20v-1a1,1,0,0,0-2,0v1H17a1,1,0,0,0,0,2h1v1a1,1,0,0,0,2,0v-1h1a1,1,0,0,0,0-2Zm-7.7,1.72A4.92,4.92,0,0,0,15,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,2,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,13.3,12.22ZM10,11.5a3,3,0,1,1,3-3A3,3,0,0,1,10,11.5Z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Patients</span>
                        <h3 class="card-title mb-2">{{ props.patients }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24"
                                     id="user-md">
                                    <path fill="#6563FF"
                                          d="m15.899 13.229-.005-.002c-.063-.027-.124-.058-.188-.083A5.988 5.988 0 0 0 18 8.434a5.29 5.29 0 0 0-.045-.63.946.946 0 0 0 .038-.122l.281-2.397a3.006 3.006 0 0 0-2.442-3.302l-.79-.143a16.931 16.931 0 0 0-6.083 0l-.791.143a3.006 3.006 0 0 0-2.442 3.302l.28 2.397a.946.946 0 0 0 .039.122 5.29 5.29 0 0 0-.045.63 5.988 5.988 0 0 0 2.294 4.71c-.064.025-.125.056-.188.083l-.005.002a9.948 9.948 0 0 0-6.035 8.097 1 1 0 0 0 1.988.217 7.948 7.948 0 0 1 4.216-6.185l3.023 3.023a1 1 0 0 0 1.414 0l3.023-3.023a7.948 7.948 0 0 1 4.216 6.185 1 1 0 0 0 .992.892 1.048 1.048 0 0 0 .11-.006 1 1 0 0 0 .886-1.103 9.948 9.948 0 0 0-6.036-8.097ZM7.712 5.051a1.002 1.002 0 0 1 .814-1.1l.79-.143a14.93 14.93 0 0 1 5.368 0l.79.143a1.002 1.002 0 0 1 .814 1.1l-.178 1.514H7.89ZM12 16.261l-1.65-1.651a7.85 7.85 0 0 1 3.3 0Zm0-3.826a4.005 4.005 0 0 1-3.998-3.87h7.996A4.005 4.005 0 0 1 12 12.435Z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Doctors</span>
                        <h3 class="card-title mb-2">{{ props.doctors }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="schedule">
                                    <path fill="#6563FF"
                                          d="M12,14a1,1,0,1,0-1-1A1,1,0,0,0,12,14Zm5,0a1,1,0,1,0-1-1A1,1,0,0,0,17,14Zm-5,4a1,1,0,1,0-1-1A1,1,0,0,0,12,18Zm5,0a1,1,0,1,0-1-1A1,1,0,0,0,17,18ZM7,14a1,1,0,1,0-1-1A1,1,0,0,0,7,14ZM19,4H18V3a1,1,0,0,0-2,0V4H8V3A1,1,0,0,0,6,3V4H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm1,15a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V10H20ZM20,8H4V7A1,1,0,0,1,5,6H19a1,1,0,0,1,1,1ZM7,18a1,1,0,1,0-1-1A1,1,0,0,0,7,18Z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="d-block mb-1">Appointments</span>
                        <h3 class="card-title text-nowrap mb-2">{{ props.appointments }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="credit-card">
                                    <path fill="#6563FF"
                                          d="M7,15h3a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2ZM19,5H5A3,3,0,0,0,2,8v9a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8A3,3,0,0,0,19,5Zm1,12a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V11H20Zm0-8H4V8A1,1,0,0,1,5,7H19a1,1,0,0,1,1,1Z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Transactions</span>
                        <h3 class="card-title mb-2">{{ props.transactions }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <ActiveUserLineChart></ActiveUserLineChart>
            </div>
            <div class="col-lg-6">
                <TransactionChart></TransactionChart>
            </div>
        </div>
    </Layout>
</template>
