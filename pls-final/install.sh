#!/bin/sh
ok=''
root=''
echo Ce bash d\'installation rapide ne fonctionnera que sur les systèmes Debian ou systèmes dérivés disposant de la commande apt-get.
echo Si ce n\'est pas votre cas, veuillez installer les paquets \'apache2\' et \'php5\' manuellement, puis déplacez le dossier \'pls-final\' dans \'/var/www/\'
read ok
sudo apt-get install apache2 php5 
read -p "Veuillez entrer le chemin de la racine des sites apache (laissez vide pour le chemin par défaut) : " root
if [ "$ok" -z '' ]; then
	$root = "/var/www/"
sudo mv pls-final/ $root
echo Installation terminée.
echo Rendez-vous sur <adresse de votre serveur apache>/pls-final/ pour commencer à utiliser PLS.
echo (l\'adresse de votre serveur apache dans le cas d\'une installation locale est \'localhost\', et d\'une manière générale l\'adresse IP publique de la machine ou vous l\'avez installé)