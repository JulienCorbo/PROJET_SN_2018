# PROJET PISCINE-WIFI

Le but de ce projet et de récolter des informations tel que le pH, la température et le chlore et de les afficher sur un site internet qui contient les données récoltés et les manières de corriger le chlore et le pH au cas où ces valeurs soient mauvaises.

Ce projet a donc pour objectif de simplifié l’acquisition et la correction des données d’une piscine pour l’utilisateur.

## Prérequis

Pour ce projet nous avons fait un site qu'il faut héberger et ce site sera alimenté grace a une base de données.
Nous avons donc installer sur la Raspberry Pi :

* Apache2 pour heberger le site
* PHP pour gerer le site
* MySQL pour la base de donnée
* PHPMyAdmin pour facilité la gestion de la base de données

### Installation des prérequis

L’installation se passe par des lignes de commandes, pour une installation correcte il faut avant toute chose mettre à jour la RPI via :

```
sudo apt update
sudo apt upgrade
```

* Ensuite l'installation d'apache2 :

```
sudo apt install apache2
```
Pour donner les droits admin au dossier d'apache2 :
```
sudo chown -R pi:www-data /var/www/html/
sudo chmod -R 770 /var/www/html/
```

* L'installation de PHP : 
```
sudo apt install php php-mbstring

```
Pour vérifier que PHP fonctionne on crée un fichier index.php avec les info de la version installé de PHP: 

```
sudo rm /var/www/html/index.html
```
```
echo "<?php phpinfo(); ?>" > /var/www/html/index.php
```

* L'installation de MySQL : 
```
sudo apt install mysql-server php-mysql
```

* L'installation de PHPMyAdmin : 
```
sudo apt install phpmyadmin
```

Pour tester si phpMyAdmin fonctionne il suffit d'aller sur son navigateur et de taper « http://localhost/phpmyadmin ».

### Script de récupération des informations

Les valeurs sont récupérées par la Raspberry Pi en i2C grâce à un script en python qui est exécuté grâce au crontab de la carte.

Pour éditer le crontab il faut lancer une console sur la RaspberryPi et écrire : 

```
sudo crontab -e
```

Puis y rajouter : 

```
0 */1 * * * * python /home/pi/var/www/html/nom_du_script_python.py
```
Le script sera executé toutes les heures.

**Rappel :**

**X X X X X    commande à exécuter**
* Le premier X correspond aux minutes de 0 à 59
* Le second X correspond aux heures de 0 à 23
* Le troisième X correspond aux jours de 1 à 31
* Le quatrième X correspond aux mois de de 1 à 12
* Le cinquième X correspond aux jours de la semaine de 0 à 6 en commençant par Dimanche

### Schéma de cablage :

[Schéma dans la doc de ce projet](https://github.com/JulienCorbo/PROJET_SN_2018/blob/master/Docs/Shéma_de_cablage.png)

## Déploiement

Pour le déploiement de ce projet, une fois l'installation ci-dessus faite :

* Mettre le code source du site dans le dossier d'apache2.
* Modifier le crontab de la Pi comme expliquer ci-dessus.
* Effectuer le branchement des capteurs.

## Ressources externes :

* [GoogleChart](https://developers.google.com/chart/) - Utilisé pour les graphiques du site
* [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Utilisé pour l'envoi de mail lors d'un oubli de mot de passe
* [jQuery](https://jquery.com) - Utilisé pour les requetes AJAX et le Javascript

* [GitKraken](https://www.gitkraken.com) - Logiciel utilisé pour utiliser le dépot de travail du projet

## Auteurs

* **CORBO Julien** - *Travaux sur la Raspberry et l'aquisition de donnée* - [Github](https://github.com/JulienCorbo)
* **FAURE Axel** - *Travaux sur le site et la partie graphique* 