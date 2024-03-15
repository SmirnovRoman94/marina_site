import { defineStore } from 'pinia';

export const useCommentStore = defineStore('commentStore', {
    state: () => ({
        comments: null,
        errors: null
    }),
    getters: {
          COMMENTS(state) {
            return state.comments
          },
          ERRORS(state){
              return state.errors
          }
    },
    actions: {
        async GET_COMMENTS() {
            let vm = this;
            await useNuxtApp().$axios.get('/comments')
                .then(function(res) {
                  vm.comments = res.data;
                })
                .catch(function (err){
                    vm.errors = err
                })
        },
        async SAVE_COMMENT(data){
            return await useNuxtApp().$axios.post('/auth/comments', data)

        },

        async DELETE_COMMENT(id){
            return await useNuxtApp().$axios.delete(`/auth/comments/${id}`)
        },
    },
});