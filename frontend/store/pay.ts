import { defineStore } from 'pinia';
import {param} from "ts-interface-checker";

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
        async GET_PAYS(filter) {
            let vm = this;
            console.log(filter)
            await useNuxtApp().$axios.get('/paying', {
                params: {params: filter}
            })
                .then(function(res) {
                  vm.pays = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async GET_PAYS_SYNC(filter) {
            return await useNuxtApp().$axios.get('/paying', {
                params: {params: filter}
            })
        },
        async SAVE_PAYS(data){
            return await useNuxtApp().$axios.post('/auth/paying', data)

        },

        async GET_PAYS_ITEM(id) {
            return await useNuxtApp().$axios.get(`/auth/paying/${id}`)
        },

        async UPDATE_PAYS(data){
            return await useNuxtApp().$axios.put(`/auth/paying/${data.id}`, data)

        },

        async DELETE_PAYS(id){
            return await useNuxtApp().$axios.delete(`/auth/paying/${id}`)
        },
    },
});