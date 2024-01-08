<template>
  <v-container>
    <v-btn color="primary">
      <nuxt-link to="/admin/services/create">Создать услугу</nuxt-link>
    </v-btn>
    <h1 class="border-b text-center text-uppercase">Услуги</h1>

    <div class="mt-5" v-for="service in services" :key="service.id">
      <Service :itemData="service" @show="showService"/>
    </div>
  </v-container>
</template>

<script setup>
import { useServicesStore } from "@/store/services";
import {onMounted} from "vue";
import Service from "@/components/Service.vue";

//STORE
const store = useServicesStore();

const services = computed(() => store.SERVICES);
onMounted(async() => {
  await store.GET_SERVICES()
})

//ROUTE
const router = useRouter();
function showService(id){
  console.log(id)
  router.push(`/admin/services/${id}`)
}
</script>

<style scoped>

</style>