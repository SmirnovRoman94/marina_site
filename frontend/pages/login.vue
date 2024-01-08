<template>
<v-row>
  <v-col cols="12" md="4">
    <v-form fast-fail @submit.prevent="Onlogin" ref="form">
      <v-text-field
          v-model="user.email"
          placeholder="Ваш email"
          :rules="emailRules"
          required
      ></v-text-field>
      <v-text-field
          v-model="user.password"
          placeholder="Ваш пароль"
          :rules="passwordRules"
          required
      ></v-text-field>
      <v-btn type="submit" block class="mt-2">Submit</v-btn>
    </v-form>
    <div class="mt-5">
      <v-btn color="primary">
        <nuxt-link to="/register">Зарегестрироваться</nuxt-link>
      </v-btn>
    </div>
  </v-col>
</v-row>
</template>

<script setup>
import {useAuthStore} from "../store/auth";
import {watch} from "vue";

const snackbar = useSnackbar();
const storeAuth = useAuthStore();


const user = reactive({
  email: 'admin@mail.com',
  password: '123123123'
});

const emailRules = [
  value => {
    if (value) return true
    return 'Поле обязательно для заполнения'
  },
  value => {
    if (/.+@.+\..+/.test(value)) return true
    return 'Введен неккоректный email'
  },
];
const passwordRules = [
  value => {
    if (value) return true
    return 'Поле обязательно для заполнения'
  },
  value => {
    if (value?.length >= 8) return true
    return 'Пароль должен содержать более 8 символов'
  },
];


async function  Onlogin(){
  await storeAuth.GET_AUTHENTICATE(user)
}

const token = computed(() => storeAuth.token);
const USER = computed(() => storeAuth.user);
const ERROR = computed(() => storeAuth.error);

watch(USER, (val) => {
  if(val && token !== null){
    snackbar.add({type: 'success', text: `Вы зарегестрированы. Добро пожаловать, ${USER.value.role === 1 ? 'администратор' : 'пользователь'} ${USER.value.name}` });
    navigateTo('/');
  }
});
watch(ERROR, (val) => {
  if(val == true){
    snackbar.add({type: 'warning', text: 'Произошла ошибка регистрации' })
  }
});
</script>

<style scoped>

</style>