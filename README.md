application symphony pour roller coaster

Cloner le dépôt `git clone LIEN_DU_DEPOT`

Installer les dépendances PHP: `composer install`

Installer les dépendances Js/css : `npm install`

Si vous utiliser Docker, installer les dépendances: `docker-compose up -d`

Définir les variables d'environnement dans le fichier `.env`

Assembler les assets : `npm run build` ou `npm run watch`

lancer le serveur Symfony : `symphony serve`

## BASE DE DONNEES
 Générer la DB : `symphony console doctrine:database:create`

 Créer une migration : `symphony console doctrine:migrations:diff`

 Mettre à jour la DB : `symphony console doctrine:migrations:migrate`


Pour se connecter dans l'image mysql : `docker exec -it NOM_IMAGE mysql -u root -p password`