<template>
  <div>
    <div class="header">
      <nuxt-link to="/"
        ><img
          src="/sumit-Photoroom.png"
          alt="SUMIT icon"
          class="logo"
      /></nuxt-link>
      <div class="navbar-end">
        <nuxt-link
          to="/"
          id="testiramovo"
          class="navbar-item"
          >Home</nuxt-link
        >
        <nuxt-link
          to="/about"
          class="navbar-item"
          >About Us</nuxt-link
        >
        <nuxt-link
          to="/radionice"
          v-if="user !== null"
          class="navbar-item"
          >Prijave</nuxt-link
        >

        <!-- Trenutno ugradjena verzija za pretvaranje podataka u Excel (zasad samo smeta)
        <button @click="fetchDataAndDownload()">Download Data as CSV</button>-->
      </div>
      <div class="navbar-end">
        <nuxt-link
          to="/korisnici"
          v-if="user !== null && permissionLevel(1)"
          class="navbar-item"
          >Korisnici</nuxt-link
        >
        <nuxt-link
          to="/kreiraj"
          v-if="user !== null && permissionLevel(2)"
          class="navbar-item"
          >Kreiraj</nuxt-link
        >
        <nuxt-link
          to="/logout"
          v-if="user !== null"
          class="navbar-item"
          >Odjavi se</nuxt-link
        >
        <nuxt-link
          to="/login"
          v-if="user === null"
          class="navbar-item"
          >Login</nuxt-link
        >
        <p v-if="user !== null">Pozdrav, {{ user.name }}</p>
      </div>
      <div
        class="hamburger"
        @click="toggleMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div
      class="mobile-menu"
      v-show="menuOpen">
      <nuxt-link
        to="/"
        class="mobile-nav-item"
        >Home</nuxt-link
      >
      <nuxt-link
        to="/about"
        class="mobile-nav-item"
        >About Us</nuxt-link
      >
      <nuxt-link
        to="/korisnici"
        v-if="user !== null && permissionLevel(1)"
        class="mobile-nav-item"
        >Korisnici</nuxt-link
      >
      <nuxt-link
        to="/kreiraj"
        v-if="user !== null && permissionLevel(2)"
        class="mobile-nav-item"
        >Kreiraj</nuxt-link
      >
      <nuxt-link
        to="/radionice"
        v-if="user !== null"
        class="mobile-nav-item"
        >Prijave</nuxt-link
      >
      <nuxt-link
        to="/logout"
        v-if="user !== null"
        class="mobile-nav-item"
        >Odjavi se</nuxt-link
      >
      <p v-if="user !== null">Pozdrav, {{ user.name }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import type User from "~/lib/types/User";
import type UserType from "~/lib/types/UserType";
import { permissionGranted } from "~/lib/utils";

const menuOpen = ref(false);
// Define your jsonToCsv function here
/* function jsonToCsv(jsonData) {
const keys = Object.keys(jsonData[0]);
const csvRows = jsonData.map(row => keys.map(key => `"${row[key]}"`).join(','));
return `${keys.join(',')} \n${csvRows.join('\n')}`;
} */

const testFunc = () => {
  alert("hi!");
};

/* async function fetchDataAndDownload() {
const response = await fetch('http://localhost:8000/SvePrijave/10');
const data = await response.json();

const csvData = jsonToCsv(data);
const blob = new Blob([csvData], { type: 'text/csv;charset=utf-8;' });
const url = URL.createObjectURL(blob);
const link = document.createElement('a');
link.href = url;
link.setAttribute('download', 'output.csv');
document.body.appendChild(link);
link.click();
document.body.removeChild(link);
} */

const user = useSanctumUser<User>();

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};

const permissionLevel = (type: UserType) => {
  if (user.value === null) {
    return false;
  }

  return permissionGranted(user.value.vrstaKorisnika, type);
};

// Call fetchDataAndDownload when the component mounts
//onMounted(fetchDataAndDownload);
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  overflow-x: hidden;
}

.header {
  background-color: transparent;
  width: 100vw;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
  z-index: 999;
  flex-shrink: 0; /* Prevents header and footer from shrinking */
}

.logo {
  height: 100%;
  max-height: 80px;
  width: auto;
}

.search-field {
  padding: 5px 10px;
  border: none;
  border-bottom: 1px solid grey;
  font-size: 16px;
  background-color: transparent;
  transition: all 0.3s ease;
}

.search-field:focus {
  border: 2px solid #014479;
  box-shadow: 0 0 5px rgba(1, 68, 121, 0.5);
  background-color: white;
}

.navbar-end {
  display: flex;
  align-items: center;
}

.navbar-item {
  color: white;
  text-decoration: none;
  font-size: 1.2rem;
  margin: 0 20px;
}

.navbar-item:hover {
  color: rgb(182, 182, 182);
  cursor: pointer;
}

.hamburger {
  display: none;
  flex-direction: column;
  cursor: pointer;
}

.hamburger span {
  height: 3px;
  width: 25px;
  background-color: white;
  margin: 4px;
  transition: all 0.3s ease;
}

.mobile-menu {
  display: none;
  flex-direction: column;
  background-color: #014479;
  padding: 20px;
}

.mobile-nav-item {
  color: white;
  text-decoration: none;
  font-size: 1.25rem;
  margin: 10px 0;
}

.mobile-nav-item:hover {
  color: rgb(182, 182, 182);
}

@media (max-width: 768px) {
  .navbar-end {
    display: none;
  }

  .hamburger {
    display: flex;
  }

  .mobile-menu {
    display: flex;
  }
}
.Buttoni {
  background-color: #101d2f;
  border-radius: 8px;
  padding: 10px 20px;
  margin: 20px 20px;
  border: none;
  transition: all 0.3s ease;
  color: white;
  cursor: pointer;
  text-align: center;
}

.Buttoni:hover {
  background-color: #080f18;
}
</style>
