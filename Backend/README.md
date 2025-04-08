# prijave.sum.ba

## Docker upute

Backend je Dockeriziran putem obične Dockerfile datoteke. Da bi pokrenuli backend potreban vam je Docker Desktop (za Windows i Mac) ili Docker Engine (za Linux).

Postupci:

1. Stvoriti `prijave-net` mrežu:

```bash
docker network create prijave-net
```

2. Pokrenuti MySQL bazu podataka:

```bash
docker run -d --name prijave-mysql --network prijave-net-e MYSQL_ROOT_PASSWORD=prijave -e MYSQL_DATABASE=prijave -e MYSQL_USER=prijave -e MYSQL_PASSWORD=prijave -p 3306:3306 -v mysql_data:/var/lib/mysql mysql:latest
```

3. Buildati backend:

```bash
docker build -t prijave-laravel .
```

4. Pokrenuti backend:

> [!NOTE]
> Migracije će se izvršiti prilikom svakom pokretanja, no seed-anje će se izvršiti samo ako je tablica `users` prazna. Ako želite ponovo izvršiti seed-anje, morate izbrisati podatke u bazi. Upute za to su u odjeljku [Resetiranje baze podataka](#resetiranje-baze-podataka).

```bash
docker run -d --name prijave-laravel --network prijave-net -p 8000:8000 prijave-laravel
```

MySQL server će biti dostupan na `localhost:3306`, a backend na `localhost:8000`.

## Resetiranje baze podataka

Ako želite resetirati bazu podataka, možete to učiniti pomoću sljedećih komandi:

1. Zaustaviti i ukloniti MySQL container:

```bash
docker kill prijave-mysql
docker rm prijave-mysql
docker volume rm mysql_data
```

2. Ponovo pokrenuti MySQL container:

```bash
docker run -d --name prijave-mysql --network prijave-net-e MYSQL_ROOT_PASSWORD=prijave -e MYSQL_DATABASE=prijave -e MYSQL_USER=prijave -e MYSQL_PASSWORD=prijave -p 3306:3306 -v mysql_data:/var/lib/mysql mysql:latest
```

## Resetiranje svega

Ako želite resetirati sve, možete to učiniti pomoću sljedećih komandi:

1. Zaustaviti i ukloniti MySQL container:

```bash
docker kill prijave-mysql
docker rm prijave-mysql
docker volume rm mysql_data
```

2. Zaustaviti i ukloniti Laravel container:

```bash
docker kill prijave-laravel
docker rm prijave-laravel
```

3. Ukloniti Docker mrežu:

```bash
docker network rm prijave-net
```
