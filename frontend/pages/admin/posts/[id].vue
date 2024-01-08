<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/posts" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <h1 class="title">{{post.title}}</h1>
          <br>
          <div class="mt-1 preview">
            {{post.preview}}
          </div>
          <div class="mt-8">
            <img :src="post.image" :alt="post.title" class="img_post">
          </div>
          <div class="mt-5" v-html="post.text"></div>
          <hr>
          <div class="my-5 flex justify-end">
            <v-btn class="mr-2" color="red-darken-1" @click="deleteItem(post.id)">Удалить</v-btn>
            <v-btn class="mr-2" color="green" @click="editItem">Редактировать</v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { usePostStore } from "@/store/posts";
import {onMounted} from "vue";

//STORE
const store = usePostStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const post = ref({});

onMounted(async() => {
  await store.GET_POST_ITEM(route.params.id)
      .then(res=>{
        console.log(res)
        Object.assign(post.value, res.data.data)
      })
})


async function deleteItem(id){
  await store.DELETE_POST(id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Пост был успешно удален' }),
              router.push({path: '/admin/posts'}))
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
  router.push({path: '/admin/posts/edit', query: {id: post.value.id}});
}
</script>

<style scoped>
.title{
  font-size: 20px;
  font-weight: 500;
  text-transform: uppercase;
}
.preview{
  font-size: 14px;
  color: #4b5563;
}
.img_post{
  width: 100%;
  object-fit: cover;
  height: 400px;
}
</style>