<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/diploms" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <h1 class="title">{{diplom.title}}</h1>
          <div class="mt-5">
            <img :src="diplom.image" :alt="diplom.title" class="img_post">
          </div>
        </div>
        <div class="my-5 flex justify-end">
          <v-btn class="mr-2" color="red-darken-1" @click="deleteItem(diplom.id)">Удалить</v-btn>
          <v-btn class="mr-2" color="green" @click="editItem">Редактировать</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useDiplomsStore } from "@/store/diploms";
import {onMounted} from "vue";

//STORE
const store = useDiplomsStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const diplom = ref({});

onMounted(async() => {
  await store.GET_DIPLOM_ITEM(route.params.id)
      .then(res=>{
        console.log(res)
        Object.assign(diplom.value, res.data.data)
      })
});

async function deleteItem(id){
  await store.DELETE_DIPLOM(id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Диплом был успешно удален' }),
              router.push({path: '/admin/diploms'}))
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
  router.push({path: '/admin/diploms/edit', query: {id: diplom.value.id}});
}

</script>

<style scoped>
.title{
  font-size: 18px;
  font-weight: 300;
  color: #736f6f;
  text-align: center;
  text-transform: uppercase;
}
.img_post{
  position: relative;
  margin: 0 auto;
  max-height: 400px;
}
</style>