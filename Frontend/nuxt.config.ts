// https://nuxt.com/docs/api/configuration/nuxt-config
import viteSvgLoader from "vite-svg-loader";

export default {
  modules: ["vue3-carousel-nuxt"],
  devtools: { enabled: true },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  css: [
    './assets/style.css',
    '/assets/css/main.css',
  ],

  vite: {
    plugins: [viteSvgLoader()],
  },

  compatibilityDate: "2025-01-12",
};