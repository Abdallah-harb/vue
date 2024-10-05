<template>
    <div class="container-fluid mt-5">
       <div class="row">
           <div class="col-12">
               <v-text-field label="Title" v-model="title" variant="outlined" aria-required="true"></v-text-field>
           </div>
           <div class="col-12">
               <QuillEditor
                   theme="snow"
                   contentType="html"
                   v-model:content="content"
                   style="height: 170px"
               />
           </div>
           <p></p>
           <div class="col-4">
               <v-file-input
                   v-model="image"
                   label="Main image"
                   accept="image/*"
                   prepend-icon="mdi-camera"
                   @change="previewImage"
                   aria-required="true"
               ></v-file-input>

               <v-img v-if="imagePreview" :src="imagePreview" max-width="300" max-height="300px" class="mt-4"></v-img>
           </div>
           <div class="col-8">
                   <v-file-input
                       v-model="images"
                       label="Other Images can upload multi-images"
                       accept="image/*"
                       prepend-icon="mdi-camera"
                       @change="previewImages"
                       multiple
                       aria-required="true"
                   ></v-file-input>
                <div class="d-flex justify-content-center ga-2">
                    <v-img
                        v-for="(imagePreview, index) in imagePreviews"
                        :key="index"
                        :src="imagePreview"
                        max-width="300" max-height="300px"
                        class="mt-4"
                    ></v-img>
                </div>
           </div>
       </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" @click="addBlog()">Add Blog </button>

        </div>
    </div>
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import axios from "axios";
import {useRouter} from 'vue-router'
import { ref } from 'vue'
import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";
const router = useRouter()
const title = ref(null);
const content = ref(null);
const image = ref(null);
const images = ref(null);

const imagePreview = ref(null)
const imagePreviews = ref([])

const previewImage = () => {
    if (image.value) {
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreview.value = e.target.result
        }
        reader.readAsDataURL(image.value)
    }
}

const previewImages = () => {
    imagePreviews.value = []
    if (images.value && images.value.length) {
        Array.from(images.value).forEach(file => {
            const reader = new FileReader()
            reader.onload = (e) => {
                imagePreviews.value.push(e.target.result)
            }
            reader.readAsDataURL(file)
        })
    }
}
const laravelCookies = CSRF();
const addBlog = async ()=>{
    const formData = new FormData();
    formData.append('title',title.value);
    formData.append('content',content.value);
    if (image.value){
        formData.append('image',image.value);
    }
    if (images.value && images.value.length) {
        Array.from(images.value).forEach((imageFile, index) => {
            formData.append(`images[${index}]`, imageFile);
        });
    }
    await laravelCookies.getCookies();
    url.post('/blogs',formData,{
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
    .then((response)=>{
        router.push({name:'blogs'});
    })
    .catch((error)=>{
        console.log('error on add blog',error)
    });
}
</script>

<style scoped>

</style>
