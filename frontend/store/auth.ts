import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        user: null,
        error: null,
        logout: false,
        token: null,
        isAdmin: 0
    }),
    getters: {
      USER(state) {
        return state.user
      }
    },
    actions: {
        async GET_REGISTER(item) {
            let vm = this;
            await useNuxtApp().$axios.post('/register', item)
                .then(function(res) {
                  if(res.data?.mess === 2){
                      vm.token = res.data?.access_token
                      vm.authenticated = true;
                      vm.logout = false;

                      const expirationTime = new Date(new Date().getTime() + 4 * 60 * 60 * 1000).toUTCString();
                      document.cookie = `token=${res.data?.access_token}; expires=${expirationTime}; path=/`;
                      localStorage.access_token = res.data?.access_token

                      vm.GET_USER();
                  }  else{
                      vm.error = res.data
                  }
                })
                .catch(function (err){
                    vm.error = err
                })
        },
        async GET_AUTHENTICATE(item){
            let vm = this;
            await useNuxtApp().$axios.post('/auth/login', item)
                .then(function(res) {
                    const expirationTime = new Date(new Date().getTime() + 4 * 60 * 60 * 1000).toUTCString();
                    document.cookie = `token=${res.data?.access_token}; expires=${expirationTime}; path=/`;
                    localStorage.access_token = res.data?.access_token;


                    vm.authenticated = true;
                    vm.token = res.data?.access_token;
                    vm.logout = false;
                    vm.GET_USER();
                })
                .catch(function (err){
                    vm.error = err
                })
        },
        async GET_USER(){
            let vm = this;
            await useNuxtApp().$axios.post('/auth/me')
                .then(function(res) {
                    if(res.data){
                        vm.user = res.data
                        localStorage.role = res.data?.role
                    }  else{
                        vm.error = res.data
                    }
                })
                .catch(function (err){
                    vm.error = err
                })
        },

        async GET_LOGOUT(){
            let vm = this;
            await useNuxtApp().$axios.post('/auth/logout')
                .then(function(res) {
                    console.log(res)
                    if(res.data?.message === 'Successfully logged out'){
                        vm.user =  null;
                        vm.authenticated = false;
                        vm.isAdmin = 0;
                        vm.logout = true;
                        document.cookie = `token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('role');
                    }
                })
                .catch(function (err){
                    vm.error = err
                })
        }

    },
});