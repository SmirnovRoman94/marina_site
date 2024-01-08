<template>
  <v-container>
    <v-btn color="primary">
      <nuxt-link to="/admin/diploms/create">Загрузить новый диплом</nuxt-link>
    </v-btn>
    <h1 class="border-b text-center text-uppercase">Дипломы</h1>

    <div class="mt-5" v-for="diplom in diploms" :key="diplom.id">
     <Diplom :itemData="diplom" @show="showDiplom"/>
    </div>
  </v-container>
</template>

<script setup>
import { useDiplomsStore } from "@/store/diploms";
import {onMounted} from "vue";
import Diplom from "@/components/Diplom.vue";

//STORE
const store = useDiplomsStore();

const diploms = computed(() => store.DIPLOMS);
onMounted(async() => {
  await store.GET_DIPLOMS()
})

//ROUTE
const router = useRouter();
function showDiplom(id){
  console.log(id)
  router.push(`/admin/diploms/${id}`)
}
</script>

<style scoped>

</style>