<script setup lang="ts">
definePageMeta({
  middleware: ["sanctum:auth:creator"],
});
</script>

<template>
  <div>
    <KreirajPage />
  </div>
</template>
