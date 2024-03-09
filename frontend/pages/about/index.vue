<template>
  <div v-for="item in COMBO" :key="item.id">
    <Combo :itemData="item" @show="showCombo" class="mb-5"/>
  </div>
</template>

<script setup>
import { useComboStore } from "@/store/combo";
import Combo from "@/components/Combo.vue";
//STORE
const store = useComboStore();

const COMBO = computed(() => store.COMBO);
onMounted(async() => {
  await store.GET_COMBO();
})

const router = useRouter();
function showCombo(id){
  router.push(`/about/${id}`)
}
</script>

<style scoped>

</style>