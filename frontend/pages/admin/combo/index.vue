<template>
  <v-container>
    <v-btn color="primary">
      <nuxt-link to="/admin/combo/create">Создать пакет</nuxt-link>
    </v-btn>
    <h1 class="border-b text-center text-uppercase">Пакеты</h1>

    <div class="mt-5" v-for="item in COMBO" :key="item.id">
      <Combo :itemData="item" @show="showCombo"/>
    </div>
  </v-container>
</template>

<script setup>
import { useComboStore } from "@/store/combo";
import {onMounted} from "vue";
import Combo from "@/components/Combo.vue";

//STORE
const store = useComboStore();

const COMBO = computed(() => store.COMBO);
onMounted(async() => {
  await store.GET_COMBO()
})

//ROUTE
const router = useRouter();
function showCombo(id){
  router.push(`/admin/combo/${id}`)
}
</script>

<style scoped>

</style>