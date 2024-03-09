<template>
  <h3 class="text-xl text-center mb-2 uppercase">Отзывы</h3>
  <v-data-table
  :items="COMMENTS !== null ? COMMENTS.data : []"
  :headers="headers"
  :loading="COMMENTS === null"
  >
    <template #headers="{columns}">
      <tr>
        <th v-for="item in columns">
          <template v-if="item.key !== 'action'">
            <span class="font-weight-bold">{{item.title}}</span>
          </template>
          <template v-else>
          <v-icon icon="mdi-cog-outline" class="float-right pr-6" color="grey-darken-1"></v-icon>
          </template>
        </th>
      </tr>
    </template>
    <template #item="{item}">
      <tr>
        <td>
          <span v-html="item.text"></span>
        </td>
        <td>
          <span>{{item.name}}</span>
        </td>
        <td>
          <span>{{item.create}}</span>
        </td>
        <td class="flex justify-end">
          <v-btn
              icon="mdi-delete-outline"
              color="red-lighten-2"
              variant="text"
              @click.stop="deleteItem(item)"
          >
          </v-btn>
        </td>
      </tr>
    </template>
  </v-data-table>
</template>

<script setup>
import {useCommentStore}  from "@/store/comment";
import {onMounted} from "vue";
const snackbar = useSnackbar();

const commentStore = useCommentStore();
const COMMENTS = computed(() => commentStore.COMMENTS);
onMounted(async () => {
  await commentStore.GET_COMMENTS()
})

const headers =  [
  {title: 'Комментарий', align: 'start', sortable: false, key: 'text'},
  { title: 'Пользователь', key: 'name', align: 'start' },
  { title: 'Дата создания', key: 'create', align: 'start' },
  { title: 'action', key: 'action', align: 'end', sortable: false }
];

function deleteItem(item){
  commentStore.DELETE_COMMENT(item.id)
      .then(res => {
        res.data.mess === 1
            ? (snackbar.add({type: 'success', text: 'Комментарий успешно удален' }),  commentStore.GET_COMMENTS())
            : snackbar.add({type: 'warning', text: 'Произошла ошибка при удалении' })
      })
      .catch(err => {
        snackbar.add({type: 'warning', text: err })
      })
}
</script>

<style scoped>

</style>