<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/services" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form  @submit.prevent="createService" ref="form">
            <div>
              <span>Название услуги</span>
              <v-text-field
                  v-model="service.title"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Название услуги обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Форма общения</span>
              <v-select

                  v-model="service.form"
                  :items="['Онлайн', 'Оффлайн']"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Выберите одно из значений"
                  :rules="[(v) => !!v || 'Поле Форма общения обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-select>
            </div>
            <div class="mt-0">
              <span>Продолжительность сеанса (в минутах)</span>
              <v-text-field
                  v-model="service.duration"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите число, например, 50"
                  :rules="[(v) => !!v || 'Поле Продолжительность сеанса обяательно для заполнения']"
                  required
                  type="number"
                  class="mt-1"
              ></v-text-field>
            </div>
            <div>
              <span>Превью услуги (основные аспектыб не более 15 слов)</span>
              <v-text-field
                  v-model="service.preview"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите превью"
                  :rules="[(v) => !!v || 'Поле Превью услуги обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-5">
              <span>Описание</span>
              <div class="mt-1">
                <client-only>
                  <QuillEditor theme="snow" v-model:content="service.description" contentType="html" toolbar="essential"/>
                </client-only>
                <span v-if="showErr === true && (service.description == null || service.description === '')" class="error_text">Поле Описание обяательно для заполнения</span>
              </div>
            </div>
            <div class="mt-5">
              <span>Цена</span>
              <v-text-field
                  v-model="service.price"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите соимость услуги, например 3000"
                  :rules="[(v) => !!v || 'Поле Цена обяательно для заполнения']"
                  required
                  auto-grow
                  type="number"
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <v-file-input label="Картинка" variant="underlined" multiple :rules="[(v) => !!v || 'Поле Картинка обяательно для заполнения']" accept="image/*" v-model="image"  @update:modelValue="change"></v-file-input>
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
import { useServicesStore } from "@/store/services";

if(!process.server){
  const { QuillEditor } = await import('@vueup/vue-quill');
  const { vueApp } = useNuxtApp()
  if (!vueApp._context.components.QuillEditor)
    vueApp.component('QuillEditor', QuillEditor)
}

//STORE
const store = useServicesStore();
const router = useRouter();
const snackbar = useSnackbar();

const service = reactive({
  title: null,
  form: null,
  duration: null,
  preview: null,
  description: null,
  price: null
});
const image = ref(null);

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
const showErr = ref(false);
const form = ref(null);
async function createService(){
  if(service.description == null || service.description === ''){
    showErr.value = true;
  }else{
    const { valid } = await form.value.validate()
    if(valid){
      console.log(image.value)
      await store.SAVE_SERVICE({
        data: service,
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
}

function reset(){
  image.value = null;
  router.push('/admin/services');

  Object.assign(service, {title: null,
    form: null,
    duration: null,
    preview: null,
    description: null,
    price: null});
}

</script>

<style scoped>

</style>