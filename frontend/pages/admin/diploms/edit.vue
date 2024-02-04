<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/diploms" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form fast-fail @submit.prevent="createDiplom" ref="form">
            <div>
              <span>Название диплома</span>
              <v-text-field
                  v-model="diplom.title"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название (Психолог высшей категории)"
                  :rules="[(v) => !!v || 'Поле Название диплома обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-5">
              <v-img class="align-end text-white" height="400" width="100%" object-cover  :src="diplom.image" cover/>
            </div>
            <div class="mt-5">
              <v-file-input label="Новая картинка" variant="underlined" multiple  accept="image/*" v-model="image" @update:modelValue="change"></v-file-input>
            </div>
            <div class="my-5 flex justify-end">
              <v-btn type="submit"  class="mr-2" color="primary">Сохранить</v-btn>
              <v-btn variant="outlined"  color="primary" @click.stop="reset">Отменить</v-btn>
            </div>
          </v-form>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useDiplomsStore } from "@/store/diploms";
import {onMounted} from "vue";

//STORE
const store = useDiplomsStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const diplom = reactive({
  title: ""
});

const image = ref(null);

onMounted(async() => {
  await store.GET_DIPLOM_ITEM(route.query.id)
      .then(res=>{
        console.log(res)
        Object.assign(diplom, res.data.data)
      })
});

function change(){
  let file = image.value !== null ? image.value[0] : null;
  if (file.size >= 5 * 1024 * 1024) {
    // Размер файла превышает 2 мегабайта
    snackbar.add({type: 'warning', text: 'Размер файла не превышает 5 мегабайт' });
    setTimeout(() => {
      image.value = null;
    },1000);
  }
}

//SAVING
const form = ref(null);
async function createDiplom(){
  const { valid } = await form.value.validate()
  if(valid){
    console.log(image.value)
    await store.UPDATE_DIPLOM({
      data: diplom,
      file: image.value !== null ? image.value[0] : null
    })
        .then(function (res) {
          console.log(res)
          if(res.data.mess === 1){
            (snackbar.add({type: 'success', text: 'Данные успешно сохранены' }),
                reset())
          }else{
            snackbar.add({type: 'warning', text: 'Произошла ошибка сохранения' })
          }
        })
        .catch(err => {
          console.log(err)
          snackbar.add({type: 'warning', text: err.response.data?.message})
        })
  }
}

function reset(){
  image.value = null;
  router.push(`/admin/diploms/${diplom.id}`);

  Object.assign(diplom, {title: ""});
}
</script>

<style scoped>

</style>