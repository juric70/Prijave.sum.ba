import type { RouteLocationAsPathGeneric } from "vue-router";
import type User from "~/lib/types/User";
import UserType from "~/lib/types/UserType";
import { permissionGranted } from "~/lib/utils";

export default defineNuxtRouteMiddleware(to => {
  const options = useSanctumConfig();
  const { user, isAuthenticated } = useSanctumAuth<User>();

  if (isAuthenticated.value && user.value !== null) {
    if (permissionGranted(user.value.vrstaKorisnika, UserType.SuperAdmin)) {
      return;
    }
  }

  const endpoint = options.redirect.onAuthOnly;

  if (endpoint === undefined) {
    throw new Error("`sanctum.redirect.onAuthOnly` is not defined");
  }

  if (endpoint === false) {
    throw createError({ statusCode: 403 });
  }

  const redirect: RouteLocationAsPathGeneric = { path: endpoint };

  if (options.redirect.keepRequestedRoute) {
    redirect.query = { redirect: to.fullPath };
  }

  return navigateTo(redirect, { replace: true });
});
