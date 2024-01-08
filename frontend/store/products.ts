import { defineStore } from 'pinia';

export const useProductsStore = defineStore('productsStore', {
    state: () => ({
        products: null,
        errors: null
    }),
    getters: {
          POSTS(state) {
            return state.products
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_POSTS() {
            let vm = this;
            await useNuxtApp().$axios.get('/api/auth/posts')
                .then(function(res) {
                  vm.products = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_POST({data, file}){
            let form = new FormData();
            for (let i = 0; i < file.length; i++) {
                form.append('img', file[i]);
            }
            form.append('title', data.title);
            form.append('description', data.text);
            return await useNuxtApp().$axios.post('/api/product', form)

        },

        async GET_PRODUCT(id){
            return await useNuxtApp().$axios.get(`/api/product/${id}`)
        },
    },
});