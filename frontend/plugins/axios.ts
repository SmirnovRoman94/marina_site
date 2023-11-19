import axios from 'axios';

export default defineNuxtPlugin(async () => {
    const axiosInstance = axios.create({
        baseURL: 'http://127.0.0.1:8000'
    });

    return {
        provide: {
            axios: axiosInstance
        }
    };
});