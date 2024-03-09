<template>
  <v-container>
    <v-row>
      <v-col cols="12" class="container">
        <div class="mt-1 z-10">
          <h3>ЛИЧНЫЙ КАБИНЕТ</h3>
          <div class="item_card mt-5">
            <img src="../assets/image/cardItem.png" class="card">
          </div>
          <ServiceUserTable :dataTable="services"/>

          <!--form comment -->
          <v-form  @submit.prevent="sendComment" ref="form" class="form">
            <h5 class="mt-5">Ваш комментарий</h5>
            <div class="mt-0  editor">
              <span class="text_no_service">Ваше имя</span>
              <v-text-field
                  v-model="comment.name"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Иван"
                  :rules="[(v) => !!v || 'Поле Ваше имя обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0  editor">
              <span  class="text_no_service">Комментарий</span>
              <client-only>
                <div class="mt-1 ">
                  <QuillEditor theme="snow" v-model:content="comment.text" contentType="html" toolbar="essential"  ref="myEditor" />
                  <span v-if="showErr === true && (comment.text == null || comment.text === '')" class="error_text">Поле Комментарий обяательно для заполнения</span>
                </div>
              </client-only>
              <v-btn class="btn mt-2" type="submit">Отправить</v-btn>
            </div>
          </v-form>
        </div>
      </v-col>
    </v-row>
    <img src="../assets/image/yongMen.svg" class="men z-[-10]">
    <div class="flower z-[-10]"></div>
    <div class="flower_2 z-[-10]"></div>
    <div class="list z-[-10]"></div>
    <div class="list_2 z-[-10]"></div>
  </v-container>
</template>

<script setup>
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { useCommentStore } from "@/store/comment";
import ServiceUserTable from "@/components/ServiceUserTable.vue";

//STORE
const commentStore = useCommentStore();

const snackbar = useSnackbar();

if(!process.server){
  const { QuillEditor } = await import('@vueup/vue-quill');
  const { vueApp } = useNuxtApp()
  if (!vueApp._context.components.QuillEditor)
    vueApp.component('QuillEditor', QuillEditor)
}


//comments
const comment = reactive({
  name: null,
  text: null
});
const showErr = ref(false);
const form = ref(null);
async function sendComment(){
  if(comment.text == null || comment.text === ''){
    showErr.value = true;
  }else{
    const { valid } = await form.value.validate();
    if(valid){
      await commentStore.SAVE_COMMENT(comment)
          .then(res => {
            console.log(res)
            if(res.data.mess === 1){
              (snackbar.add({type: 'success', text: 'Ваш комментарий сохранен' }),
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
const myEditor = ref(null);
function reset(){
  Object.assign(comment, {name: null, text: null});
  myEditor.value.setContents(null);
}
</script>

<style scoped>
h3 {
  font-size: 24px;
  text-transform: uppercase;
  color: #50735F;
  text-decoration: underline;
}
h5 {
  font-size: 20px;
  text-transform: uppercase;
  font-style: italic;
  color: #50735F;
  font-family: 'Caveat', cursive;
}
.card{
  position: absolute;
  right: 30px;
  top: 0;
  z-index: -10;
  /*min-width: 300px;*/
  max-width: 500px;

}
.editor{
  width: 30%;
}
.form{
  z-index: 10 !important;
}
@media screen and (max-width: 500px){
  .card{
    width: 100%;
    right: 0px;
  }
  .men{
    margin-top: 0%;
    position: absolute;
    bottom: 50px;
    right: 20px;
  }
  .item_card_text{
    margin-top: 60%;
  }
  .flower,.flower_2{
    width: 100px;
    height: 100px;
  }
  .list,.list_2{
    width: 100px;
    height: 75px;
  }
  .editor{
    width: 100%;
  }
}
.item_card{
  position: relative;
}
.text_no_service{
  color: #9a9da1;
  font-family: 'Caveat', cursive;
}
.btn{
  height: 36px !important;
  background-color: #d29953;
  color: #d7d4d6;
  opacity: 1 !important;
  border-radius: 6px;
  cursor: pointer;
}
.men{
  float: right;
  margin-top: 30px;
  left: 100%;
}

.flower{
  position: absolute;
  background-image: url("../assets/image/flower_profile.png");
  top: 10%;
  left: 10%;
  width: 250px;
  height: 250px;

}
.flower_2{
  position: absolute;
  background-image: url("../assets/image/flower_profile.png");
  top: 30%;
  left: 50%;
  width: 250px;
  height: 250px;
}
.list{
  position: absolute;
  background-image: url("../assets/image/list_profile.png");
  top: 60%;
  left: 10%;
  width: 200px;
  height: 150px;
}
.list_2{
  position: absolute;
  background-image: url("../assets/image/list_profile.png");
  top: 50%;
  left: 70%;
  width: 200px;
  height: 150px;
}
</style>