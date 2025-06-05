<script>
import axios from "axios";
axios.defaults.withCredentials = true;

const { logout } = useSanctumAuth();

export default {
  mounted() {
    this.odjavi();
  },
  methods: {
    async odjavi() {
      try {
        await logout();
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<template>
  <div id="logout">Logout</div>
</template>

<style>
#logout {
  min-height: 100vh;
  background-color: transparent;
  color: transparent;
}
</style>
