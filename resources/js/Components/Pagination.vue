<script setup>
import {Link} from '@inertiajs/vue3'
import { computed } from 'vue'

const  props = defineProps({
    links: {
        type:Array,
        required:true
    },
    firstPageUrl:{
        type:String,
        required:true
    },
    lastPageUrl:{
        type:String,
        required:true
    },
    lastPageCheck:{
        type:Number,
        required:true
    }
});

const checkingPageCount = computed(() => {
    return  props.lastPageCheck > 1
})


</script>

<template>
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="demo-inline-spacing">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li v-if="checkingPageCount" class="page-item first">
                            <Link class="page-link" :href="firstPageUrl"><i class="tf-icon bx bx-chevrons-left"></i></Link>
                        </li>
                        <li v-for="(link,index) in links"  :key="index" class="page-item" :class="{ 'active': link.active }">
                            <Link v-if="link.url!=null" class="page-link"  :href="link.url" v-html="link.label"></Link>
                        </li>
                        <li v-if="checkingPageCount" class="page-item last">
                            <Link class="page-link" :href="lastPageUrl"><i class="tf-icon bx bx-chevrons-right"></i></Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>



