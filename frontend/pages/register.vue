<template>
  <v-row>
    <v-col cols="12" md="4">
      <v-form fast-fail @submit.prevent="registr" ref="form" >
        <v-text-field
            v-model="user.name"
            placeholder="Ваше имя"
            :rules="nameRules"
            required
        ></v-text-field>
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
        <v-text-field
            v-model="confirmPassword"
            placeholder="Повторите пароль"
            :rules="confirmRules"
            required
        ></v-text-field>
        <v-btn type="submit" block class="mt-2 mb-1">Submit</v-btn>
      </v-form>
    </v-col>
  </v-row>
</template>

<script setup>
import {useAuthStore} from "../store/auth";
import {watch} from "vue";
const storeAuth = useAuthStore();
const snackbar = useSnackbar();
const router = useRouter();
const confirmPassword = ref('');

const user = reactive({
  name: '',
  email: '',
  password: ''
});
//RULES
const nameRules = [
  value => {
    if(value) return true
    return  'Поле обязательно для заполнения'
  },
  value => {
    if(value?.length >= 3) return true
    return  'Имя должно содержать более 3 символов'
  }
];
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
const confirmRules = [
  value => {
    if (value) return true
    return 'Поле обязательно для заполнения'
  },
  value => {
    if (value === user.password) return true
    return 'Пароли не совпадают'
  },
];



const form = ref(null);
async function registr(){
  const { valid } = await form.value.validate()
  if(valid){
    await storeAuth.GET_REGISTER(user)
  }
}

const token = computed(() => storeAuth.token);
const USER = computed(() => storeAuth.user);
const ERROR = computed(() => storeAuth.error);

watch(USER, (val) => {
  if(val && token !== null){
    snackbar.add({type: 'success', text: `Вы зарегестрированы. Добро пожаловать, ${USER.value.role === 1 ? 'администратор' : 'пользователь'} ${USER.value.name}` });
    if(USER.value.role === 1){
      router.push('/admin')
    }else{
      router.push('/profile')
    }
  }
});
watch(ERROR, (val) => {
  if(val === true){
    snackbar.add({type: 'warning', text: 'Произошла ошибка регистрации' })
  }
});
</script>

<style scoped>

</style>