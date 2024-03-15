import { defineStore } from 'pinia';

export const useDiplomsStore = defineStore('diplomsStore', {
    state: () => ({
        diploms: null,
        errors: null
    }),
    getters: {
          DIPLOMS(state) {
            return state.diploms
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_DIPLOMS() {
            let vm = this;
            await useNuxtApp().$axios.get('/diploms')
                .then(function(res) {
                  vm.diploms = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_DIPLOM({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            return await useNuxtApp().$axios.post('/auth/diploms', form)

        },

        async GET_DIPLOM_ITEM(id) {
            return await useNuxtApp().$axios.get(`/diploms/${id}`)
        },

        async UPDATE_DIPLOM({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            return await useNuxtApp().$axios.post(`/auth/diploms/edit/${data.id}`, form)

        },

        async DELETE_DIPLOM(id){
            return await useNuxtApp().$axios.delete(`/auth/diploms/${id}`)
        },
    },
});