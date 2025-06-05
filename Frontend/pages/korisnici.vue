<script setup lang="ts">
definePageMeta({
  middleware: ["sanctum:auth:superadmin"],
});
</script>

<template>
  <div>
    <Korisnici />
  </div>
</template>
