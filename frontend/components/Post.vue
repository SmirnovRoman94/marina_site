<template>
<v-card class="mx-auto" max-width="400">
  <v-img class="align-end text-white" height="224" :src="itemData.image" cover>
  </v-img>
  <div class="p-5 text-[#50735F]">
    <v-card-subtitle class="pt-4">{{itemData.date}}</v-card-subtitle>
    <v-card-title class="title">{{itemData.title}}</v-card-title>
    <v-card-text>
      <div class="mt-1">
        {{text}}
      </div>
      <div class="mt-3">
        <span @click="showPost(itemData.id)" class="learn_more flex align-center underline decoration-dashed"><span class="pr-2">ЧИТАТЬ ДАЛЕЕ</span>
          <span>
            <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5098 7.97755C9.54143 9.25326 9.00038 10.7316 8.7937 11.7239L10.0119 12C10.1851 11.1683 10.6555 9.88029 11.487 8.78484C12.3113 7.69888 13.4568 6.84105 15 6.73483L15 5.43582C13.9172 5.43582 11.0797 4.46174 10.0074 9.53674e-07L8.7982 0.316245C9.40716 2.85009 10.5441 4.46124 11.736 5.43582L0 5.43582L0 6.73624L11.6947 6.73624C11.2414 7.10744 10.8476 7.53248 10.5098 7.97755Z" fill="#50735F"/>
            </svg>
          </span>
        </span>
      </div>
    </v-card-text>
  </div>
</v-card>
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
  computed: {
   text(){
     if (this.itemData?.preview.split(' ').length > 15) {
       return this.itemData.preview.split(' ').slice(0, 15).join(' ') + '...';
     } else {
       return this.itemData.preview;
     }
   }
  },
  methods:{
    showPost(id){
      this.$emit('show', id);
    }
  },
}

</script>

<style scoped>
.title{
  font-size: 20px;
  text-transform: uppercase;
}
.learn_more{
  transition: all ease .5s;
  cursor: pointer;
}
.learn_more:hover{
 transform: scale(1.02);
}
</style>