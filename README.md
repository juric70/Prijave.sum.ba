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

To je korisno u slučaju da želite pokrenuti projekt na lagan način na drugom računalu ili pri deploymentu projekta na neki server.

### Upute za pokretanje

Ako želite pokrenuti cijeli projekt kroz Docker, prvo preuzmite [Docker Desktop](https://www.docker.com/products/docker-desktop/), odnosno [Docker Engine](https://docs.docker.com/engine/install/) ako koristite Linux.

Nakon što se instalira, bit će dostupne komande `docker` i `docker-compose` u terminalu odnosno komandnom retku.

Ako je sve u redu, preuzmite projekt sa git-a, uđite u njega putem `cd` komande, te upišite: `docker-compose up -d --build`

Pošto postoje neke pozadinske operacije poput migriranja i seedanja baze podataka u backendu, potrebno je malo pričekati.
Nakon nekih 5-10 sekundi, možete pristupiti aplikaciji na `http://localhost:3000` i backendu na `http://localhost:8000`, a MySQL baza će također biti dostupna na portu 3306 pa se možete na nju spojiti kako god hoćete.

### Razvoj koristeći Docker

Možete koristiti Docker tokom developmenta. Ovo je korisno ako netko želi raditi samo na jednom dijelu projekta npr. samo na frontendu, a da se ne mora zamarati sa instaliranjem PHP-a i MySQL-a.

<details>
	<summary><strong>Primjer 1</strong>: želite raditi na frontendu, no za njega vam treba biti pokrenut cijeli backend.</summary>
	
Otvorite dodatni VS Code prozor u folderu "Backend" i pokrenete sljedeće naredbe:

1. Stvaranje Docker mreže:

```bash
docker network create prijave-net
```

2. Startanje MySQL baze:

```bash
docker run -d
--name prijave-mysql
--network prijave-net
-e MYSQL_ROOT_PASSWORD=prijave
-e MYSQL_DATABASE=prijave
-e MYSQL_USER=prijave
-e MYSQL_PASSWORD=prijave
-p 3306:3306
-v mysql_data:/var/lib/mysql
mysql:latest
```

3. Kompajliranje backenda:

```bash
docker build -t prijave-laravel .
```

4. Pokretanje backenda:

```bash
docker run -d
--name prijave-laravel
--network prijave-net
-p 8000:8000
prijave-laravel
```

Nakon toga, backend bi vam trebao biti dostupan na `http://localhost:8000`.

</details>

<details>
	<summary>
	<strong>Primjer 2</strong>: želite raditi na backendu, no za njega vam treba biti pokrenuta MySQL baza podataka.</summary>
	</summary>

Unutar VS Code terminala (pretpostaljam da ste u folderu "Backend") pokrenete sljedeću naredbu:

1. Startanje MySQL baze:

```bash
docker run -d
--name prijave-mysql
--network prijave-net
-e MYSQL_ROOT_PASSWORD=prijave
-e MYSQL_DATABASE=prijave
-e MYSQL_USER=prijave
-e MYSQL_PASSWORD=prijave
-p 3306:3306
-v mysql_data:/var/lib/mysql
mysql:latest
```

MySQL baza će biti dostupna na `127.0.0.1:3306`.

Backend zatim možete pokrenuti na način koji vam odgovara, bilo da je to preko terminala, Laragona ili Docker-a, i trebao bi se spojiti na MySQL bazu ispravno.

</details>
