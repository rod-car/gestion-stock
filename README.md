# Gest-Stock

Application de gestion de stock multi point de vente et multi entrepot. Developpe avec Laravel 8 et VueJS 3.

## Table of Contents

- [Installation](#installation)
- [Utilisation](#utilisation)

## Installation

L'installation du projet se deroulera comme suit.

### Pre-requis

Ci-dessous la liste des pre-requis:

- Composer
- PHP > 7.2 < 8.2
- NodeJs > 12

### Installation

1. Cloner le depot:

   ```bash
   git clone https://github.com/rod-car/gestion-stock.git

2. installer les dependances de laravel:

   ```bash
   composer install

3. Migrer la base de donnees:

   ```bash
   php artisan migrate

4. Ajouter les donnees de test:

   ```bash
   php artisan db:seed

5. Installer les dependances de NPM si necessaire:

   ```bash
   yarn

6. Lancer le serveur de developpement de Webpack:

   ```bash
   yarn run dev

## Utilisation
   ```bash
   php artisan serve
