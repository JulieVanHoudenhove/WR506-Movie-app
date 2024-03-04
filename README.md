### WR506 - Movie App - Julie VAN HOUDENHOVE - TPE

## Prérequis

- [Php 8.1](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)
- OpenSSL (pour générer les clés JWT)
- Partie Frontend du projet [WR505 - Movie App](https://github.com/JulieVanHoudenhove/WR505-Movie-app.git)

## Installation

1. Cloner le projet
   ```bash
    git clone https://github.com/JulieVanHoudenhove/WR506-Movie-app.git
    ```
2. Installer les dépendances
     ```bash
       composer i
       # ou
       composer install
     ```
3. Créer le fichier .env.local et renseigner les variables d'environnement
    ```bash
    cp .env .env.local
    ```
4. Renseigner les variables suivantes : 
     ```dotenv
      DATABASE_URL #(url de la base de données)
     ```
5. Créer la base de données
    ```bash
      php bin/console d:d:c
      php bin/console d:m:m
    ```
6. Créer les fixtures
    ```bash
      php bin/console d:f:l
    ```
7. Générer les clés JWT
    ```bash
      php bin/console lexik:jwt:generate-keypair
    ```
8. Lancer le serveur
    ```bash
      symfony server:start
    ```

La documentation de l'API est disponible à l'adresse suivante : [http://localhost:8000/api/doc](http://localhost:8000/api/docs)

Les identifiants par défauts pour se connecter à l'application sont :
  - Admin
      - email : ``` admin@gmail.com ```
      - mot de passe : ``` admin ```
  - User
      - email : ``` user1@gmail.com ```
      - mot de passe : ``` password1 ```
