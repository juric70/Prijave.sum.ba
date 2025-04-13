import type { RouteLocationAsPathGeneric } from "vue-router";
import type Prijava from "~/lib/types/Prijava";
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

  // na `/prijava` rutu na frontendu se dolazi sa query parametrom ali se na backend salje path parametar?
  const prijavaId = to.query.id;
  const { data: prijavaData, error: prijavaError } =
    await useSanctumFetch<Prijava>(
      `http://localhost:8000/ListaPrijava/${prijavaId}`
    );

  if (prijavaError.value || prijavaData.value === null) {
    throw new Error("Prijava nije pronađena");
  }

  const userOwnsPage = prijavaData.value.IdKreatora === user.id;

  // 1. Slucaj: korisnik je obicni korisnik i on je kreator ove prijave
  if (userOwnsPage) {
    return;
  }

  // 2. Slucaj: korisnik je kreator i on je kreator ove radionice (ne nuzno i prijave)
  if (permissionGranted(user.vrstaKorisnika, UserType.Creator)) {
    const { data: radionicaData, error: radionicaError } =
      await useSanctumFetch<Radionica>(
        `http://localhost:8000/Radionica/${prijavaData.value.IdRadionice}`
      );

    if (radionicaError.value || radionicaData.value === null) {
      throw new Error("Radionica nije pronađena");
    }

    if (radionicaData.value.IdKreatora === user.id) {
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
