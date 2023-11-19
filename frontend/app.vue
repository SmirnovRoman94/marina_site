<template>
  <div>
    Hi {{userName}}
  </div>
</template>


<script setup>
import {onMounted, ref} from "vue";

const userName = ref(null);

const axios = useNuxtApp().$axios;

onMounted(() => {
  axios.get('/api/hello')
      .then(res => {
        console.log(res)
        userName.value = res.data.name
      })
      .catch(err => {
        console.log(err)
      })
})
</script>