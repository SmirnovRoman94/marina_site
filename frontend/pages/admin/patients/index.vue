<template>
  <h3 class="text-xl text-center mb-2 uppercase">Пациенты</h3>
  <v-data-table
      :items="PATIENTS !== null ? PATIENTS.data : []"
      :headers="headers_table"
      :loading="PATIENTS === null"
      no-data-text="Нет данных о пациентах"
  >
    <template #headers="{columns}">
      <tr>
        <th v-for="(item, index) in columns">
          <template v-if="item.key !== 'action'">
            <div :class="{ 'flex justify-start': index === 0 , 'flex justify-end': index !== 0 }">
              <span class="font-weight-bold">{{item.title}}</span>
            </div>
          </template>
          <template v-else>
            <div class="flex justify-end">
              <v-btn @click="add" class="ma-2 mr-2" color="primary">
                <v-icon icon="mdi-plus" class="pr-2"></v-icon>Добавить
              </v-btn>
            </div>
          </template>
        </th>
      </tr>
    </template>
    <template #item="{item}">
      <tr>
        <td>{{item.user.name ? item.user.name : '-'}}</td>
        <td>{{item.user.email ? item.user.email : '-'}}</td>
        <td>{{item.diagnosis ? item.diagnosis : '-'}}</td>
        <td>action</td>
      </tr>
    </template>
  </v-data-table>


</template>

<script setup>
import {usePatientStore} from "@/store/patient";

//store
const store = usePatientStore();

const PATIENTS = computed(() => store.PATIENTS);

onMounted(async() => {
  await store.GET_PATIENTS();
});

const headers_table =  [
  {title: 'Имя', align: 'start', sortable: false, key: 'name'},
  {title: 'Email', align: 'end', sortable: false, key: 'email'},
  {title: 'Диагноз', align: 'end', sortable: false, key: 'diagnosis'},
  {title: 'action', align: 'end', sortable: false, key: 'action'}
];
</script>

<style scoped>

</style>