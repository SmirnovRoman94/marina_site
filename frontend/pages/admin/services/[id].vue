<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="8">
        <nuxt-link to="/admin/services" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <h1 class="title">{{service.title}}</h1>
          <div class="mt-5">
            <div class="mt-8">
              <div class="relative max-h-[400px]">
                <img src="../../../assets/image/leaf_2.svg" class="list">
                <img src="../../../assets/image/With_pleasure.svg" class="pleasure">
                <img :src="service.image" :alt="service.title" class="img_post">
              </div>
            </div>
          </div>
          <div class="mt-5 pb-2">
            <h2 class="text-uppercase text-center underline decoration-dotted text-[#50735F] text-lg">ПРЕВЬЮ</h2>
            <p class="text-gray-500 text-sm text-center">{{service.preview}}</p>
          </div>
          <hr>
          <div class="flex mt-5 justify-between pb-2">
            <p><span class="text-gray-700 underline">Формат:</span><span class="text-orange-400">{{' '+service.form}}</span></p>
            <p><span class="text-gray-700 underline">Продолжительность сеанса:</span><span class="text-orange-400">{{' '+service.duration}} минут</span></p>
          </div>
          <hr>
          <div class="mt-5">
            <h2 class="text-uppercase text-center underline decoration-dotted text-[#50735F] text-lg">ОПИСАНИЕ</h2>
            <div class="mt-2" v-html="service.description"></div>
          </div>
          <div class="my-5 flex justify-end">
            <v-btn class="mr-2" color="red-darken-1" @click="deleteItem(service.id)">Удалить</v-btn>
            <v-btn class="mr-2" color="green" @click="editItem">Редактировать</v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useServicesStore } from "@/store/services";
import {onMounted} from "vue";

//STORE
const store = useServicesStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const service = ref({});

onMounted(async() => {
  await store.GET_SERVICE_ITEM(route.params.id)
      .then(res=>{
        console.log(res)
        Object.assign(service.value, res.data.data)
      })
})


async function deleteItem(id){
  await store.DELETE_SERVICE(id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Услуга была успешно удалена' }),
              router.push({path: '/admin/services'}));
        }else{
          snackbar.add({type: 'warning', text: 'Произошла ошибка удаления' })
        }
      })
      .catch(err => {
        console.log(err)
        snackbar.add({type: 'warning', text: err.response.data?.message})
      })
}

function editItem(){
  router.push({path: '/admin/services/edit', query: {id: service.value.id}});
}
</script>

<style scoped>
.title{
  font-size: 48px;
  font-weight: 400;
  color: #50735F;
  text-align: center;
  text-transform: uppercase;
}
.img_post{
  position: relative;
  margin: 0 auto;
  max-height: 400px;
}
.list{
  position: absolute;
  margin-top: -7%;
  z-index: 1;
  width: 30%;
}
.pleasure{
  position: absolute;
  margin-top: -5%;
  margin-left: 35%;
  z-index: 2;
  width: 30%;
}
</style>