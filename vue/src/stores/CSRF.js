import {defineStore} from "pinia";
import Cookie from 'js-cookie';
import {url} from "../config.js";
export const CSRF = defineStore('csrf',{
    actions :{
        async getCookies(){
            try {
                const token = Cookie.get('XSRF-TOKEN');
                if (token){
                    return new Promise (resolve => {
                        resolve(token);
                    })
                }
                await url.get('/csrf-cookie');
            }catch (e) {
                console.log('error on get cookies',e);
            }
        }
    }
});
