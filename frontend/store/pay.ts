import { defineStore } from 'pinia';

export const usePayStore = defineStore('payStore', {
    state: () => ({
        pays: null,
        errors: null
    }),
    getters: {
          PAYS(state) {
            return state.pays
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_PAYS() {
            let vm = this;
            await useNuxtApp().$axios.get('/api/paying')
                .then(function(res) {
                  vm.pays = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_PAYS(data){
            return await useNuxtApp().$axios.post('/api/auth/paying', data)

        },

        async GET_PAYS_ITEM(id) {
            return await useNuxtApp().$axios.get(`/api/auth/paying/${id}`)
        },

        async UPDATE_PAYS(data){
            return await useNuxtApp().$axios.put(`/api/auth/paying/${data.id}`, data)

        },

        async DELETE_PAYS(id){
            return await useNuxtApp().$axios.delete(`/api/auth/paying/${id}`)
        },
    },
});