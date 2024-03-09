<template>
  <v-card class="mx-auto" max-width="500">
    <div class="card">
      <v-card-title class="title">{{productItem.title}}</v-card-title>
      <v-card-text class="h-100">
        <div class="end_content">
          <div class="end_content_left">
            <span class="price">{{productItem.price}} рублей</span>
            <v-btn color="orange" variant="flat"  @click="showProduct(productItem.id)" class="mt-2 text-white">
              Подробнее
            </v-btn>
          </div>
          <div class="end_content_right">
            <img src="../assets/image/list_service.svg" class="list">
            <img src="../assets/image/surprice.svg" class="list1">
            <img src="../assets/image/list_service.svg" class="list2">
          </div>
        </div>
      </v-card-text>
    </div>
  </v-card>
</template>

<script>
export default {
  name: "Product.vue",
  props: {
    productItem: {
      type: Object,
      default:()=> {}
    }
  },
  methods:{
    showProduct(id){
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
.end_content {
  margin-top: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.end_content_left{
  display: flex;
  flex-direction: column;

}
.price {
  color: #C58A46;
  display: block;
}
.end_content_right{
  display: flex;
}
.list{
  width: 70px;
  height: 70px;
  transform: rotate(27grad);
}
.list1{
  margin: 0 30px;
  width: 80px;
  height: 80px;
  transform: rotate(-27grad);
}
</style>