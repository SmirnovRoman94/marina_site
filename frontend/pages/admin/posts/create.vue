<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/posts" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form  @submit.prevent="createPost" ref="form">
            <div>
              <span>Название поста</span>
              <v-text-field
                  v-model="post.title"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Название поста обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Превью поста</span>
              <v-text-field
                  v-model="post.preview"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите превью (МАКСИМАЛЬНОЕ количество слов 15)"
                  :rules="[(v) => !!v || 'Поле Превью поста обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Текст поста</span>
              <div class="mt-1">
                <client-only>
                  <QuillEditor theme="snow" v-model:content="post.text" contentType="html" toolbar="essential"/>
                </client-only>
                <span v-if="showErr == true && (post.text == null || post.text == '')" class="error_text">Поле Текст поста обяательно для заполнения</span>
              </div>
            </div>
            <div class="mt-5">
              <v-file-input label="Картинка" variant="underlined" multiple :rules="[(v) => !!v || 'Поле Картинка обяательно для заполнения']" accept="image/*" v-model="image"></v-file-input>
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
import { usePostStore } from "@/store/posts";
import {watch} from "vue";

if(!process.server){
  const { QuillEditor } = await import('@vueup/vue-quill');
  const { vueApp } = useNuxtApp()
  if (!vueApp._context.components.QuillEditor)
    vueApp.component('QuillEditor', QuillEditor)
}

//STORE
const postStore = usePostStore();
const router = useRouter();
const snackbar = useSnackbar();

const post = reactive({
  title: null,
  text: null,
  preview: null
});
const image = ref(null);

//SAVING
const showErr = ref(false);
const form = ref(null);
async function createPost(){
  if(post.text == null || post.text == ''){
    showErr.value = true;
  }else{
    const { valid } = await form.value.validate()
    if(valid){
      console.log(image.value)
      await postStore.SAVE_POST({
        data: post,
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
  Object.assign(post, {title: null, text: null, preview: null});
  image.value = null;
  router.push('/admin/posts');
}

</script>

<style scoped>

</style>