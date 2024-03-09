<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="8">
        <nuxt-link to="/admin/products" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <v-card class="mt-5">
          <h1 class="title">{{product.title}}</h1>
          <div class="flex justify-space-between mt-5">
            <div class="w-1/3">
              <img src="../../../assets/image/music.png" class="music">
            </div>
            <div class="w-2/3 ml-4">
              <div class="mt-5">
                <h2 class="text-uppercase text-center underline decoration-dotted text-[#50735F] text-lg">ОПИСАНИЕ</h2>
                <div class="mt-2 text" v-html="product.description"></div>
              </div>
              <audio controls  :src="product.media" class="mt-5 mx-auto"></audio>
            </div>
          </div>
          <div class="my-5 flex justify-end">
            <v-btn class="mr-2" color="red-darken-1" @click="deleteItem(product.id)">Удалить</v-btn>
            <v-btn class="mr-2" color="green" @click="editItem">Редактировать</v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useProductsStore } from "@/store/products";
import {onMounted} from "vue";

//STORE
const store = useProductsStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const product = ref({});

onMounted(async() => {
  await store.GET_PRODUCTS_ITEM(route.params.id)
      .then(res=>{
        console.log(res)
        Object.assign(product.value, res.data.data)
      })
})


async function deleteItem(id){
  await store.DELETE_PRODUCTS(id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Услуга была успешно удалена' }),
              router.push({path: '/admin/products'}));
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
  router.push({path: '/admin/products/edit', query: {id: product.value.id}});
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
.music{
  margin: auto;
  height: 200px;
}
.text{
  color: #50735F;
  font-size: 12px;
  text-align: justify;
  padding: 0 16px;
}
</style>