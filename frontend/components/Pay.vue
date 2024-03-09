<template>
  <v-card class="mx-auto m-2">
    <v-card-text>
      <div class="flex justify-space-between border-b border-solid border-gray:50 pb-2">
        <div class="w-1/2 ">
          <h3 class="text-gray-500">Название банка</h3>
        </div>
        <div class="w-1/2">
          {{payItem.name_bank}}
        </div>
      </div>
      <div class="flex justify-space-between mt-5  border-b border-solid border-gray:50 pb-2">
        <div class="w-1/2 ">
          <h3 class="text-gray-500">Номер карты</h3>
        </div>
        <div class="w-1/2">
          {{payItem.number}}
        </div>
      </div>
      <div class="flex justify-space-between mt-3">
        <div class="w-1/2 ">
          <h3 class="text-gray-500">ФИО получателя</h3>
        </div>
        <div class="w-1/2">
          {{payItem.patromic}} {{payItem.name}} {{payItem.surname}}
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>

<script setup>
const props = defineProps({
  payItem: {type:Object},
});

const pay = toRef(props, 'payItem');
</script>

<style scoped>

</style>