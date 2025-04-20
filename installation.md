# Installation 

Ce site web est développé en PHP et javascript avec une base de données MySQL.


Lien du git: https://github.com/clementDA/secuByDesignExo.git

### Sur Linux

1- Instalation des prérequis

Le site nécéssite un serveur apache, php et une base de donnée pour fonctionner.

-Mettre a jour le service apt via la commande suivante:

bash:  apt update
bash:  apt upgrade


-installer les composant necessaires:

bash:  apt install git -y
bash:  apt install apache2 -y
bash:  apt install php -y
bash:  apt install php-mysql -y
bash:  apt install mysql-server -y

Cela devrait installer les composant git, apache php et le necessaire mysql.
Si vous osuhaitez vérifier le fonctionnement, tapez:

bash:  php -v
bash:  apache2 -v
bash:  myasql --version

Chacune de ces commandes devrait vous afficher la version des services.



2-Cloner le depot

rendez vous dans un dossier pour cloner le repo

bash:  cd (mettez le chemin d'un dossier vide de votre hcoix)
bash:  git clone https://github.com/clementDA/secuByDesignExo.git

entrez dans le dossier et copiez le dossier de la version que vous voulez installer

bash:  cd /secuByDesignExo 

bash:  cp -r /Produits-sportifs-secure /var/www  
ou    
bash:  cp -r /Produits-sportifs /var/www

(Si vous souhaitez installer les deux version sur la même machine, lancez les deux commandes)


3-Creation de la database

Connectez vous au service MySQL

bash:  mysql -u root -p

entrez le mot de passe de votre base de donnée (vide si vous ne l'avez pas modifié)

créer la base de donnée:

sql: CREATE DATABASE datawarehousse;

quittez le service mysql:

sql: EXIT;


exécutez le script:

 bash:  mysql -u root -p datawarehousse < /(chemin vers le clone du repo)/secuByDesignExo/datawarehousse.sql

une fois fait, si vous avez modifié les mots de passe ou les utilisateurs mysql, allez configurer les fichier du site:


bash: nano /var/www/Produits-sportifs/config/database.php

ou

bash: nano /var/www/Produits-sportifs-secure/config/database.php

modifier les lignes correspondantes
Les quatres lignes pouvant être impacté sont:

$host = 'localhost';        // Adresse du serveur MySQL 
$dbname = 'datawarehouse';  // Nom de la base de données
$username = 'root';         // Nom d'utilisateur MySQL 
$password = '';             // Mot de passe MySQL 

Si vous avez suivi toutes les instructions, l'host devrait rester a localhost.
Si vous avez changé le nom de la base de donnée ou utilisé un autre utilisateur mysql, modifier les lignes correspondantes.


4-Tester.

Le site devrait être opérationnel, dans le doute lancez le service apache:

bash: systemctl start apache2


Vous pouvez désormais accéder au(x) site(s) avec les adresses:

http://localhost/Produits-sportifs
et/ou
http://localhost/Produits-sportifs-secure

Depuis le navigateur de votre choix.

### Pour windows

Si vous souhaitez installer le site sur windows, téléchargez et installez wamp ou xamp

https://www.wampserver.com/
https://www.apachefriends.org/fr/index.html


Lancez l'installateur et choisir les composants associé (apache, MySQL, PHP , phpMyADmin)
Démarrez tout les services depuis l'itnerface xampp ou wamp


Téléchargez le repository depuis l'interface web de git.
Extrayez l'archive et copiez le dossier du/des site(s) de votre choix (Produits-sportifs  et/ou Produits-sportifs-secure) depuis l'atchive jusqu'au dossier de projet 

xampp\htdocs ou  \wamp64\www selon le serviec choisis.


Pour l'instalation de la base de donnée, allez a l'adresse: http://localhost/phpmyadmin/   depuis votre navigateur.
Entrez les identifiants que vous aurez paramétré.

Depuis l'interface graphique, créez une nouvelle base de donnée: datawarehousse
Selectionnez cette nouvelle abse puis cliquez sur l'onglet "import"
Selectionenz "browse" et selectionnez ensuite le fichier datawarehousse.sql dans le dossier récupéré sur git.
cliquez sur "import" pour valider l'applciation du script.

Rendez vous dans le dossier de votre site:


xampp\htdocs/Produits-sportifs-secure/config/database.php

xampp\htdocs/Produits-sportifs-/config/database.php
ou
wamp64\www/Produits-sportifs-secure/config/database.php
ou
wamp64\www/Produits-sportifs-/config/database.php


Vous retrouverez les lignes de configuration suivantes:
$host = 'localhost';        // Adresse du serveur MySQL 
$dbname = 'datawarehouse';  // Nom de la base de données
$username = 'root';         // Nom d'utilisateur MySQL 
$password = '';             // Mot de passe MySQL 

L'host restera sur localhost, mais vous pourrez être mené a modifier username et password si vous avez créé un utilisateur.

Votre site devrait ensuite être accessible depuis:

http://localhost/Produits-sportifs
et/ou
http://localhost/Produits-sportifs-secure
