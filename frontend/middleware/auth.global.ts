import { storeToRefs } from 'pinia';
import { useAuthStore } from '../store/auth';


export default defineNuxtRouteMiddleware((to, from) => {
    if (process.server) return;

    const { authenticated, isAdmin } = storeToRefs(useAuthStore());
    let admin = localStorage.role;
    let token = checkTokenInCookie();

    console.log(token, authenticated.value, to ,from);

    if (token) {
        authenticated.value = true; // update the state to authenticated
        if(admin == 1){
            isAdmin.value = 1
        }
    }else{
        authenticated.value = false;
        isAdmin.value = 0;
        localStorage.removeItem('access_token')
        localStorage.removeItem('role');
        if (window.location.pathname !== '/') {
            window.location.pathname = '/';
        }
    }

    if (token && to?.name === 'login') {
        return navigateTo('/');
    }

    if(!token && to.path.startsWith("/admin")){
        abortNavigation();
        return navigateTo('/login');
    }



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