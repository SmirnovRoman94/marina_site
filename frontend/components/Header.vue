<template>
<div class="header">
  <div class="logo">
    <NuxtLink to="/">
      <img src="/logo.svg" alt="logo">
    </NuxtLink>
  </div>
  <nav>
    <ul>
      <li>
        <NuxtLink to="/">
          <svg class="circle" xmlns="http://www.w3.org/2000/svg">
            <g>
              <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
              <text x="60" y="45" class="text_item" fill="#d7d4d6">Главная</text>
            </g>
          </svg>
        </NuxtLink>
      </li>
      <li>
        <NuxtLink to="/about">
          <svg class="circle" xmlns="http://www.w3.org/2000/svg">
            <g>
              <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
              <text x="65" y="45" class="text_item" fill="black">Пакеты</text>
            </g>
          </svg>
        </NuxtLink>
      </li>
      <li>
        <NuxtLink to="/public">
          <svg class="circle" xmlns="http://www.w3.org/2000/svg">
            <g>
              <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
              <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
              <text x="70" y="45" class="text_item" fill="black">Блог</text>
            </g>
          </svg>
        </NuxtLink>
      </li>
        <li v-if="Authenticated === true && isAdmin == 1" class="max-h-[80px]">
          <v-menu open-on-hover>
            <template v-slot:activator="{ props }">
              <svg class="circle" xmlns="http://www.w3.org/2000/svg" v-bind="props">
                <g>
                  <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
                  <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
                  <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
                  <text x="58" y="45" class="text_item" fill="black">Админка</text>
                </g>
              </svg>
            </template>
            <v-list class="list_items" v-for="(item, index) in items" :key="index" nav>
              <NuxtLink :to="item.path">
                <v-list-item link exact>
                  {{item.title}}
                </v-list-item>
              </NuxtLink>
            </v-list>
          </v-menu>
        </li>
        <li v-if="Authenticated === true && isAdmin == 0">
          <NuxtLink to="/profile">
            <svg class="circle" xmlns="http://www.w3.org/2000/svg">
              <g>
                <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
                <text x="70" y="45" class="text_item" fill="black">Кабинет</text>
              </g>
            </svg>
          </NuxtLink>
        </li>
        <li v-if="Authenticated === true" class="max-h-[80px]">
          <button @click.stop="onLogoutClick" class="btn">
            <svg class="circle" xmlns="http://www.w3.org/2000/svg">
              <g>
                <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
                <text x="70" y="45" class="text_item" fill="black">Выйти</text>
              </g>
            </svg>
          </button>
        </li>
        <li v-if="Authenticated === false" class="max-h-[80px]">
          <NuxtLink to="/login">
            <svg class="circle" xmlns="http://www.w3.org/2000/svg">
              <g>
                <ellipse class="foreground" ry="60" rx="30" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="53" rx="33" cy="25.5" cx="75.5" stroke-width="1"/>
                <ellipse class="foreground" ry="67" rx="37" cy="27.5" cx="78.5" stroke-width="1"/>
                <text x="70" y="45" class="text_item" fill="black">Войти</text>
              </g>
            </svg>
          </NuxtLink>
        </li>
    </ul>
  </nav>
</div>
</template>

<script setup>
import {useAuthStore} from "../store/auth";
import {watch} from "vue";

const storeAuth = useAuthStore();
const snackbar = useSnackbar();

const Authenticated = computed(() => storeAuth.authenticated);
const isAdmin = computed(() => storeAuth.isAdmin);

const LOGOUT = computed(() => storeAuth.logout);
const router = useRouter();

async function  onLogoutClick(){
  await storeAuth.GET_LOGOUT()
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


watch(LOGOUT,(val) => {
  console.log(val)
  if(val === true){
    snackbar.add({type: 'success', text: `До свидания!` });
    navigateTo('/');
  }
});


</script>

<style scoped lang="scss">
.header {
  background-color: #50735F;
  height: 80px;
  display: flex;
  padding-left: 5%;
  padding-right: 5%;
}
.logo {
  margin: auto 0;
  cursor: pointer;
  img {
    min-height: 69px !important;
    min-width: 49px !important;
    transition: all .5s ease;
  }
  img:hover{
    transform: scale(1.2);
  }
}
ul {
  display: flex;
  align-items: center;
  height: 100%;
  min-width: 400px;
  justify-content: space-between;
  li {
    cursor: pointer;
  }
}

.btn{

}



.svg-container {
  height: 80px;
  position: relative;
  width: 160px;
}

.circle {
  height: 80px;
  width: 160px;

  .foreground {
    fill: transparent;
    stroke-dasharray: 377;
    stroke-dashoffset: 377;
    stroke: #d7d4d6;
    transform-origin: 50% 50%;
    transform: rotate(-270deg);
    transition: all 800ms ease;
  }
  .text_item{
    fill: #d7d4d6;;
    transition: all 800ms ease;
  }

  &:hover {
    .text_item{
      fill: #d7d4d6;
    }
    cursor: pointer;
    .text_item{
      color: white;
    }
    .background {
      stroke: transparent;
    }
    .foreground {
      stroke-dashoffset: 0;
    }
  }
}

/*list */
.list_items{
  background-color: #50735F !important;
  color: #d7d4d6;
}
</style>