<template>
<v-footer>
  <img src="../assets/image/Frame_2060.png" class="frame">
  <div class="content flex items-start justify-between  w-[90%] pt-3 px-[56px]" >
<!--    <v-btn class="mx-4" icon="mdi-instagram" variant="text"></v-btn>-->
    <div class="max-w-sm">
      <h3 class="text-uppercase text-sm">Подпишись на наш сайт и получи скидку 10% на первую консультацию</h3>
      <v-form class="form w-[300px] z-10 top-16" @submit.prevent="send" ref="form">
        <v-text-field class="some-style" label="Ваше имя" density="compact" variant="underlined" v-model="user.name" :rules="[(v) => !!v || 'Поле Имя не заполнено']"></v-text-field>
        <v-text-field class="some-style" type="email" label="Ваш email" density="compact" variant="underlined" v-model="user.mail" :rules="[(v) => !!v || 'Поле email не заполнено']"></v-text-field>
        <v-btn class="btn mt-2" type="submit">Я в деле</v-btn>
      </v-form>
      <div class="reserved bottom-5 position-absolute z-10">
        Marina site 2023 © All Rights reserved
      </div>
    </div>
    <div class="items">
      <h3>SITEMAP</h3>
      <div class="text-sm py-1"><NuxtLink to="/">Главная</NuxtLink></div>
      <div class="text-sm py-1"><NuxtLink to="/about">Пакеты</NuxtLink></div>
      <div class="text-sm py-1"><NuxtLink to="/public">Блог</NuxtLink></div>
    </div>
  </div>

  <img src="../assets/image/Group_2075.png" class="group">
  <img src="../assets/image/Group_2077.png" class="group_two">
  <img src="../assets/image/UP.png" class="up">
</v-footer>
</template>

<script setup>
import {useMailStore} from "../store/mail";
const snackbar = useSnackbar();

const store = useMailStore();

const user  = reactive({
  name: "Roman",
  mail: "smirnow3217831@gmail.com"
});


const form = ref(null);
async function send(){
  const { valid } = await form.value.validate()
  if(valid){
    await store.SEND_MAIL(user)
        .then(res => {
          if(res.data.mess === 1){
            (snackbar.add({type: 'success', text: 'Письмо со скидкой успешно отправлено' }),
                reset())
          }else{
            snackbar.add({type: 'warning', text: 'Произошла ошибка при отправлении. Повторите еще раз.' })
          }
        })
        .catch(err => {
          console.log(err)
          snackbar.add({type: 'warning', text: err.response.data?.message})
        })
  }
}

function reset(){
  Object.assign(diplom, {name: null,mail: null});
}
</script>

<style scoped lang="scss">
.v-footer {
  background-color: #50735F !important;
  min-height: 300px;
  position: fixed;
  bottom: 0;
  width: 100%;
  display: flex;
  flex-direction: column;
  color: #d7d4d6;
  z-index: 10;
}
.frame {
  left: 0;
  position: fixed;
  margin-top: -10px;
}
.group {
  position: fixed;
  bottom: 0;
}
.group_two{
  position: fixed;
  right: 0;
  margin-top: 30px;
}
.up{
  position: fixed;
  right: 20px;
  bottom: 20px;
  transition: all .5s ease;
  cursor: pointer;
}
.up:hover{
  transform: scale(1.05);
}

.btn{
  height: 36px !important;
  background-color: #C58A46;
  color: #d7d4d6;
  opacity: 1 !important;
  border-radius: 6px;
  cursor: pointer;
}

.form{
  margin-top: 20px;
}

@media (max-width: 650px) {
  .form{
    margin-top: 5px;
  }
  .items {
    display: flex;
    position: absolute;
    align-items: center;
    z-index: 10;
    bottom: 50px;
    div {
      margin-right: 5px;
      margin-left: 5px;
      text-transform: uppercase;
      border-bottom: 1px solid #d7d4d6;
    }
  }
  .reserved {
    font-size: 14px;
  }
  h3{
    font-size: 12px !important;
  }
  .content{
    padding-left: 28px;
    padding-right: 28px;
  }
}
</style>