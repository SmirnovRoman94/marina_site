<template>
  <div v-for="commentItem in COMMENTS?.data" :key="commentItem.id">
    <Comments :comment="commentItem"/>
  </div>
</template>

<script setup>
import Comments from "@/components/Comment.vue";

import {useCommentStore} from "../store/comment";

const store = useCommentStore();

const COMMENTS = computed(() => store.COMMENTS);
onMounted(async() => {
  await store.GET_COMMENTS();
});

</script>

<style scoped>

</style>