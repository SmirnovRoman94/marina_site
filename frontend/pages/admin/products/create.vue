<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/products" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form  @submit.prevent="createProducts" ref="form">
            <div>
              <span>Название продукта</span>
              <v-text-field
                  v-model="product.title"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Название услуги обязательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-5">
              <span>Описание</span>
              <div class="mt-1">
                <client-only>
                  <QuillEditor theme="snow" v-model:content="product.description" contentType="html" toolbar="essential"/>
                </client-only>
                <span v-if="showErr === true && (product.description == null || product.description === '')" class="error_text">Поле Описание обяательно для заполнения</span>
              </div>
            </div>
            <div class="mt-5">
              <span>Цена</span>
              <v-text-field
                  v-model="product.price"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите стоимость продукта, например 3000"
                  :rules="[(v) => !!v || 'Поле Цена обязательно для заполнения']"
                  required
                  auto-grow
                  type="number"
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <v-file-input label="Медиафайл" variant="underlined" multiple :rules="[(v) => !!v || 'Поле Медиафайл обязательно для заполнения']" accept="image/*" v-model="media"  @update:modelValue="change"></v-file-input>
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
import { useProductsStore } from "@/store/products";

if(!process.server){
  const { QuillEditor } = await import('@vueup/vue-quill');
  const { vueApp } = useNuxtApp()
  if (!vueApp._context.components.QuillEditor)
    vueApp.component('QuillEditor', QuillEditor)
}

//store
const store = useProductsStore();

const router = useRouter();
const snackbar = useSnackbar();

const product = reactive({
  title: null,
  description: null,
  price: null
});

const media = ref(null);

function change(){
  let file = media.value !== null ? media.value[0] : null;
  if (file.size >= 5 * 1024 * 1024) {
    // Размер файла превышает 2 мегабайта
    snackbar.add({type: 'warning', text: 'Размер файла не превышает 5 мегабайт' });
    setTimeout(() => {
      media.value = null;
    },1000);
  }
}

//SAVING
const showErr = ref(false);
const form = ref(null);
async function createProducts(){
  if(product.description == null || product.description === ''){
    showErr.value = true;
  }else{
    const { valid } = await form.value.validate()
    if(valid){
      console.log(media.value)
      await store.SAVE_PRODUCTS({
        data: product,
        file: media.value !== null ? media.value[0] : null
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
  media.value = null;
  router.push('/admin/products');

  Object.assign(product, {
    title: null,
    description: null,
    price: null});
}
</script>

<style scoped>

</style>