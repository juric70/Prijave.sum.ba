<script setup lang="ts">
import PrijavaPage from "~/components/PrijavaPage.vue";

definePageMeta({
  middleware: ["sanctum:auth", "prijava-middleware"],
});
</script>

<template>
  <div>
    <PrijavaPage></PrijavaPage>
  </div>
</template>
