<template>
    <div class="container-fluid ">
        <div v-if="loader">loading ...</div>
        <div class="body" v-else>
            <div class="d-flex justify-content-end mt-5 cursor-pointer" @click="$router.push({name:'create-blog'})">
                <button class="btn btn-primary " >Create Blog</button>
            </div>
            <v-row >
                <v-col cols="4" v-for="blog in blogs" :key="blog.id">
                    <v-card
                        :disabled="loading"
                        :loading="loading"
                        class="mx-auto my-12"
                        max-width="374"
                    >
                        <template v-slot:loader="{ isActive }">
                            <v-progress-linear
                                :active="isActive"
                                color="deep-purple"
                                height="4"
                                indeterminate
                            ></v-progress-linear>
                        </template>

                        <v-img
                            height="250"
                            :src="blog.image"
                            cover
                        ></v-img>
                        <v-card-item>
                            <v-card-title>{{blog.title}}</v-card-title>
                        </v-card-item>
                        <v-card-text v-html="blog.content.split(' ').slice(0,20).join(' ') + '...'">
                        </v-card-text>
                        <v-divider class="mx-4 mb-1"></v-divider>

                        <v-card-title>{{blog.title}}</v-card-title>

                        <div class="px-4 mb-2 d-flex justify-content-between" >
                            <v-chip-group v-model="selection" selected-class="bg-deep-purple-lighten-2">
                                <v-chip>{{blog.created_at}}</v-chip>
                            </v-chip-group>
                            <div class="d-flex justify-content-between gap-2">
                                <v-icon color="green" @click="$router.push({name:'edit-blog',params:{id:blog.id,slug:blog.slug}})">mdi-pencil</v-icon> <!-- Edit icon -->
                                <v-icon color="red">mdi-delete</v-icon> <!-- Delete icon -->
                            </div>

                        </div>
                        <v-card-actions>
                            <v-btn
                                color="deep-purple-lighten-2"
                                text="Deteails"
                                block
                                border
                                @click="$router.push({name:'show.blog',params:{slug:blog.slug}})"
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </div>

    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from 'axios'
import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";

const laravelCookies = CSRF();
const loader = ref(false);
const blogs = ref([]);
const allBlogs = async () => {
    loader.value = true;
    try {
        await laravelCookies.getCookies();
        const response = await url.get('/blogs');
        blogs.value = response.data.data.blogs;
    } catch (error) {
        console.log('Error fetching blogs:', error.response ? error.response.data : error.message);
    } finally {
        loader.value = false;
    }
};
onMounted(()=>{
   allBlogs();
});

</script>

<style scoped>

</style>
