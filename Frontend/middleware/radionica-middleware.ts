import type { RouteLocationAsPathGeneric } from "vue-router";
import type Radionica from "~/lib/types/Radionica";
import type User from "~/lib/types/User";
import UserType from "~/lib/types/UserType";
import { permissionGranted } from "~/lib/utils";

export default defineNuxtRouteMiddleware(async to => {
  const options = useSanctumConfig();
  const user = useSanctumUser().value as User;

  if (permissionGranted(user.vrstaKorisnika, UserType.SuperAdmin)) {
    return;
  }

  const radionicaId = to.query.id;
  const { data: radionicaData, error: radionicaError } =
    await useSanctumFetch<Radionica>(
      `http://localhost:8000/Radionica/${radionicaId}`
    );

  if (radionicaError.value || radionicaData.value === null) {
    throw new Error("Radionica nije pronađena");
  }

  const userOwnsPage = radionicaData.value.IdKreatora === user.id;

  if (userOwnsPage) {
    return;
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
