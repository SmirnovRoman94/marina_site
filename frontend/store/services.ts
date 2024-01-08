import { defineStore } from 'pinia';

export const useServicesStore = defineStore('servicesStore', {
    state: () => ({
        services: null,
        errors: null
    }),
    getters: {
          SERVICES(state) {
            return state.services
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_SERVICES() {
            let vm = this;
            await useNuxtApp().$axios.get('/api/auth/services')
                .then(function(res) {
                  vm.services = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_SERVICE({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('description', data.description);
            form.append('title', data.title);
            form.append('price', data.price);
            form.append('form', data.form);
            form.append('preview', data.preview);
            form.append('duration', data.duration);
            return await useNuxtApp().$axios.post('/api/auth/services', form)

        },

        async GET_SERVICE_ITEM(id) {
            return await useNuxtApp().$axios.get(`/api/auth/services/${id}`)
        },

        async UPDATE_SERVICE({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('description', data.description);
            form.append('title', data.title);
            form.append('price', data.price);
            form.append('form', data.form);
            form.append('preview', data.preview);
            form.append('duration', data.duration);
            return await useNuxtApp().$axios.post(`/api/auth/services/edit/${data.id}`, form)

        },

        async DELETE_SERVICE(id){
            return await useNuxtApp().$axios.delete(`/api/auth/services/${id}`)
        },
    },
});