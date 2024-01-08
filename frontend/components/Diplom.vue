<template>
  <v-card class="mx-auto" max-width="500" @click="clickDiplom(itemData.id)">
    <v-img class="align-end text-white" height="270" :src="itemData.image" cover/>
    <v-card-title class="title">{{itemData.title}}</v-card-title>
  </v-card>
</template>

<script>
export default {
  name: "Diplom.vue",
  props: {
    itemData: {
      type: Object,
      default:()=> {}
    }
  },
  methods:{
    clickDiplom(id){
      this.$emit('show', id);
    }
  },
}
</script>

<style scoped>
.title{
  font-size: 18px;
  text-transform: uppercase;
}
</style>