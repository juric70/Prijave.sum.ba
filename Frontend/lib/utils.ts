import type UserType from "~/lib/types/UserType";

/**
 * Funkcija koja provjerava je li je korisnik odobren za pristup.
 *
 * Vece razine korisnika imaju pristup nizim razinama (npr. SuperAdmin ima pristup svemu sto i Kreator, i Kreator ima pristup svemu i sto obicni korisnik).
 *
 * Razine su obrnuto poredane, tj. SuperAdmin je 1, Kreator je 2, a obicni korisnik je 3. Ne-logirani korisnik je 0.
 *
 * @param userType Vrsta korisnika koju provjeravamo
 * @param requiredUserType Vrsta korisnika koja je potrebna za pristup
 * @returns {boolean} true ako je korisnik odobren za pristup, false inace
 */
export function permissionGranted(
  userType: UserType,
  requiredUserType: UserType
): boolean {
  return userType <= requiredUserType;
}
