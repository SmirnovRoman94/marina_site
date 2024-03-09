<template>
  <div class="item_card_text z-10">
    <h5>Пакеты и услуги</h5>
    <div class="content">
      <div v-if="serviceLengt == 0">
        <p class="text_no_service">У Вас пока нет приобретенных пакетов и услуг</p>
      </div>
      <div v-else>
        <div class="flex justify-space-around max-w-[30%] border  border-gray:50 p-2 mt-5">
          <div class="w-2/4 text-center border-r marck-script-regular">Наименование услуги</div>
          <div class="w-2/4 text-center marck-script-regular">Количество</div>
        </div>
        <div v-for="(el, index) in services" class="flex justify-space-around items-end max-w-[30%] border  border-gray:50 p-2">
          <div class="w-2/4 border-r text-center naming">
            {{el.item.title}}
          </div>
          <div class="w-1/4 text-center pl-2">
            <v-text-field v-model="el.count" variant="underlined" density="compact" hide-details type="number"></v-text-field>
          </div>
          <div class="w-1/4 flex justify-end pr-2">
            <v-btn icon="mdi-delete-outline" color="red-lighten-2" height="24" width="24" variant="text" @click.stop="deleteItem(el, index)">
            </v-btn>
          </div>
        </div>
        <div class="mt-2">
          <h2>Итоговая стоимость: <span class="summ">{{summ}}</span> p.</h2>
        </div>
        <div>
          <v-btn class="btn mt-5 z-10" type="submit" @click="byServices">Приобрести</v-btn>
        </div>
      </div>
    </div>

    <!--dialog pay-->
    <DialogPay v-model:open="dialog_pay" @result="resultPay"/>
  </div>
</template>

<script setup>
import {useAuthStore} from "@/store/auth";
import DialogPay from "@/components/DialogPay.vue";

//store
const storeUser = useAuthStore();

const services = ref([]);

const summ = computed(() => {
  let res = 0;
  services.value.forEach(el => {
    res = res+el.item.price;
  });
  return res;
});

const serviceLengt = computed(() => {
  console.log(services.value.length);
  return services.value.length;
})


function deleteItem(el, index){
  services.value.splice(index, 1);
  let servicesString = JSON.stringify(services.value);
  localStorage.setItem('services', servicesString);
}


onMounted(async() => {
  if(localStorage.getItem('services')){
    services.value = JSON.parse(localStorage.getItem('services'));
  }
  await storeUser.GET_USER();
});


//paying
const dialog_pay = ref(false);

function byServices(){
  dialog_pay.value = true;
}

const file = ref(null);

function resultPay(item){
  console.log(item);
  if(item !== null){
    file.value = item;
    dialog_pay.value = false;
    sendPay();
  }else{
    dialog_pay.value = false;
  }
}

const USER = computed(() => storeUser.USER);

function sendPay(){
  console.log(USER.value);

}
</script>

<style scoped>
h5 {
  font-size: 20px;
  text-transform: uppercase;
  font-style: italic;
  color: #50735F;
  font-family: 'Caveat', cursive;
}
h2{
  font-size: 18px;
  text-transform: uppercase;
  font-style: italic;
  color: #e8102d;
  font-family: 'Caveat', cursive;
}
.summ{
  font-size: 24px;
  margin-left: 10px;
}
.text_no_service{
  color: #9a9da1;
  font-family: 'Caveat', cursive;
}
.btn{
  height: 36px !important;
  background-color: #d29953;
  color: #d7d4d6;
  opacity: 1 !important;
  border-radius: 6px;
  cursor: pointer;
}
.naming{
  color: #8f8f93;
  font-family: 'Caveat', cursive;
  font-size: 20px;
}
</style>