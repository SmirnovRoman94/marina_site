import axios from 'axios';
import {useAuthStore} from "@/store/auth";

export default defineNuxtPlugin(async () => {
    const authStore = useAuthStore();
    const router = useRouter();
    const api = axios.create({
        baseURL: 'http://localhost:8000/api',
        // baseURL: 'https://34fih34j.org/api',
        withCredentials: true,
        withXSRFToken: true,
    });
    //start request
    api.interceptors.request.use(config => {
        if(localStorage.access_token){
            config.headers.authorization = `Bearer ${localStorage.access_token}`
        }
        return config
    }, (error) => {
        return Promise.reject(error);
    });
    //end request
    api.interceptors.response.use(config => {
        if(localStorage.access_token){
            config.headers.authorization = `Bearer ${localStorage.access_token}`
        }
        return config
    },  function (error)  {
        console.log(error.response)
        if(error.response.data.message === 'Token has expired'){
            axios.post('api/auth/refresh', {}, {
                headers: {
                    'authorization': `Bearer ${localStorage.access_token}`
                }
            })
                .then(res => {
                    localStorage.access_token = res.data.access_token;
                    error.config.headers.authorization = `Bearer ${localStorage.access_token}`
                    window.location.reload();
                    return api.request(error.config)
                })
                .catch(err => {
                    console.log(err)
                    if(err.response.data.message == 'The token has been blacklisted'){
                        localStorage.removeItem('access_token')
                    }
                })
        }
        if(error.response.data.message === 'Request failed with status code 401'){
            router.push('/login');
            document.cookie = `token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
            authStore.authenticated = false;
            authStore.user = null;
            authStore.isAdmin = 0;
            authStore.logout = true;
            localStorage.removeItem('access_token');
            localStorage.removeItem('role');
        }
        if(error.response.data.message === 'Unauthenticated.'){
            router.push('/login');
            document.cookie = `token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
            authStore.authenticated = false;
            authStore.user = null;
            authStore.isAdmin = 0;
            authStore.logout = true;
            localStorage.removeItem('access_token');
            localStorage.removeItem('role');
        }
        return Promise.reject(error);
    });

    return {
        provide: {
            axios: api
        }
    }



    // const axiosInstance = axios.create({
    //     baseURL: 'http://localhost:8000',
    //     withCredentials: true,
    //     withXSRFToken: true,
    //     headers: {
    //         'au'
    //     }
    // });
    //
    // return {
    //     provide: {
    //         axios: axiosInstance
    //     }
    // };
});