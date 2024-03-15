import { defineStore } from 'pinia';

export const useMailStore = defineStore('mailStore', {
    state: () => ({
        errors: null
    }),
    getters: {
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async SEND_MAIL(data){
            let form = new FormData();
            form.append('email', data.mail);
            form.append('name', data.name);
            return await useNuxtApp().$axios.post('/email', form)
        },
    },
});