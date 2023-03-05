<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <header>
    <div class="wrapper flex mx-2.5">
      <h1 class="text-4xl flex-initial mx-2.5">Weather Report</h1>
      <nav class="flex-initial mx-3.5 my-3">
        <RouterLink to="/">Home</RouterLink>
      </nav>
    </div>
  </header>
  <RouterView />
</template>

<style scoped>

</style>
