<template>
  <v-container>
    <h1 class="border-b text-center text-uppercase">Данные оплаты</h1>
    <div class="mt-5">
        <div v-for="item in PAYS" :key="item.id">
          <Pay :payItem="item"/>
          <div class="my-5 flex justify-end">
            <v-btn type="submit"  class="mr-2" color="primary" @click="edit(item)">Изменить</v-btn>
            <v-btn variant="outlined"  color="red" @click="deleteItem(item)">Удалить</v-btn>
          </div>
        </div>
    </div>
  </v-container>
</template>

<script setup>
import { usePayStore } from "@/store/pay";
import Pay from "@/components/Pay.vue";
//STORE
const store = usePayStore();

const PAYS = computed(() => store.PAYS);

onMounted(async() => {
  await store.GET_PAYS();
});

async function deleteItem(item){
  await store.DELETE_PAYS(item.id)
      .then(function (res) {
        console.log(res)
        if(res.data.mess === 1){
          (snackbar.add({type: 'success', text: 'Данные успешно удалены' }),
              reset())
        }else{
          snackbar.add({type: 'warning', text: 'Произошла ошибка удаления' })
        }
      })
      .catch(err => {
        console.log(err)
        snackbar.add({type: 'warning', text: err.response.data?.message})
      })
}

const router = useRouter();

function edit(item){
  router.push({path: '/admin/paying/edit', query: {id: item.id}});
}


</script>

<style scoped>

</style>