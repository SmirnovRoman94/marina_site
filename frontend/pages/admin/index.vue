<template>
Index page from admin

</template>

<script setup>
import {useProductsStore}  from "@/store/products";
import {onMounted} from "vue";

const postStore = useProductsStore();

onMounted(async () => {
  await postStore.GET_PRODUCT(20)
      .then(res=> {
        console.log(res)
      })
})
</script>

<style scoped>

</style>