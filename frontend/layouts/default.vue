<template>
  <div>
    <v-layout >
      <Header v-if="width > 1000"/>
      <v-navigation-drawer
          v-model="drawer"
          :rail="rail"
          permanent
          @click="rail = false"
          v-else
          color="#50735F"
          scrim
      >
        <v-list-item
            prepend-avatar="/logo.svg"
            title="Marina site"
            nav
            class="icon"
        >
          <template v-slot:append>
            <v-btn
                variant="text"
                icon="mdi-chevron-left"
                @click.stop="rail = !rail"
            ></v-btn>
          </template>
        </v-list-item>
        <v-divider></v-divider>
        <v-list density="comfortable" nav  @click.stop="rail = !rail">
          <NuxtLink to="/">
            <v-list-item prepend-icon="mdi-home-city" title="Главная" value="home"></v-list-item>
          </NuxtLink>
          <NuxtLink to="/about">
            <v-list-item prepend-icon="mdi-store" title="Пакеты" value="store"></v-list-item>
          </NuxtLink>
          <NuxtLink to="/public">
            <v-list-item prepend-icon="mdi-post-outline" title="Блог" value="faq"></v-list-item>
          </NuxtLink>
          <v-menu open-on-hover v-if="Authenticated === true && isAdmin == 1">
            <template v-slot:activator="{ props }">
              <v-list-item prepend-icon="mdi-security" title="Админка" value="admin" v-bind="props"></v-list-item>
            </template>
            <v-list class="list_items" v-for="(item, index) in items" :key="index" >
              <NuxtLink :to="item.path">
                <v-list-item class="list_item" link exact>
                  {{item.title}}
                </v-list-item>
              </NuxtLink>
            </v-list>
          </v-menu>
          <NuxtLink to="/profile" v-if="Authenticated === true && isAdmin == 0"  @click.stop="rail = !rail">
            <v-list-item prepend-icon="mdi-monitor-dashboard" title="Кабинет" value="profile"></v-list-item>
          </NuxtLink>
          <NuxtLink to="/login" v-if="Authenticated === false"  @click.stop="rail = !rail">
            <v-list-item prepend-icon="mdi-login" title="Войти" value="login"></v-list-item>
          </NuxtLink>
          <v-list-item prepend-icon="mdi-logout" title="Выйти" value="logout" @click.stop="onLogoutClick" v-if="Authenticated === true" ></v-list-item>
        </v-list>
      </v-navigation-drawer>
      <v-main class="mt-5 main">
        <slot/>
      </v-main>
      <Footer/>
    </v-layout>
  </div>
</template>

<script setup>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
import { useWindowSize } from 'vue-window-size';
import {useAuthStore} from "../store/auth";
const storeAuth = useAuthStore();

const Authenticated = computed(() => storeAuth.authenticated);
const isAdmin = computed(() => storeAuth.isAdmin);

const { width } = useWindowSize();
const drawer =  ref(true);
const rail = ref(false);

const router = useRouter();

async function onLogoutClick(){
  rail.vlue = !rail.value;
  await storeAuth.GET_LOGOUT()
  router.push('/');
}

const items = ref([
  { title: 'Главная', path: '/admin/' },
  { title: 'Посты', path: '/admin/posts' },
  { title: 'Услуги', path: '/admin/services' },
  { title: 'Товары', path: '/admin/products' },
  { title: 'Дипломы', path: '/admin/diploms' },
  { title: 'Пакеты (наборы)', path: '/admin/combo' },
  { title: 'Оплата', path: '/admin/paying' },
  { title: 'Пациенты', path: '/admin/patients' },
])
</script>

<style scoped lang="scss">
main {
  width: 90%;
  margin: auto;
  margin-bottom: 300px;
  overflow: auto;
  scrollbar-width: thin; /* толщина полосы прокрутки */
  scrollbar-color: #000000 #ffffff; /* цвет полосы прокрутки и фона */
}
.v-layout {
  display: block;
}
/*list */
.list_items{
  background-color: #50735F !important;
  color: #d7d4d6;
}
.v-navigation-drawer >>> .v-img__img, .v-img__picture, .v-img__gradient, .v-img__placeholder, .v-img__error{
  padding-left: 5px !important;
}
</style>


