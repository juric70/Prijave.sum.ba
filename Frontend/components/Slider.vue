<template>
  <section class="hero">
    <div class="button-container">
      <button class="hero-button" @click="showInfo(1)">Otvorene prijave</button>
      <button class="hero-button" @click="showInfo(2)">Zatvorene prijave</button>
      <button class="hero-button" @click="redirected()">Moje prijave</button>
    </div>
    <div class="hero-content">
      <div v-if="selectedButton === 1">
        <h2>Otvorene prijave</h2>
        <swiper
          :slides-per-view="slidesPerView"
          :space-between="30"
          :pagination="{ clickable: true }"
          :modules="modules"
          :navigation="true"
          class="mySwiper"
        >
          <swiper-slide v-for="(item, index) in otvoreneI" :key="index">
            <div style="color: white; background-color: lightslategray; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px solid #000; padding: 10px; margin: 5px; height: 300px;">
              <nuxt-link class="linkovi" :to="'/opisprijave?id=' + otvoreneId[index]"><h2>{{ item }}</h2>
              <h5>{{ otvoreneO[index] }}</h5></nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>
      <div v-else-if="selectedButton === 2">
        <h2>Zatvorene prijave</h2>
        <swiper
          :slides-per-view="slidesPerView"
          :space-between="30"
          :pagination="{ clickable: true }"
          :modules="modules"
          :navigation="true"
          class="mySwiper"
        >
          <swiper-slide v-for="(item, index) in zavrseneI" :key="index">
            <div style="color: white; background-color: lightslategray; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px solid #000; padding: 10px; margin: 5px; height: 300px;">
              <nuxt-link class="linkovi" :to="'/opisprijave?id=' + zavrseneId[index]"><h2>{{ item }}</h2>
              <h5>{{ zavrseneO[index] }}</h5></nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>
      <div v-else-if="selectedButton === 3">
        <h2>Moje prijave</h2>
        <swiper
          :slides-per-view="slidesPerView"
          :space-between="30"
          :pagination="{ clickable: true }"
          :modules="modules"
          :navigation="true"
          class="mySwiper"
        >
        <swiper-slide v-for="(item, index) in mojeI" :key="index">
            <div style="color: white; background-color: lightslategray; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px solid #000; padding: 10px; margin: 5px; height: 300px;">
              <nuxt-link class="linkovi" :to="'/opisprijave?id=' + mojeId[index]"><h2>{{ item }}</h2>
              <h5>{{ mojeO[index] }}</h5></nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
</template>





<script>
import { Swiper, SwiperSlide } from 'swiper/vue'; 
import 'swiper/swiper-bundle.css'; 
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Pagination, Navigation } from 'swiper/modules';
import { ref, onMounted } from 'vue';
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const slidesPerView = ref(3);
    const navigationOptions = ref({
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    });

    const updateResponsiveSettings = () => {
      if (window.innerWidth < 768) {
        slidesPerView.value = 1;
        navigationOptions.value = false;
      } else {
        slidesPerView.value = 3;
        navigationOptions.value = navigationOptions.value;
      }
    };

    onMounted(() => {
      updateResponsiveSettings();
      window.addEventListener('resize', updateResponsiveSettings);
    });

    return {
      slidesPerView,
      navigationOptions,
      modules: [Pagination, Navigation],
    };
  },
  data() {
    return {
      selectedButton: 1,
      otvoreneI: [],
      otvoreneId: [],
      otvoreneO: [],
      zavrseneI: [],
      zavrseneO: [],
      zavrseneId: [],
      mojeI: [],
      mojeO: [],
      mojeId: [],
      modules: [Pagination, Navigation],
      user: [],
    };
  },
  mounted() {
    this.fetchData();
    this.generirajHeader();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('http://localhost:8000/Radionica');
        this.zavrseneI = response.data.filter(item => new Date(item.PrijaveDo) > new Date()).map(item => item.NazivRadionice);
        this.zavrseneO = response.data.filter(item => new Date(item.PrijaveDo) > new Date()).map(item => item.OpisRadionice);
        this.zavrseneId = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.id);
        this.otvoreneI = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.NazivRadionice);
        this.otvoreneId = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.id);
        this.otvoreneO = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.OpisRadionice);
        this.mojeI = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.NazivRadionice);
        this.mojeId = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.id);
        this.mojeO = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.OpisRadionice);
      } catch (error) {
        console.error(error);
      }
    },
    redirected(){
      navigateTo("/prijave");
    },
    async generirajHeader(){
      try{
            let{data} = await axios.get("http://localhost:8000/api/user");
            this.user = data;
            this.napraviHeader(data);
            console.log(this.user);
          }
          catch(error){console.log(error)
            if(error.response.status == 401){
              document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/login' class='navbar-item' data-v-a81738bd>Login</a>";
              document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/login' class='mobile-nav-item' data-v-a81738bd>Login</a>";
            }
        }
      },
    async napraviHeader(data){
        switch(data.vrstaKorisnika){
          case 1:
          document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/korisnici' class='navbar-item' data-v-a81738bd>Korisnici</a>";
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/korisnici' class='mobile-nav-item' data-v-a81738bd>Korisnici</a>";
          case 2:
          document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/create' class='navbar-item' data-v-a81738bd>Kreiraj</a>";
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/create' class='mobile-nav-item' data-v-a81738bd>Kreiraj</a>";
          case 3:
          document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/prijave' class='navbar-item' data-v-a81738bd>Prijave</a>";
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/prijave' class='mobile-nav-item' data-v-a81738bd>Prijave</a>";

          document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/logout' class='navbar-item' data-v-a81738bd>Odjavi se</a>";
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/logout' class='mobile-nav-item' data-v-a81738bd>Odjavi se</a>";

          document.getElementsByClassName("navbar-end")[0].innerHTML += "<p class='navbar-item-dva' data-v-a81738bd>Pozdrav, " + data.name + "</p>";
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<p class='navbar-item-dva' data-v-a81738bd>Pozdrav, " + data.name + "</p>";
          
        }
      },
    showInfo(buttonNumber) {
      this.selectedButton = buttonNumber;
    },
  }
}
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
  max-width: 75%;
}

.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}
.hero h5 {

  padding: 10px;
  margin: 10px;
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

 .swiper-button-next,
 .swiper-button-prev {
    display: none;
  }

  .swiper-slide-content {
  color: white;
  background-color: lightslategray;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px solid #000;
  padding: 10px; /* Ensure padding is applied */
  margin: 5px;
  height: 300px;
}
}
.linkovi{
  color:white;
  text-decoration: none;
}
</style>