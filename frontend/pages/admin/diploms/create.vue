<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/diploms" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form  @submit.prevent="createDiplom" ref="form">
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
            <div class="mt-0">
              <v-file-input label="Диплом" variant="underlined" multiple :rules="[(v) => !!v || 'Поле Диплом обяательно для заполнения']" accept="image/*" v-model="image"></v-file-input>
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
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { useDiplomsStore } from "@/store/diploms";


//STORE
const store = useDiplomsStore();
const router = useRouter();
const snackbar = useSnackbar();

const diplom = reactive({
  title: null,
});
const image = ref(null);

//SAVING
const form = ref(null);
async function createDiplom(){
  const { valid } = await form.value.validate()
  if(valid){
    console.log(image.value)
    await store.SAVE_DIPLOM({
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
  router.push('/admin/diploms');

  Object.assign(diplom, {title: null});
}

</script>

<style scoped>

</style>