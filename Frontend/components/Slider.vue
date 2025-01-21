<template>
  <div class="hero-image bg-[#e3e3e3] bg-cover bg-center h-[20rem] sm:h-[30rem]" style="background-image: url('/ovdje/ide/custom/path/slika.jpg');">
    <div class="flex flex-col items-center justify-center h-full px-4 text-center">
      <h1 class="text-3xl sm:text-4xl font-bold text-[#094776]">Dobrodošli na PRIJAVE</h1>
      <p class="text-base sm:text-lg text-gray-700 mt-2 sm:mt-4">Ovo je samo placeholder za sliku</p>
    </div>
  </div>
  <section class="min-h-[50vh] bg-gradient-to-b from-gray-50 to-gray-100 py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-8 mb-10 sm:mb-14">
      <button 
        @click="showInfo(1)"
        :class="['px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none', 
          selectedButton === 1 ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2' : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2']"
      >
        Otvorene prijave
      </button>
      <button 
        @click="showInfo(2)"
        :class="['px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none', 
          selectedButton === 2 ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2' : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2']"
      >
        Zatvorene prijave
      </button>
      <button 
        @click="redirected()"
        :class="['px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none', 
          selectedButton === 3 ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2' : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2']"
      >
        Moje prijave
      </button>
    </div>

    <div class="max-w-4xl mx-auto relative">
      <div v-if="selectedButton === 1" class="transition-all duration-500 ease-in-out">
        <swiper
          :effect="'coverflow'"
          :grabCursor="true"
          :centeredSlides="true"
          :slidesPerView="1"
          :breakpoints="{
            640: { slidesPerView: 1.5 },
            1024: { slidesPerView: slidesPerView }
          }"
          :coverflowEffect="{
            rotate: 30,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true
          }"
          :pagination="true"
          :navigation="true"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="(item, index) in otvoreneI" :key="index" class="transform transition-all duration-300 hover:scale-105">
            <div class="bg-gradient-to-br from-[#094776] to-[#0a5992] text-white rounded-xl shadow-2xl p-6 sm:p-8 flex flex-col items-center justify-center h-60 sm:h-80 backdrop-blur-lg border border-blue-400/20">
              <nuxt-link 
                :to="'/opisprijave?id=' + otvoreneId[index]"
                class="group transition-all duration-300 text-center transform hover:-translate-y-1"
              >
                <h2 class="text-xl sm:text-3xl font-bold mb-4 sm:mb-6 group-hover:text-blue-200">{{ item }}</h2>
                <h5 class="text-sm sm:text-lg text-blue-100">{{ otvoreneO[index] }}</h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>

      <div v-else-if="selectedButton === 2" class="transition-all duration-500 ease-in-out">
        <swiper
          :effect="'coverflow'"
          :grabCursor="true"
          :centeredSlides="true"
          :slidesPerView="slidesPerView"
          :coverflowEffect="{
            rotate: 30,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true
          }"
          :pagination="true"
          :navigation="true"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="(item, index) in zavrseneI" :key="index" class="transform transition-all duration-300 hover:scale-105">
            <div class="bg-gradient-to-br from-[#094776] to-[#0a5992] text-white rounded-xl shadow-2xl p-6 sm:p-8 flex flex-col items-center justify-center h-60 sm:h-80 backdrop-blur-lg border border-blue-400/20">
              <nuxt-link 
                :to="'/opisprijave?id=' + zavrseneId[index]"
                class="group transition-all duration-300 text-center transform hover:-translate-y-1"
              >
              <h2 class="text-xl sm:text-3xl font-bold mb-4 sm:mb-6 group-hover:text-blue-200">{{ item }}</h2>
                <h5 class="text-sm sm:text-lg text-blue-100">{{ zavrseneO[index] }}</h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>

      <div v-else-if="selectedButton === 3" class="transition-all duration-500 ease-in-out">
        <swiper
          :slides-per-view="slidesPerView"
          :space-between="30"
          :pagination="{ 
            clickable: true,
            dynamicBullets: true
          }"
          :modules="modules"
          :navigation="true"
          :effect="'coverflow'"
          :coverflowEffect="{
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true
          }"
          class="mySwiper"
        >
          <swiper-slide v-for="(item, index) in mojeI" :key="index" class="transform transition-all duration-300 hover:scale-105">
            <div class="bg-gradient-to-br from-[#094776] to-[#0a5992] text-white rounded-xl shadow-2xl p-8 flex flex-col items-center justify-center h-80 backdrop-blur-lg border border-blue-400/20">
              <nuxt-link 
                :to="'/opisprijave?id=' + mojeId[index]"
                class="group transition-all duration-300 text-center transform hover:-translate-y-1"
              >
                <h2 class="text-3xl font-bold mb-6 group-hover:text-blue-200">{{ item }}</h2>
                <h5 class="text-lg text-blue-100">{{ mojeO[index] }}</h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
  <div class="pb-12 bg-gray-100"></div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue'; 
import 'swiper/swiper-bundle.css'; 
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-coverflow';
import { Pagination, Navigation, EffectCoverflow } from 'swiper/modules';
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
      modules: [Pagination, Navigation, EffectCoverflow],
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
      modules: [Pagination, Navigation, EffectCoverflow],
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
        this.zavrseneI = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.NazivRadionice);
        this.zavrseneO = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.OpisRadionice);
        this.zavrseneId = response.data.filter(item => new Date(item.PrijaveDo) < new Date()).map(item => item.id);
        this.otvoreneI = response.data.filter(item => new Date(item.PrijaveDo) > new Date()).map(item => item.NazivRadionice);
        this.otvoreneId = response.data.filter(item => new Date(item.PrijaveDo) > new Date()).map(item => item.id);
        this.otvoreneO = response.data.filter(item => new Date(item.PrijaveDo) > new Date()).map(item => item.OpisRadionice);
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
:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
  background-color: white;
  padding: 1.5rem;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  transition: all 0.3s ease;
  opacity: 0.8;
}

:deep(.swiper-button-next:hover),
:deep(.swiper-button-prev:hover) {
  opacity: 1;
  transform: scale(1.1);
}

:deep(.swiper-button-next::after),
:deep(.swiper-button-prev::after) {
  font-size: 1rem;
  font-weight: bold;
  color: #D22D3A;
}

:deep(.swiper-pagination-bullet) {
  background-color: #D22D3A;
  opacity: 0.5;
  transition: all 0.3s ease;
}

:deep(.swiper-pagination-bullet-active) {
  opacity: 1;
  transform: scale(1.2);
  border: 1.5px white solid;
}
</style>