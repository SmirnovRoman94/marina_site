<template>
  <div>
    <v-hover v-slot="{ isHovering, props }">
      <v-card class="mx-auto" color="grey-lighten-4" max-width="400" v-bind="props">
        <v-img max-height="250" :src="itemData.image" cover>
          <div class="flex justify-end">
            <img src="../assets/image/flags.svg" class="list">
          </div>
          <v-expand-transition>
            <div v-if="isHovering" class="d-flex transition-fast-in-fast-out bg-[#2121213d] v-card--reveal" style="height: 100%;">
             <div class="text-white w-full p-5">
               <h4 class="text-uppercase pt-5 caveat">В пакет входят услуги:</h4>
               <ul class="mt-5 ml-8 items">
                 <li v-for="item in itemData.services">
                   <span class="font-italic">{{item.title}}</span>
                 </li>
               </ul>
             </div>
            </div>
          </v-expand-transition>
          <div class="flex justify-start align-end">
            <img src="../assets/image/button.svg" class="button">
          </div>
        </v-img>
        <v-card-text class="pt-6 bg-[#F4F3F0]">
          <h4 class="text-uppercase pb-1 caveat">{{itemData.title}}</h4>
          <div class="text-grey caveat text-sm mb-2">
            <span class="text-base">Старая цена: {{itemData.old_price}}</span><span class="text-xl text-red font-italic">-{{itemData.discount}}%</span>
          </div>
          <div class="font-weight-light text-[#50735F] caveat text-h7 mb-2">
            Стоимость со скидкой: <span class="text-6 text-red font-italic">{{itemData.price}}</span>
            <span class="text-6 text-red font-italic">p.</span>
          </div>
          <v-btn color="orange" variant="flat"  @click="showCombo(itemData.id)" class="mt-2 text-white">
            Подробнее
          </v-btn>
          <div class="flex justify-end align-end w-full">
            <img src="../assets/image/raduga.svg" class="button">
          </div>
        </v-card-text>
      </v-card>
    </v-hover>
  </div>
</template>

<script>
export default {
  name: "Post.vue",
  props: {
    itemData: {
      type: Object,
      default:()=> {}
    }
  },
  methods:{
    showCombo(id){
      this.$emit('show', id);
    }
  },
}

</script>

<style scoped>
.items{
  max-height: 150px;
  overflow-y: auto;
  font-family: "Comforter", cursive;
  font-weight: 400;
  font-style: normal;
  font-size: 30px;
}
.list, .button{
  position: absolute;
}
.permanent-marker-regular {
  font-family: "Permanent Marker", cursive;
  font-weight: 400;
  font-style: normal;
}
.comforter-regular {
  font-family: "Comforter", cursive;
  font-weight: 400;
  font-style: normal;
}
.caveat{
  font-family: "Caveat", cursive;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
  font-size: 24px;
}
.icon{
  transform: rotate(17deg);
  padding-left: 2px;
}
</style>