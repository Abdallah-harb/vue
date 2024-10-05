<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" v-if="isAuth">
                    <li class="nav-item">
                        <a class="nav-link text-white cursor-pointer" @click="$router.push('/')">Home</a>
                    </li>
                    <li class="nav-item text-white" v-if="isAuth">
                        <a class="nav-link text-white cursor-pointer" @click="$router.push('/blogs')">Blogs</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item" v-if="!isAuth" >
                        <a class="nav-link text-white cursor-pointer"  @click="$router.push('/auth/login')">Login </a>
                    </li>
                        <li class="nav-item" v-if="isAuth">
                            <a class="nav-link text-white cursor-pointer" @click.prevent="logout()">Logout </a>
                        </li>
                    <li class="nav-item text-white" v-if="!isAuth" >
                        <a class="nav-link text-white cursor-pointer" @click.prevent="$router.push('/auth/register')">Register</a>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {onMounted, ref} from 'vue'

import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";
import {useRouter} from "vue-router";

const isAuth =ref(false);

const laravelCookies = CSRF();
const router = useRouter();
const logout = async ()=>{
    await laravelCookies.getCookies();
     url.post('/auth/logout')
        .then((response)=>{
            if (response.status === 200) {
                localStorage.removeItem('auth');
                router.push({name: 'login'}).then(() => {
                    window.location.reload();
                });
            }
        })
        .catch((error)=>{
            console.log(error);
        })
}
onMounted(()=>{
    isAuth.value = !!localStorage.getItem('auth');
})

</script>

<style scoped>
.navbar{
    background-color: #000041 !important;
    color: white;
}


</style>
