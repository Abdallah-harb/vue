<template>
    <div class="container-fluid">
        <div class="" v-if="user">
            <h2>Dashboard</h2>
            <h2 >Welcome , {{user.name}}</h2>
        </div>
        <div class="text-danger" v-else> {{errors}}</div>

    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
 import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";
 const user = ref({
     name:''
 });
 const laravelCookies = CSRF();
 const errors = ref(null);
 const getUser = async ()=>{
   //  console.log( laravelCookies.getCookies())
     try {
        await laravelCookies.getCookies();
         const response = await url.get('/user');
         user.value = response.data.data.user;
     } catch (error) {
         console.error(error);
     }
 }
 onMounted(()=>{
     getUser();
 })
</script>

<style scoped>

</style>
