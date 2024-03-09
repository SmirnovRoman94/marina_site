<template>
  <v-card class="sm:w-100 md:w-1/3 m-2">
    <v-card-text>
      <p v-html="comment.text" class="text"></p>
      <br>
      <div class="flex justify-end">
        <span class="name">{{comment.name}}</span>
        <span class="pl-1 date">{{comment.create}}</span>
      </div>
    </v-card-text>
  </v-card>
</template>

<script setup>
const props = defineProps({
  comment: {type:Object},
});

const comment = toRef(props, 'comment');
</script>

<style scoped>
.text{
  color: #50735F;
  font-size: 14px;
}
.name{
  font-size: 10px;
  font-weight: 500;
}
.date{
  font-size: 10px;
  font-style: italic;
}
.v-card{
  background: #F4F3F0;
}
</style>