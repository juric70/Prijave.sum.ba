<script setup lang="ts">
definePageMeta({
  middleware: ["sanctum:auth"],
});
</script>

<template>
  <div>
    <PrijavljivanjePage></PrijavljivanjePage>
  </div>
</template>
