<template>
  <div
    class="hero-image h-[20rem] bg-[#e3e3e3] bg-cover bg-center sm:h-[30rem]"
    style="
      background-color: transparent;
    ">
    <div
      class="flex h-full flex-col items-center justify-center px-4 text-center">
      <h1 class="text-3xl font-bold text-[#ffffff] sm:text-4xl">
        Dobrodošli na PRIJAVE
      </h1>
      <p class="mt-2 text-base text-gray-700 sm:mt-4 sm:text-lg text-[#ffffff]">
        Ovo je samo placeholder za sliku
      </p>
    </div>
  </div>
  <section
    class="min-h-[50vh] bg-transparent px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <div
      class="mb-10 flex flex-col justify-center gap-4 sm:mb-14 sm:flex-row sm:gap-8">
      <button
        @click="showInfo(1)"
        :class="[
          'transform rounded-lg px-4 py-2 shadow-md transition-all duration-300 hover:scale-105 focus:outline-none sm:px-6 sm:py-3',
          selectedButton === 1
            ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2'
            : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2',
        ]">
        Otvorene prijave
      </button>
      <button
        @click="showInfo(2)"
        :class="[
          'transform rounded-lg px-4 py-2 shadow-md transition-all duration-300 hover:scale-105 focus:outline-none sm:px-6 sm:py-3',
          selectedButton === 2
            ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2'
            : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2',
        ]">
        Zatvorene prijave
      </button>
      <button
        @click="redirected()"
        :class="[
          'transform rounded-lg px-4 py-2 shadow-md transition-all duration-300 hover:scale-105 focus:outline-none sm:px-6 sm:py-3',
          selectedButton === 3
            ? 'bg-red-800 text-white ring-2 ring-[#D22D3A] ring-offset-2'
            : 'bg-[#D22D3A] text-white hover:bg-red-800 focus:ring-2 focus:ring-[#D22D3A] focus:ring-offset-2',
        ]">
        Moje prijave
      </button>
    </div>

    <div class="relative mx-auto max-w-4xl">
      <div
        v-if="selectedButton === 1"
        class="transition-all duration-500 ease-in-out">
        <swiper
          :effect="'coverflow'"
          :grabCursor="true"
          :centeredSlides="true"
          :slidesPerView="1"
          :breakpoints="{
            640: { slidesPerView: 1.5 },
            1024: { slidesPerView: slidesPerView },
          }"
          :coverflowEffect="{
            rotate: 30,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
          }"
          :pagination="true"
          :navigation="true"
          :modules="modules"
          class="mySwiper">
          <swiper-slide
            v-for="(item, index) in otvoreneI"
            :key="index"
            class="transform transition-all duration-300 hover:scale-105">
            <div
              class="flex h-60 flex-col items-center justify-center rounded-xl border border-blue-400/20 bg-gradient-to-br from-[#094776] to-[#0a5992] p-6 text-white shadow-2xl backdrop-blur-lg sm:h-80 sm:p-8">
              <nuxt-link
                :to="'/opisradionice?id=' + otvoreneId[index]"
                class="group transform text-center transition-all duration-300 hover:-translate-y-1">
                <h2
                  class="mb-4 text-xl font-bold group-hover:text-blue-200 sm:mb-6 sm:text-3xl">
                  {{ item }}
                </h2>
                <h5 class="text-sm text-blue-100 sm:text-lg">
                  {{ otvoreneO[index] }}
                </h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>

      <div
        v-else-if="selectedButton === 2"
        class="transition-all duration-500 ease-in-out">
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
            slideShadows: true,
          }"
          :pagination="true"
          :navigation="true"
          :modules="modules"
          class="mySwiper">
          <swiper-slide
            v-for="(item, index) in zavrseneI"
            :key="index"
            class="transform transition-all duration-300 hover:scale-105">
            <div
              class="flex h-60 flex-col items-center justify-center rounded-xl border border-blue-400/20 bg-gradient-to-br from-[#094776] to-[#0a5992] p-6 text-white shadow-2xl backdrop-blur-lg sm:h-80 sm:p-8">
              <nuxt-link
                :to="'/opisradionice?id=' + zavrseneId[index]"
                class="group transform text-center transition-all duration-300 hover:-translate-y-1">
                <h2
                  class="mb-4 text-xl font-bold group-hover:text-blue-200 sm:mb-6 sm:text-3xl">
                  {{ item }}
                </h2>
                <h5 class="text-sm text-blue-100 sm:text-lg">
                  {{ zavrseneO[index] }}
                </h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>

      <div
        v-else-if="selectedButton === 3"
        class="transition-all duration-500 ease-in-out">
        <swiper
          :slides-per-view="slidesPerView"
          :space-between="30"
          :pagination="{
            clickable: true,
            dynamicBullets: true,
          }"
          :modules="modules"
          :navigation="true"
          :effect="'coverflow'"
          :coverflowEffect="{
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
          }"
          class="mySwiper">
          <swiper-slide
            v-for="(item, index) in mojeI"
            :key="index"
            class="transform transition-all duration-300 hover:scale-105">
            <div
              class="flex h-80 flex-col items-center justify-center rounded-xl border border-blue-400/20 bg-gradient-to-br from-[#094776] to-[#0a5992] p-8 text-white shadow-2xl backdrop-blur-lg">
              <nuxt-link
                :to="'/opisradionice?id=' + mojeId[index]"
                class="group transform text-center transition-all duration-300 hover:-translate-y-1">
                <h2 class="mb-6 text-3xl font-bold group-hover:text-blue-200">
                  {{ item }}
                </h2>
                <h5 class="text-lg text-blue-100">{{ mojeO[index] }}</h5>
              </nuxt-link>
            </div>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
  <div class="bg-transparent pb-12"></div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "swiper/css/effect-coverflow";
import { Pagination, Navigation, EffectCoverflow } from "swiper/modules";
import { ref, onMounted } from "vue";
import axios from "axios";
axios.defaults.withCredentials = true;

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const slidesPerView = ref(3);
    const navigationOptions = ref({
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
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
      window.addEventListener("resize", updateResponsiveSettings);
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
  },
  methods: {
    async fetchData() {
      try {
        const response = (await axios.get("http://localhost:8000/Radionica"))
          .data;
        this.zavrseneI = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.NazivRadionice);
        this.zavrseneO = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.OpisRadionice);
        this.zavrseneId = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.id);
        this.otvoreneI = response.data
          .filter(item => new Date(item.PrijaveDo) > new Date())
          .map(item => item.NazivRadionice);
        this.otvoreneId = response.data
          .filter(item => new Date(item.PrijaveDo) > new Date())
          .map(item => item.id);
        this.otvoreneO = response.data
          .filter(item => new Date(item.PrijaveDo) > new Date())
          .map(item => item.OpisRadionice);
        this.mojeI = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.NazivRadionice);
        this.mojeId = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.id);
        this.mojeO = response.data
          .filter(item => new Date(item.PrijaveDo) < new Date())
          .map(item => item.OpisRadionice);
      } catch (error) {
        console.error(error);
      }
    },
    redirected() {
      navigateTo("/radionice");
    },
    showInfo(buttonNumber) {
      this.selectedButton = buttonNumber;
    },
  },
};
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
  color: #d22d3a;
}

:deep(.swiper-pagination-bullet) {
  background-color: #d22d3a;
  opacity: 0.5;
  transition: all 0.3s ease;
}

:deep(.swiper-pagination-bullet-active) {
  opacity: 1;
  transform: scale(1.2);
  border: 1.5px white solid;
}

#mojaStikla {
  background-color: green;
}
</style>
