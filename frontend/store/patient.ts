import { defineStore } from 'pinia';

export const usePatientStore = defineStore('patientStore', {
    state: () => ({
        patients: null,
        errors: null
    }),
    getters: {
          PATIENTS(state) {
            return state.patients
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_PATIENTS() {
            let vm = this;
            await useNuxtApp().$axios.get('/api/auth/patients')
                .then(function(res) {
                  vm.patients = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_PATIENT(data){
            return await useNuxtApp().$axios.post('/api/auth/patients', data)

        },

        async GET_PATIENT_ITEM(id) {
            return await useNuxtApp().$axios.get(`/api/patients/${id}`)
        },

        async UPDATE_PATIENT(data){
            return await useNuxtApp().$axios.put(`/api/auth/patients/${data.id}`, data)
        },

        async DELETE_PATIENT(id){
            return await useNuxtApp().$axios.delete(`/api/auth/patients/${id}`)
        },
    },
});