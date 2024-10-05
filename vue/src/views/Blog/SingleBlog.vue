<template>
  <div class="container-fluid mt-5">
      <h3>{{blog.title}}</h3>
      <v-carousel
          height="400"
          show-arrows="hover"
          cycle
          hide-delimiter-background

      >
          <v-carousel-item v-for="(slide,index) in blog.images"
              :src="slide"
               :key="index"
              cover
          ></v-carousel-item>
      </v-carousel>
      <p v-html="blog.content"></p>
  </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import {url} from "../../config.js";
import { useRoute } from 'vue-router';
import {CSRF} from "../../stores/CSRF.js";

const blog = ref({});
const route = useRoute();
const laravelCookies = CSRF();
const getItem = async ()=>{
    const slug = route.params.slug;
    await laravelCookies.getCookies();
    const response  = await url.get('/blogs/'+slug);
    blog.value = response.data.data.blog
};
onMounted(()=>{
    getItem();
})

</script>

<style scoped>

</style>
