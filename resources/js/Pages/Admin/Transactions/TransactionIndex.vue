<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import {Head, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import { debounce } from 'lodash';

const props = defineProps({
    transactions: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default:()=>({}),
    }
})

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('dashboard.transactions'), { search: value }, { preserveState: true, replace: true });
}, 500));

</script>

<template>
    <Head>
        <title>Transactions</title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <h1>Transactions</h1>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" id="search" name="search" type="search" class="form-control rounded" placeholder="Search"
                                       aria-label="Search" aria-describedby="search-addon"/>
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
            </table>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>patient_id</th>
                        <th>transaction_date</th>
                        <th>amount</th>
                        <th>payment_method</th>
                        <th>card_brand</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(transaction,index) in props.transactions.data" :key="index">
                        <td>{{index + 1}}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{transaction.id}}</strong></td>
                        <td>{{transaction.patient_id}}</td>
                        <td>{{transaction.transaction_date}}</td>
                        <td>${{transaction.amount}}</td>
                        <td>{{transaction.payment_method}}</td>
                        <td>{{transaction.card_brand}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="props.transactions.total > 8">
            <Pagination
                :links="props.transactions.links"
                :first-page-url="props.transactions.links.first_page_url"
                :last-page-url="props.transactions.links.last_page_url"
                :last-page-check="props.transactions.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>





