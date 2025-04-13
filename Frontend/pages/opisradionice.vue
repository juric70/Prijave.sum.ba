<script setup lang="ts">
definePageMeta({
  middleware: ["sanctum:auth:creator", "radionica-middleware"],
});
</script>

<template>
  <div>
    <OpisRadionice></OpisRadionice>
  </div>
</template>
