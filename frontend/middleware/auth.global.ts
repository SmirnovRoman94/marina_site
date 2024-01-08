import { storeToRefs } from 'pinia';
import { useAuthStore } from '../store/auth';


export default defineNuxtRouteMiddleware((to, from) => {
    if (process.server) return;

    const { authenticated } = storeToRefs(useAuthStore());
    // let token = localStorage.access_token;
    let token = checkTokenInCookie();

    console.log(token, authenticated.value, to ,from);

    if (token) {
        authenticated.value = true; // update the state to authenticated
    }else{
        authenticated.value = false;
    }

    if (token && to?.name === 'login') {
        return navigateTo('/');
    }

    if(token == undefined && to.path.startsWith("/admin")){
        abortNavigation();
        return navigateTo('/login');
    }

    // if ((token == undefined && to?.name == 'admin') || (token == undefined && to?.name == 'admin/private')) {
    //     abortNavigation();
    //     return navigateTo('/login');
    // }

});

function checkTokenInCookie() {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith('token=')) {
            return true;
        }
    }
    return false;
}