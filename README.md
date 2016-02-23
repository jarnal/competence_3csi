Projet competence 3CSI
==================

Projet de fin d'année réalisé par :
==================
Camille Vasseur
Thomas Sebbane
Jonathan Arnal

Procédure :
==================

1) Installation des dépendances : composer update
2) Créer une base de données nommée : competence_3csi
3) Création de la structure de base de données : php bin/console doctrine:schema:update --force
4) Création d'un super-admin : php bin/console fos:user:create username username@mail.com password --super-admin
5) Création d'un client pour OAuth : php bin/console comp3csi:oauth-server:client:create --grant-type="http://competences3csi.com/grants/api_key" --grant-type="password" --grant-type="refresh_token" --grant-type="token"

Utilisation :
==================

Récupération d'une api_key :
http://SERVER.com/web/app.php/security

Récupération d'un token :
