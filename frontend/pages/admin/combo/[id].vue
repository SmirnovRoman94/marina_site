<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="8" >
        <nuxt-link to="/admin/combo" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5 position-relative max-w[800px]">
          <v-img class="img" :src="combo.image" cover :aspect-ratio="16/9"/>
          <div class="content">
            <div class="flex justify-end">
              <v-img src="../../../assets/image/heart.svg" class="heart"/>
            </div>
            <h2 class="text-[#50735F] text-uppercase font-weight-bold text-4xl text-center caveat">{{combo.title}}</h2>
            <div class="mt-5">
              <h5 class="text-[#C58A46] font-thin text-xl text-uppercase">Услуги которые входят в данный пакет:</h5>
              <ul class="mt-5 dotted-list">
                <li v-for="(item, index) in combo.services" :key="index" class="list_item">
                  <h6 class="text-[#C58A46] font-thin text-sm text-uppercase">{{item.title}}</h6>
                  <div class="text-[#50735F] font-thin text-sm pl-4 pt-4" v-html="item.description"></div>
                </li>
                <div>
                  <img src="../../../assets/image/list_punkt.svg" class="list">
                </div>
              </ul>
            </div>
          </div>
        </div>
        <div class="my-5 flex justify-end">
          <v-btn class="mr-2" color="red-darken-1" @click="deleteItem(combo.id)">Удалить</v-btn>
          <v-btn class="mr-2" color="green" @click="editItem">Редактировать</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useComboStore } from "@/store/combo";
import {onMounted} from "vue";

//STORE
const store = useComboStore();
const route = useRoute();
const router = useRouter();

const combo = ref({});

onMounted(async() => {
  await store.GET_COMBO_ITEM(route.params.id)
      .then(res=>{
        console.log(res)
        Object.assign(combo.value, res.data.data)
      })
});

async function deleteItem(id){
  await store.DELETE_COMBO(id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Пакет был успешно удален' }),
              router.push({path: '/admin/combo'}));
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
  router.push({path: '/admin/combo/edit', query: {id: combo.value.id}});
}
</script>

<style scoped>
.content{
  margin-top: -20px;
  border-radius: 14px;
  background: white;
  width: 100%;
  padding: 16px;
  position: relative;
  height: content-box;
}
.img{
  height: auto;
  max-width: 800px;
  max-height: 400px;
  position: relative;
}
.caveat{
  font-family: "Caveat", cursive;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
}
.list{
  margin-left: -25px;
  margin-top: 6px;
}
ul.dotted-list {
  list-style: none;
  padding-left: 20px;
}

ul.dotted-list li {
  position: relative;
  padding-bottom: 10px;
}

ul.dotted-list li::before {
  content: "";
  position: absolute;
  top: 5px;
  left: -15px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #50735F;
}

ul.dotted-list li::after {
  content: "";
  position: absolute;
  top: 15px;
  left: -11px;
  height: calc(100% - 10px);
  border-left: 3px dashed rgba(80, 115, 95, 0.49);
}
.heart{
  width: 30px;
  position: absolute;
}
</style>