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
      background-image: linear-gradient(to top right, #3a3c60, #423b60,#54395a,#673554,#7d334d,#8c344c,#ac3043,#b72e40,#c12f3f);
      background-position: center center;
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
  