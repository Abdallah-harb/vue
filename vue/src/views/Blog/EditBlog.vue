<template>
    <div class="container-fluid mt-5">
        <h2> Edit Blog</h2>
        <div class="row">
            <div class="col-12">
                <v-text-field label="Title" v-model="blog.title" variant="outlined" aria-required="true"></v-text-field>
            </div>
            <div class="col-12">
                <QuillEditor
                    theme="snow"
                    contentType="html"
                    v-model:content="blog.content"
                    style="height: 170px"
                />
            </div>
            <p></p>
            <div class="col-4">
                <v-file-input
                    v-model="newImage"
                    label="Main image"
                    accept="image/*"
                    prepend-icon="mdi-camera"
                    @change="previewImage"
                    aria-required="true"
                ></v-file-input>
                <p class="text-center">Current Image</p>
                <v-img v-if="blog.image" :src="blog.image" max-width="300" max-height="300px" class="mt-4"></v-img>
            </div>
            <div class="col-8">
                <v-file-input
                    v-model="newImages"
                    label="Other Images can upload multi-images"
                    accept="image/*"
                    prepend-icon="mdi-camera"
                    @change="previewImages"
                    multiple
                    aria-required="true"
                ></v-file-input>
                <p class="text-center"> Current images</p>
                <div class="d-flex justify-content-center ga-2">

                    <v-img
                        v-for="(imagePreview, index) in blog.images"
                        :key="index"
                        :src="imagePreview"
                        max-width="300" max-height="300px"
                        class="mt-4"
                    ></v-img>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
            <button class="btn btn-primary" @click="updateBlog()">Submit </button>

        </div>
    </div>
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {useRoute, useRouter} from "vue-router";
import axios from "axios";
import {url} from "../../config.js";
import {onMounted, ref} from "vue";
import {CSRF} from "../../stores/CSRF.js";

const route = useRoute();
const router = useRouter();
const blog = ref({});
const newImage = ref(null);
const newImages = ref([]);
const formData = new FormData();
const laravelCookies = CSRF();
    const getBlog = async ()=>{
        await laravelCookies.getCookies();
       await  url.get('/blogs/'+route.params.slug)
         .then((response)=>{
          console.log(response.data.data.blog)
          blog.value = response.data.data.blog;
          console.log("blog content ",blog.value.title)
         })
        .catch((error)=>{
           console.log('error on get blog data',error)
        });
    }
    const updateBlog = async ()=>{
        formData.append('_method',"put");
        formData.append('title',blog.value.title);
        formData.append('content',blog.value.content);
        formData.append('id',blog.value.id);
        if (newImage.value){
            formData.append('image',newImage.value)
        }
        if (newImages.value && newImages.value.length){
            Array.from(newImages.value).forEach((image,index)=>{
                formData.append(`images[${index}]`, image);
            });
        }
        axios.post(url+'/blogs/'+route.params.id,formData)
            .then((response)=>{
                router.push({name:'blogs'});
            })
            .catch((error)=>{
                console.log("error on update blog",error);
        });
    }
onMounted(()=>{
    getBlog();
})
</script>

<style scoped>

</style>
