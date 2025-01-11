// https://nuxt.com/docs/api/configuration/nuxt-config
import viteSvgLoader from "vite-svg-loader";

export default {
  modules: ["vue3-carousel-nuxt"],
  devtools: { enabled: true },

  css: [
    './assets/style.css'
  ],
  

  vite: {
    plugins: [viteSvgLoader()],
  },
};
