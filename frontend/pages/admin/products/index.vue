<template>
  <v-container>
    <v-btn color="primary">
      <nuxt-link to="/admin/products/create">Создать продукт</nuxt-link>
    </v-btn>
    <h1 class="border-b text-center text-uppercase">Продукты</h1>

    <div class="mt-5" v-for="product in products" :key="product.id">
      <Product :productItem="product" @show="showProduct"/>
    </div>
  </v-container>
</template>

<script setup>
import { useProductsStore } from "@/store/products";
import {onMounted} from "vue";
import Product from "@/components/Product.vue";

//STORE
const store = useProductsStore();

const products = computed(() => store.PRODUCTS);
onMounted(async() => {
  await store.GET_PRODUCTS()
})

//ROUTE
const router = useRouter();
function showProduct(id){
  console.log(id)
  router.push(`/admin/products/${id}`)
}
</script>

<style scoped>

</style>