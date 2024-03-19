<script setup>
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import {Head, router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {debounce} from 'lodash';

const props = defineProps({
    invoices: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: ()=>({}),
    }

})

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get(route('dashboard.invoices'), {search: value}, {preserveState: true, replace: true});
}, 500));



</script>

<template>
    <Head>
        <title>Invoices</title>
    </Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <h1>Invoices</h1>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="row">
                            <div class="col-4">
                                <h6> Search </h6>
                                <input v-model="search" id="search" name="search" type="search"
                                       class="form-control rounded" placeholder="Search" aria-label="Search"
                                       aria-describedby="search-addon"/>
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
                        <th>transaction_id</th>
                        <th>invoice_number</th>
                        <th>total_amount</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(invoice ,index) in props.invoices.data" :key="index">
                        <th>{{index + 1}}</th>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ invoice.id }}</strong></td>
                        <td>{{ invoice.transaction_id }}</td>
                        <td>{{ invoice.invoice_number }}</td>
                        <td>{{ invoice.total_amount }}</td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <a :href="invoice.invoice_pdf" type="button" class="btn btn-warning mx-1">Export PDF</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="props.invoices.total > 8">
            <Pagination
                :links="props.invoices.links"
                :first-page-url="props.invoices.links.first_page_url"
                :last-page-url="props.invoices.links.last_page_url"
                :last-page-check="props.invoices.links.last_page"
            ></Pagination>
        </div>
    </Layout>
</template>




