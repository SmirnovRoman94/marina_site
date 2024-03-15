import { defineStore } from 'pinia';

export const usePostStore = defineStore('postStore', {
    state: () => ({
        posts: null,
        errors: null
    }),
    getters: {
          POSTS(state) {
            return state.posts
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_POSTS() {
            let vm = this;
            await useNuxtApp().$axios.get('/posts')
                .then(function(res) {
                  vm.posts = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_POST({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            form.append('text', data.text);
            form.append('preview', data.preview);
            return await useNuxtApp().$axios.post('/auth/posts', form)

        },

        async GET_POST_ITEM(id) {
            return await useNuxtApp().$axios.get(`/posts/${id}`)
        },

        async UPDATE_POST({data, file}){
            let form = new FormData();
            form.append('img', file);
            form.append('title', data.title);
            form.append('text', data.text);
            form.append('preview', data.preview);
            return await useNuxtApp().$axios.post(`/auth/posts/edit/${data.id}`, form)

        },

        async DELETE_POST(id){
            return await useNuxtApp().$axios.delete(`/auth/posts/${id}`)
        },
    },
});