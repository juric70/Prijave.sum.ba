# OBAVEZNO PROČITATI PRIJE POKRETANJA

> [!NOTE]
> Ako imate drugi način pokretanja projekta, slobodno, ovo je samo moj način, definitivno ne
> optimalan, ali trebao bi raditi.

Pozdrav ekipa, nadam se da ste otvorili ovo prije nego li pokrenete projekt prvi put :D

Ako pravili promjene u bazi, provjerite je li trebalo doći do promjene u modelima, kontrolerima, migracijama,
rutama, factories-ima i seederu.

U ovom dokumentu se nalaze sljedeća poglavlja:

- Osnovni zahtjevi za pokretanje projekta
- Pokretanje projekta prvi put
- Kako generirati generične podatke
- Osnovne postavke projekta
- Slanje promjena na Git
- Pokretanje kroz Docker

## OSNOVNI ZAHTJEVI ZA POKRETANJE PROJEKTA

- Imati instalirano: MySQL, PHP, composer, NodeJS
- Programi koji imaju alternative: Laragon, VSCode, GitBash
- Osobna preporuka za testiranje aplikacije: Postman, MySQL Workbench

## POKRETANJE PROJEKTA PRVI PUT

Prvi korak je odraditi `git pull` (ili `git clone`, kako preferirate) da bi preuzeli projekt.
Jedna od opcija je da instalirate pa otvorite git bash, te ga otvorite u mapi gdje želite preuzeti projekt.
Nakon toga upisujete komande `git init`, `git pull https://github.com/juric70/Prijave.sum.ba.git`

Zatim odmah (da ne bi došlo do zabune kasnije) prebacite se na neki drugi branch naredbom:
`git checkout -b mojeIme/FeatureKojiRadite`

Da bi pokrenuli Front stranice, idete sa sljedećim naredbama:
`cd .\Frontend\`, `code .`
Nakon što se folder sa Frontom otvori u VS code, u njegovom terminalu pokrenite naredbe:
`npm init`, `npm install`, `npm run dev`

Prije pokretanja Back-a stranice, osigurajte da vam je pokrenuta baza podataka (na portu 3306).
Jedna od opcija je skidanje Laragon-a, te pokretanje baze podataka preko njega.

Da bi pokrenuli Back stranice, idete sa sljedećim naredbama:
`cd ..\Backend\`, `code .`
(Dvije točke znače da se vraćate u prethodni direktorij, potrebno samo ako ste već ulazili u Front)

Nakon što se folder sa Frontom otvori u VS code, u njegovom terminalu pokrenite naredbe:
`composer update`, `composer install`, `php artisan migrate --seed`, `php artisan serve`

U slučaju da ste već generirali tablice u bazi, opcija `php artisan migrate --seed` može biti nepotrebna

U slučaju da su vam se lose nasumično generirali podatci, možete odraditi naredbu:
`php artisan migrate:fresh --seed`

## SLANJE PROMJENA NA GIT

Za poslati promjene na Git kada završite sa svojim Feature-om, prvo provjerite da niste na branchu `main` ili `master`. Ako jeste, odradite `git checkout -b mojeIme/FeatureKojiRadite`.
Zatim pozovite naredbe: `git add .`, `git commit -m "Opišite šta ste promjenili"`,
`git push --set-upstream https://github.com/juric70/Prijave.sum.ba.git imeBrancha`

## OSNOVNE POSTAVKE PROJEKTA

- Default konekcija za bazu je na portu 3306, user: "prijave", šifra "prijave", nalazi se u `.\Backend\.env\` i
  morate je prilagoditi tako da odgovara vašem MySQL accountu. Baza podataka se po default zove "prijave".
- Generiran je Administratorski račun (login "admin@example.com", sifra "password") koji je ujedno i kreator
  svih radionica koje su po defaultu napravljene.
- Login za svaki račun je njegov mail + "password" za šifru.
- Podatci u bazi su djelomično nasumično generirani
- Podatci su tu samo da olakšaju rad sa projektom, možda nisu točni ni ispravno unešeni

## POKRETANJE KROZ DOCKER

### Što je Docker

Docker je program koji je koristan ako želite pokrenuti cijeli projekt ili dio njega bez potrebe za instalacijom ikakvih dodatnih programa kao što su PHP, Composer, NodeJS, Laravel, Laragon, MySQL... nego je sve dostupno putem jedne naredbe koja instalira pakete, postavi projekt, te pokrene ga. Ideja je da sve ispravno radi na svakom uređaju bez obzira na stvari poput OS-a, verzije programa, itd.

### Upute za pokretanje

Ako želite pokrenuti cijeli projekt kroz Docker, prvo preuzmite [Docker Desktop](https://www.docker.com/products/docker-desktop/), odnosno [Docker Engine](https://docs.docker.com/engine/install/) ako koristite Linux.

Nakon što se instalira, bit će dostupne komande `docker` i `docker-compose` u terminalu odnosno komandnom retku.

Ako je sve u redu, preuzmite projekt sa git-a, uđite u njega putem `cd` komande, te upišite: `docker-compose up -d --build`

Nakon nekih 5-10 sekundi, možete pristupiti aplikaciji na `http://localhost:3000` i backendu na `http://localhost:8000`, a MySQL baza će također biti dostupna na portu 3306 pa se možete na nju spojiti kako god hoćete.

### Razvoj koristeći Docker

Korištenje Dockera tokom razvoja je korisno ako npr. radite na frontendu a ne želite se zamarati sa instaliranjem PHP-a i MySQL-a.

Docker je napravljen tako da se mogu pokretati pojedinačni dijelovi projekta, bez potrebe pokretanja ostalih. Trenutni dijelovi projekta su `frontend`, `backend` i `mysql`. Pokrenete samo ono što vam treba, pa možete raditi na svom kodu na standardni način.

Primjeri:

1. Želite raditi na frontendu ali ne želite instalirati dependencies za backend:

Komanda za pokretanje backenda je `docker-compose up -d --build backend mysql` (ova komanda mora biti pokrenuta u root folderu odnosno tamo gdje se nalazi `docker-compose.yml`). Nakon toga, možete raditi na frontendu koristeći standardne komande (Unutar `Frontend/` foldera koristite komande `npm run dev`, `npm run build`, itd.).

2. Želite raditi na backendu ali ne želite imati instaliran MySQL server na svom računalu:

Komanda za pokretanje baze podataka je `docker-compose up -d mysql` (ova komanda mora biti pokrenuta u root folderu odnosno tamo gdje se nalazi `docker-compose.yml`). Nakon toga, možete raditi na backendu koristeći standardne komande (Unutar `Backend/` foldera koristite komande `php artisan serve`, `php artisan migrate`, itd.). Ako želite pokrenuti i frontend, možete koristiti `docker-compose up -d frontend` (opet u root folderu).
