<template>
<v-dialog persistent content-class="dialog_item" v-model="dialog" width="500">
  <v-card class="card">
    <v-card-title class="d-flex justify-space-between align-center">
      <h5 class="caveat">ДАННЫЕ ДЛЯ ОПЛАТЫ</h5>
      <v-btn @click="close" class="ma-2 ml-2" variant="text" icon max-height="32" max-width="32">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-card-title>
    <v-card-text>
      <div class="container_image">
        <img src="../assets/image/oduvan.png">
      </div>
      <p class="marck-script-regular text-justify py-4">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
        Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона,
        а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации
        "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..".</p>
      <hr>
      <div class="mt-3 pb-4">
        <div class="flex justify-space-between">
          <p class="marck-script-regular text-[#C58A46] text-sm">Название банка</p>
          <p class="font-light">{{PAYS.name_bank}}</p>
        </div>
        <div class="flex justify-space-between mt-3">
          <p class="marck-script-regular text-[#C58A46] text-sm">Номер карты</p>
          <p class="font-light">{{PAYS.number}}</p>
        </div>
        <div class="flex justify-space-between mt-3">
          <p class="marck-script-regular text-[#C58A46] text-sm">ФИО получателя</p>
          <p class="font-light">{{PAYS.surname}} {{PAYS.name}} {{PAYS.patromic}}</p>
        </div>
      </div>
      <hr>
      <v-form @submit.prevent="addPay" ref="form" class="mt-1">
        <v-file-input v-model="file" variant="underlined" placeholder="Прикрепить чек" :rules="[(v) => !!v || 'Поле Чек об оплате обязательно для заполнения']"/>
        <div class="mt-5 flex justify-end">
          <v-btn type="submit" class="ma-2 mr-2" variant="text">Отправить</v-btn>
          <v-btn @click="close" class="ma-2 mr-2" variant="text">Закрыть</v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</v-dialog>
</template>

<script setup>
import { usePayStore } from "@/store/pay";
//store
const store = usePayStore();

const props = defineProps({
  open: {type: Boolean}
});

const emits = defineEmits(['update:open', 'result']);

const dialog = ref(false);
const snackbar = useSnackbar();

function close(){
  emits('update:open', false);
}

const file = ref(null);

const form = ref(null);

async function addPay(){
  const { valid } = await form.value.validate();
  if(valid){
    emits('result', file.value[0]);
  }else{
    snackbar.add({type: 'warning', text: 'Необходимо добавить чек об оплате' });
  }
}

const PAYS = ref([]);

watchEffect(() => {
  dialog.value = props.open;
  if(props.open === true){
     store.GET_PAYS_SYNC(1)
         .then(res => {
           console.log(res)
           PAYS.value = res.data[0];
         })
  }
});

</script>

<style scoped>
.card{
  background: #F4F3F0;
  color: #50735F;
}
.container_image{
  width: 100%;
  height: 200px;
  overflow: hidden;
}
img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>