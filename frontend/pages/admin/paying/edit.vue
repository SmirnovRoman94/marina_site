<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <div class="mt-5">
          <h1 class="mb-5 text-uppercase text-xl underline">Данные для платежей</h1>
          <v-form  @submit.prevent="createPaying" ref="form">
            <div>
              <span>Название банка</span>
              <v-text-field
                  v-model="pay.name_bank"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Название банка обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Номер карты</span>
              <div class="mt-1">
                <input v-model="pay.number" v-maska data-maska="#### #### #### ####" placeholder="Введите номер" @blur="focusItem" :class="itemClasss"/>
              </div>
              <span v-if="errorNumber == true" class="error_text">Поле Номер обязательно для заполнения</span>
            </div>
            <div class="mt-1">
              <span>Фамилия</span>
              <v-text-field
                  v-model="pay.surname"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Фамилия обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div>
              <span>Имя</span>
              <v-text-field
                  v-model="pay.name"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Имя обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div>
              <span>Отчество</span>
              <v-text-field
                  v-model="pay.patromic"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Отчество обяательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
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
import { usePayStore } from "@/store/pay";
import {onMounted} from "vue";

//STORE
const store = usePayStore();

const pay = reactive({
  name_bank: null,
  number: null,
  surname: null,
  name: null,
  patromic: null
});

const route = useRoute();

onMounted(async() => {
  await store.GET_PAYS_ITEM(route.query.id)
      .then(res=>{
        console.log(res)
        Object.assign(pay, res.data.data)
      });
});

const errorNumber = ref(false);

watch(() => pay.number, (n, o) =>  {
  console.log(n, o);
  if(n !== null || n !== ''){
    errorNumber.value = false;
  }
});

function focusItem(){
  if(pay.number == '' || pay.number == null){
    errorNumber.value = true;
  }
}

const itemClasss = computed(() => {
  return errorNumber.value === false ? 'input' : 'error_input'
})

//saving
const form = ref(null);
const snackbar = useSnackbar();

async function  createPaying(){
  if(pay.number == null){
    errorNumber.value = true;
  }else{
    const { valid } = await form.value.validate();
    await store.UPDATE_PAYS(pay)
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
const router = useRouter();

function reset(){
  Object.assign(pay, { name_bank: null, number: null, surname: null, name: null, patromic: null});
  router.push('/admin/paying');
}

</script>

<style scoped>
.input{
  border: 1px solid rgba(0, 0, 0, 0.49);
  width: 100%;
  padding: 12px 16px;
  border-radius: 4px;
}
.input:focus{
  outline: 1px solid rgba(0, 0, 0, 0.99);
}
.input:focus-visible{
  outline: 1px solid rgba(0, 0, 0, 0.99);
}
.error_input{
  border: 1px solid #B00020;
  width: 100%;
  padding: 12px 16px;
  border-radius: 4px;
}
.error_input:focus{
  outline: 1px solid #B00020;
}
.error_input:focus-visible{
  outline: 1px solid #B00020;
}
</style>