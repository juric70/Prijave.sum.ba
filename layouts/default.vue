<!-- layouts/default.vue -->
<template>
    <div>
      <Header />
      <NuxtPage />
      <!-- <Footer /> -->
    </div>
  </template>

  <script>
  import Header from '~/components/Header.vue';
    // import Footer from '~/components/Footer.vue';
    // AKO ZELITE I FOOTER ISTO KAO I HEADER DA SE SAM POZIVA, SAMO UNCOMMENT U OVOM FILE I IZBRISAT U OSTALIMA GDJE SE POZIVA
    
  
  export default {
    components: {
      Header
    //   Footer
    }
  };
  </script>
  