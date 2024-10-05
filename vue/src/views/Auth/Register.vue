<template>
    <v-card
        class="mx-auto mt-10 bg-dark-subtle text-center "
        max-width="500"
        title="User Registration"
    >
        <v-container>
            <v-text-field
                v-model="form.name"
                color="primary"
                label="name"
                variant="underlined"
            ></v-text-field>
            <span class="text-danger" v-if="errors.name">
                {{errors.name[0]}}
            </span>
            <v-text-field
                v-model="form.email"
                color="primary"
                label="Email"
                variant="underlined"
            ></v-text-field>
            <span class="text-danger" v-if="errors.email">
                {{errors.email[0]}}
            </span>
            <v-text-field
                v-model="form.password"
                color="primary"
                label="Password"
                type="password"
                placeholder="Enter your password"
                variant="underlined"
            ></v-text-field>
            <span class="text-danger" v-if="errors.password">
                {{errors.password[0]}}
            </span>
            <v-text-field
                v-model="form.password_confirmation"
                color="primary"
                type="password"
                label="Password Confirmation"
                placeholder="Enter your password Again"
                variant="underlined"
            ></v-text-field>
            <span class="text-danger" v-if="errors.password_confirmation">
                {{errors.password_confirmation[0]}}
            </span>
        </v-container>
        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success" @click="register()">
               Submit
            </v-btn>
        </v-card-actions>
    </v-card>

</template>

<script setup>
import { ref } from 'vue'
import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";
import {useRouter} from "vue-router";

const form = ref({
    name:"",
    email:"",
    password:"",
    password_confirmation:""
})
const errors = ref([]);
const laravelCookies = CSRF();
const router = useRouter();

const register =async ()=>{
    await laravelCookies.getCookies();
    url.post('/auth/register',form.value)
        .then((response)=>{
            localStorage.setItem('auth', 'true');
            router.push({ name: 'home' }).then(() => {
                window.location.reload();
            });
        })
        .catch((error)=>{
            errors.value = error.response.data.errors;
    });
}

</script>

<style scoped>

</style>
