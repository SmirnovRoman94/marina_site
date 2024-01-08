<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/posts" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form fast-fail @submit.prevent="createPost" ref="form">
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
              <v-img class="align-end text-white" height="400" width="100%" object-cover  :src="post.image" cover/>
            </div>
            <div class="mt-5">
              <v-file-input label="Новая картинка" variant="underlined" multiple  accept="image/*" v-model="image"></v-file-input>
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
import { usePostStore } from "@/store/posts";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {onMounted} from "vue";
if(!process.server){
  const { QuillEditor } = await import('@vueup/vue-quill');
  const { vueApp } = useNuxtApp()
  if (!vueApp._context.components.QuillEditor)
    vueApp.component('QuillEditor', QuillEditor)
}


//STORE
const store = usePostStore();
const snackbar = useSnackbar();
const route = useRoute();
const router = useRouter();

const post = reactive({
  date: "",
  id: null,
  image: "",
  text: "",
  preview: "",
  title: ""
});

const image = ref(null);


onMounted(async() => {
  await store.GET_POST_ITEM(route.query.id)
      .then(res=>{
        console.log(res)
        Object.assign(post, res.data.data)
      })
})

//SAVING
const showErr = ref(false);
const form = ref(null);
async function createPost(){
  if(post.text == null || post.text === ''){
    showErr.value = true;
  }else{
    const { valid } = await form.value.validate()
    if(valid){
      console.log(image.value)
      await store.UPDATE_POST({
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
  router.push(`/admin/posts/${post.id}`);
  image.value = null;
  Object.assign(post, {date: "",
    id: null,
    image: "",
    text: "",
    preview: "",
    title: ""});

}

</script>

<style scoped>

</style>