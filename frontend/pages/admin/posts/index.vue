<template>
  <v-container>
    <v-btn color="primary">
      <nuxt-link to="/admin/posts/create">Создать пост</nuxt-link>
    </v-btn>
    <h1 class="border-b text-center text-uppercase">Посты</h1>

    <div class="mt-5" v-for="post in posts" :key="post.id">
      <Post :itemData="post" @show="showPost"/>
    </div>
  </v-container>
</template>

<script setup>
import { usePostStore } from "@/store/posts";
import Post from "@/components/Post.vue";
import {onMounted} from "vue";

//STORE
const store = usePostStore();

const posts = computed(() => store.POSTS);
onMounted(async() => {
  await store.GET_POSTS()
})

//ROUTE
const router = useRouter();
function showPost(id){
  console.log(id)
  router.push(`/admin/posts/${id}`)
}
</script>

<style scoped>

</style>