# Blabla Chamb

Mission: mettre en place un systeme de covoiturage en y integrant une base de donnees et une authentification des utilisateurs

Outils: PHP Symfony, Tailwind CSS, MYSQL, PHPMyAdmin

## Run le projet

Cloner le projet

```bash
  git clone git@github.com:OrhanMA/Simplon-BlablaChambe.git
```

Go to the project directory

```bash
  cd Simplon-BlablaChambe/
```

Installer les dependencies

```bash
  composer install
  npm install
```

Changer l'URL de BDD dans le .env

```
DATABASE_URL="mysql://phpmyadmin:root@127.0.0.1:3306/<MY-DATABASE>?serverVersion=8.0.32&charset=utf8mb4"
```

Start the server

```bash
  php/bin console server:start
  npm run watch
```

Effectuer les migrations pour la BDD

```
php/bin console m:mig
php/bin console d:m:m
php/bin console d:f:l
```
