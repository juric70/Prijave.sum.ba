<template></template>
<script setup>
import { ref } from 'vue';
const data = ref([]);

async function fetchData() {
  const response = await fetch('http://localhost:8000/Radionica');
  data.value = await response.json();
}
fetchData();
</script>