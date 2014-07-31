BackupMe Server
========================

BackupMe Server est le FrontEnd Web de [BackupMe Agent][1].
L'ensemble permet de pouvoir sauvegarder un grand nombre d'équipements grâce à une interface web moderne utilisant [Bootstrap][2]

1) Installation
----------------------------------

L'installation est décrite pour la distribution Debian. Cependant, en ajustant les commandes à votre distribution, cela ne devrait pas poser de problème.

### Debian (*recommended*)

Installez les pré-requis :

    aptitude install xxxxxxxxxxxx

Installez ensuite NodeJS et NPM pour pouvoir utiliser LESS

    aptitude install nodejs-legacy
    curl https://www.npmjs.org/install.sh | sudo sh

Vérifiez l'installation

    node -v
    npm -v

Installez LESS

    npm install -g less

Installez [Composer][3]

    curl -sS https://getcomposer.org/installer | php

Installez les librairies dépendantes (vendors)

    php composer.phar install
La configuration du parameters.yml vous sera demandé. Vous pouvez vous inspiré du `app/config/parameters.yml.dist` pour cela.

Testez votre configuration système

    php app/check.php
Si le script retourne un code `0` alors toutes les dépendances sont respectés. Dans le cas contraire, il retournera un `1`.

Créez votre base de donnée

    php app/console doctrine:schema:create

Installer les ressources (Image/CSS/JS)

    php app/console doctrine:schema:create

Enjoy!

[1]:  https://github.com/mguyard/backupme-agent
[2]:  http://getbootstrap.com/
[3]:  https://getcomposer.org
