<script setup>
import Layout from '@/Layouts/Layout.vue'
import SpinnerButton from '@/Components/SpinnerButton.vue'
import {Head, Link, useForm} from "@inertiajs/vue3";
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {reactive, ref} from "vue";

const props = defineProps({
    categories: {
        type: Array,
        default: () => ([])
    }
});

const form = useForm({
    image: null,
    category: '0',
    title: '',
    content: '',
    author: '',
})

const editor = ref(null);

const imageState = reactive({image: null})

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageState.image = e.target.result;
        };
        reader.readAsDataURL(file);
        // Assuming `form` is an object, you need to access its property using dot notation or brackets notation
        form.image = event.target.files[0];
    }
};

</script>

<template>
    <Head>
        <title>Create Blog</title>
    </Head>
    <Layout>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Blogs</h5>
                    <h5 class="float-end">
                        <Link :href="route('dashboard.blogs')">
                            Back
                        </Link>
                    </h5>
                </div>
                <form @submit.prevent="form.post(route('dashboard.blog.store'))">
                    <div class="card-body">
                        <div class="mb-3">
                            <img v-if="imageState.image" :src="imageState.image" width="200" height="200" alt="blog">
                            <img v-else
                                 src="https://i0.wp.com/roadmap-tech.com/wp-content/uploads/2019/04/placeholder-image.jpg?fit=1200%2C900&ssl=1"
                                 width="200" height="200" alt="Placeholder">
                            <input type="file" class="form-control mt-3" @change="(event)=> handleFileSelect(event)">
                            <span v-if="form.errors.image" class="text-danger">{{form.errors.image}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bx-text'></i></span>
                                <input v-model="form.title" type="text" class="form-control" placeholder="blog title" id="title" autocomplete="true">
                            </div>
                            <span v-if="form.errors.title" class="text-danger">{{form.errors.title}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Author</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bxs-quote-right'></i></span>
                                <input v-model="form.author" type="text" class="form-control" placeholder="blog author" id="author" autocomplete="true">
                            </div>
                            <span v-if="form.errors.author" class="text-danger">{{form.errors.author}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category">Blog Category</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class='bx bx-category-alt'></i></span>
                                <select v-model="form.category" class="form-select" id="category">
                                    <option value="0">Select Blog Category</option>
                                    <option v-for="(category,index) in props.categories" :key="index" >{{category.category_name}}</option>
                                </select>
                            </div>
                            <span v-if="form.errors.category" class="text-danger">{{form.errors.category}}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Blog Content</label>
                            <div class="quill-container">
                                <quill-editor ref="editor" v-model:content="form.content" toolbar="full" theme="snow" contentType="html"></quill-editor>
                            </div>
                            <span v-if="form.errors.content" class="text-danger">{{form.errors.content}}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            <SpinnerButton class="btn btn-primary" type="submit" :processing="form.processing">
                                create
                            </SpinnerButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>


<style scoped>
.quill-container {
    height: 300px;
    overflow: auto;
    width: 100%;
}
</style>
