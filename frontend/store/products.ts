import { defineStore } from 'pinia';

export const useProductsStore = defineStore('productsStore', {
    state: () => ({
        products: null,
        errors: null
    }),
    getters: {
          PRODUCTS(state) {
            return state.products
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_PRODUCTS() {
            let vm = this;
            await useNuxtApp().$axios.get('/api/products')
                .then(function(res) {
                  vm.products = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_PRODUCTS({data, file}){
            let form = new FormData();
            form.append('media', file);
            form.append('title', data.title);
            form.append('description', data.description);
            form.append('price', data.price);
            return await useNuxtApp().$axios.post('/api/auth/products', form)

        },

        async GET_PRODUCTS_ITEM(id) {
            return await useNuxtApp().$axios.get(`/api/products/${id}`)
        },

        async UPDATE_PRODUCTS({data, file}){
            let form = new FormData();
            form.append('id', data.id);
            form.append('media', file);
            form.append('title', data.title);
            form.append('description', data.description);
            form.append('price', data.price);
            return await useNuxtApp().$axios.post(`/api/auth/products/edit/${data.id}`, form)

        },

        async DELETE_PRODUCTS(id){
            return await useNuxtApp().$axios.delete(`/api/auth/products/${id}`)
        },
    },
});