<template>
  <section class="hero">
    <div class="button-container">
      <button class="hero-button" @click="showInfo(1)">Otvorene prijave</button>
      <button class="hero-button" @click="showInfo(2)">Zatvorene prijave</button>
      <button class="hero-button" @click="showInfo(3)">Moje prijave</button>
      <button class="hero-button" @click="showInfo(4)">Aktivno</button>
    </div>
    <div class="hero-content">
      <div v-if="selectedButton === 1">
        <h2>Otvorene prijave</h2>
        <p>{{ courses.data }}</p>
      </div>
      <div v-else-if="selectedButton === 2">
        <h2>Zatvorene prijave</h2>
        <p>Description 2</p>
      </div>
      <div v-else-if="selectedButton === 3">
        <h2>Moje prijave</h2>
        <p>Description 3</p>
      </div>
      <div v-else-if="selectedButton === 4">
        <h2>Aktivno</h2>
        <p>Description 4</p>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      selectedButton: 1,
      courses: [],
    };
  },
  mounted(){
    this.getCurses();
  },
  methods: {
    async getCurses(){

      try {
        axios.get('http://localhost:8000/Radionica').then(res =>{
          this.courses = res
        })
      } catch (error) {
        this.error = error.response ? error.response.data : error.message
      }
      },

    showInfo(buttonNumber) {
      this.selectedButton = buttonNumber;
    }
  }
};
</script>

<style scoped>
.hero {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  max-width: 100%;
  background-color: white;
  color: black;
  text-align: center;
  padding: 20px;
  box-sizing: border-box;
}

.hero-content {
  max-width: 800px;
}

.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 40px;
}

.button-container {
  display: flex;
  justify-content: center;
  margin: 20px 0;
}

.hero-button {
  background-color: rgba(16, 29, 47, 0.83);
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 0 5px;
  font-size: 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 25%;
  max-width: 180px;
}

.hero-button:hover {
  background-color: rgba(16, 28, 44, 0.9);
}

@media (max-width: 768px) {
  .hero h1 {
    font-size: 2rem;
  }

  .hero p {
    font-size: 1rem;
  }
}
</style>