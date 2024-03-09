<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="8">
        <nuxt-link to="/admin/patients" class="text-sm border-b hover:text-cyan-700">Назад</nuxt-link>
        <v-form  @submit.prevent="createDiplom" ref="form" class="mt-5">

        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

</script>

<style scoped>

</style>