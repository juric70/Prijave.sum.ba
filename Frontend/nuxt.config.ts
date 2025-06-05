// https://nuxt.com/docs/api/configuration/nuxt-config
import viteSvgLoader from "vite-svg-loader";

export default defineNuxtConfig({
  modules: ["vue3-carousel-nuxt", "nuxt-auth-sanctum"],
  typescript: {
    typeCheck: true,
  },
  devtools: { enabled: true },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  css: ["./assets/style.css", "/assets/css/main.css"],

  vite: {
    plugins: [viteSvgLoader()],
  },

  app: {
    head: {
      link: [
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap",
        },
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap", // Dodajte Roboto font
        },
      ],
    },
  },

  sanctum: {
    baseUrl: "http://localhost:8000",
    redirect: {
      keepRequestedRoute: true,
    },
    redirectIfAuthenticated: true,
    redirectIfUnauthenticated: true,
  },

  compatibilityDate: "2025-01-12",
});
