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
            await useNuxtApp().$axios.get('/auth/patients')
                .then(function(res) {
                  vm.patients = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_PATIENT({data, file}){
            let form = new FormData();
            form.append('file_check', file);
            form.append('user_id', data.user_id);
            if (data.service_combo) {
                form.append('service_combo', JSON.stringify(data.service_combo));
            }
            if (data.services) {
                form.append('services', JSON.stringify(data.services));
            }
            if (data.products) {
                form.append('products', JSON.stringify(data.products));
            }
            return await useNuxtApp().$axios.post('/patients', form)
        },

        async GET_PATIENT_ITEM(id) {
            return await useNuxtApp().$axios.get(`/patients/${id}`)
        },

        async UPDATE_PATIENT(data){
            return await useNuxtApp().$axios.put(`/auth/patients/${data.id}`, data)
        },

        async DELETE_PATIENT(id){
            return await useNuxtApp().$axios.delete(`/auth/patients/${id}`)
        },

        async GET_PATIENT_ITEM_FOR_USER(id){
            return await useNuxtApp().$axios.get(`/patients/user/${id}`)
        }
    },
});