<template>
    <v-card
        class="mx-auto mt-10 bg-dark-subtle text-center "
        max-width="500"
        title="User Login"
    >
        <v-container>
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
        </v-container>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="success" @click="login()">
                Submit
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import axios from "axios";
import {url} from "../../config.js";
import {CSRF} from "../../stores/CSRF.js";
import {useRouter} from "vue-router";
import {ref} from "vue";


const form = ref({
    email:"",
    password :""
});
const errors = ref([]);
const laravelCookies = CSRF();
const router = useRouter();

const login = async () => {
    await laravelCookies.getCookies();
     url.post('/auth/login', form.value)
        .then((response) => {
            localStorage.setItem('auth', 'true');
            router.push({ name: 'home' }).then(() => {
                window.location.reload();
            });
        })
        .catch((errors) => {
            errors.value = errors.response.data.errors;
        });
}
</script>

<style scoped>

</style>
