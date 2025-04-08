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

  <style>
    body{
      background-image: radial-gradient(circle at top right, #c12f3f, #b72e40,#ac3043,#8c344c,#54395a,#423b60,#094776, #094776, #094776, #094776, #094776);
      background-position: center center;
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
  