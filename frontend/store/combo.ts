import { defineStore } from 'pinia';

export const useComboStore = defineStore('comboStore', {
    state: () => ({
        combo: null,
        errors: null
    }),
    getters: {
          COMBO(state) {
            return state.combo
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_COMBO() {
            let vm = this;
            await useNuxtApp().$axios.get('/combo')
                .then(function(res) {
                  vm.combo = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_COMBO({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            form.append('old_price', data.old_price);
            form.append('discount', data.discount);
            form.append('time_discount', data.time_discount);
            form.append('level', data.level);
            form.append('count_level', data.count_level);
            for (let i = 0; i < data.services.length; i++) {
                let object = data.services[i];
                // Преобразуем объект в строку JSON
                let jsonData = JSON.stringify(object);
                // Добавляем строку JSON в форму с помощью метода append()
                form.append('services[]', jsonData);
            }
            return await useNuxtApp().$axios.post('/auth/combo', form)

        },

        async GET_COMBO_ITEM(id) {
            return await useNuxtApp().$axios.get(`/combo/${id}`)
        },

        async UPDATE_COMBO({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            form.append('old_price', data.old_price);
            form.append('discount', data.discount);
            form.append('time_discount', data.time_discount);
            form.append('level', data.level);
            form.append('count_level', data.count_level);
            for (let i = 0; i < data.services.length; i++) {
                let object = data.services[i];
                // Преобразуем объект в строку JSON
                let jsonData = JSON.stringify(object);
                // Добавляем строку JSON в форму с помощью метода append()
                form.append('services[]', jsonData);
            }
            return await useNuxtApp().$axios.post(`/auth/combo/edit/${data.id}`, form)

        },

        async DELETE_COMBO(id){
            return await useNuxtApp().$axios.delete(`/auth/combo/${id}`)
        },
    },
});