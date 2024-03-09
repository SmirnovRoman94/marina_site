<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <nuxt-link to="/admin/combo" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <div class="mt-5">
          <v-form  @submit.prevent="createCombo" ref="form">
            <div>
              <span>Название пакета</span>
              <v-text-field
                  v-model="combo.title"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите название"
                  :rules="[(v) => !!v || 'Поле Название пакета обязательно для заполнения']"
                  required
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Цена</span>
              <v-text-field
                  v-model="combo.old_price"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите стоимость пакета, например 3000"
                  :rules="[(v) => !!v || 'Поле Цена обязательно для заполнения']"
                  required
                  auto-grow
                  type="number"
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Скидка</span>
              <v-text-field
                  v-model="combo.discount"
                  density="comfortable"
                  variant="outlined"
                  placeholder="Введите скидку пакета, например 10"
                  :rules="[(v) => !!v || 'Поле Скидка обязательно для заполнения']"
                  required
                  auto-grow
                  type="number"
                  class="mt-1"
              ></v-text-field>
            </div>
            <div class="mt-0">
              <span>Услуги пакета</span>
              <div v-if="combo.services.length > 0">
                <div v-for="(item, index) in combo.services" :key="index" class="flex justify-space-between align-end my-2 px-5 py-5 border-x border-y border-solid border-emerald-600">
                  <div>
                    <span class="text-gray-400 font-light">Название услуги</span>
                    <div class="mt-1 h-[40px]">
                      <p class="pt-[14px]">{{item.title}}</p>
                    </div>
                  </div>
                  <div>
                    <span class="text-gray-400 font-light">Количество</span>
                    <div class="mt-1">
                      <v-text-field
                          v-model="item.count"
                          density="comfortable"
                          variant="underlined"
                          placeholder="Введите количество выбранной услуги"
                          hide-details
                          auto-grow
                          type="number"
                          class="mt-1"
                      ></v-text-field>
                    </div>
                  </div>
                  <div>
                    <v-btn type="button" variant="text" color="red" icon="mdi-delete-outline" @click.stop="deleteitem(index)"></v-btn>
                  </div>
                </div>
              </div>
              <div v-else>
                <span class="font-light text-gray-400">Пока не выбраны услуги пакета</span>
              </div>
            </div>
            <div class="mt-5">
              <v-btn type="button" variant="outlined" color="primary"  @click.stop="openDialog">Добавить услугу</v-btn>
            </div>
            <div class="mt-5">
              <v-file-input label="Медиафайл" variant="underlined" multiple  accept="image/*" v-model="media"  @update:modelValue="change"></v-file-input>
            </div>
            <div class="my-5 flex justify-end">
              <v-btn type="submit"  class="mr-2" color="primary">Сохранить</v-btn>
              <v-btn variant="outlined"  color="primary" @click.stop="reset">Отменить</v-btn>
            </div>
          </v-form>
        </div>

        <v-dialog v-model="dialog" width="500">
          <v-card>
            <v-card-title class="flex justify-space-between align-center">
              <h1>Добавление услуг</h1>
              <v-btn icon="mdi-close" variant="text" @click="dialog = false"></v-btn>
            </v-card-title>
            <v-card-text>
              <v-list density="compact">
                <v-list-item
                    v-for="(item, i) in SERVICES"
                    :key="i"
                    :value="item"
                    color="primary"
                >
                  <v-list-item-title v-text="item.title"></v-list-item-title>
                  <template v-slot:append>
                    <v-btn icon="mdi-gesture-tap-button" color="primary" variant="text" @click="select(item)"></v-btn>
                  </template>
                </v-list-item>
              </v-list>
              <div class="mt-5 my-5 flex justify-end">
                <v-btn variant="text"  color="primary" @click.stop="dialog = false">Закрыть</v-btn>
              </div>
            </v-card-text>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useComboStore } from "@/store/combo";
import { useServicesStore } from "@/store/services";

const combo = reactive({
  title: null,
  old_price: null,
  discount: null,
  time_discount: null,
  level: 0,
  count_level: 0,
  services: []
});


const media = ref(null);


//store
const store = useComboStore();
const servicesStore = useServicesStore();

const router = useRouter();
const snackbar = useSnackbar();

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


//dialog
const dialog = ref(false);
const SERVICES = computed(() => servicesStore.SERVICES);

function openDialog(){
  dialog.value = true;
}

function select(item){
  if(item !== null){
    if(combo.services.some(el => el.id === item.id)){
      snackbar.add({type: 'warning', text: 'Данная услуга уже выбрана. Измените ее количество или добавьте новую' })
    }else{
      combo.services.push({title: item.title, id: item.id, count: 1});
      snackbar.add({type: 'success', text: 'Услуга добавлена' })
    }
  }else{
    snackbar.add({type: 'warning', text: 'Выберите услугу' })
  }
}

function deleteitem(index){
  combo.services.splice(index, 1);
  snackbar.add({type: 'success', text: 'Услуга удалена' })
}


onMounted(async() => {
  await servicesStore.GET_SERVICES();
})


//saving
const form = ref(null);

async function createCombo(){
  const { valid } = await form.value.validate();
  if(valid){
    if(combo.services.length === 0){
      snackbar.add({type: 'warning', text: 'Необходимо добавить хоть одну услугу' });
    }else{
      combo.services.forEach(el => {
        combo.count_level = combo.count_level + Number(el.count);
        el.count = Number(el.count);
      });
      combo.discount = Number(combo.discount);
      combo.old_price = Number(combo.old_price);
      save();
    }
  }else{
    snackbar.add({type: 'warning', text: 'Не заполнены необходимые данные' });
  }

  async function save(){
    console.log(combo);
    await store.SAVE_COMBO({
      data: combo,
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


function reset(){
  media.value = null;
  router.push('/admin/combo');

  Object.assign(combo, {
    name: null,
    old_price: null,
    discount: null,
    time_discount: null,
    level: 0,
    count_level: 0,
    services: []
  });
}
</script>

<style scoped>
.v-card-title{
  display: flex !important;
  justify-content: space-between;
  align-items: center;
}
</style>