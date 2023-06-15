# Gulp Config

Configuration préparée par Léo Fontin (2020) Cette configuration gulp est dédiée à la compilatio ndes assets pour un site web.

Elle prépare les éléments suivants :

- scss => un ou plusieurs fichiers css
- JS (npm, libs, js custom) => un fichier js
- Icons (font, sprite img)
- Images (compression)
- Custom Fonts (otf, tff, ...)

# Installation
## Node 
- Installation de node (version testée 12.*)
- Installation de NPM (version testée 6.*)

Pour installer node et npm, télécharger l'installateur à l'adresse suivant : `https://nodejs.org/en/`

## Gulp CLI
Installation de gulp CLI. Cela permet d'utiliser Gulp en ligne de commande et de facilement lancer les tâches de manière globale ou de manière indépendantes.

Lancez la commande suivante dans votre terminal : `npm i -g gulp-cli`

La dernière version testée est : 2.3.0

## Nodes modules

Installez les nodes modules

Rendez-vous dans le dossier gulp de la config. Lancez la commande : `npm i`.

Cela isntallera tous les modules nécessaires répertoriés dans le fichier `package.json`

### Conseil : 

- Avec npm 6 il est possible de faire des liens symboliques. La bibliothèque des node modules installée est très lourdes. Il est conseillé de déporter une seul copie de cette bibliothèque dans un seul endroit de votre ordinateur et de faire un lien symbolique de cette copie vers le dossier Gulp de votre config sur votre site.

- Voici la commande à faire pour un lien symbolique `ln -s chemin-source/node_modules chemin-destination/node_modules`

# Utilisation
## Lancement tâches
### Tâche par defaut

Cette tâche est la tâche dédiée au dévelopement. Pour la lancer :

- Rendez-vous dans le dossier gulp de votre site avec votre terminal
- Lancez la commande `gulp`

### Tâche de production

Cette tâche réalisera les mêmes action que la tâche par défaut mais préparera les assets pour le site en production (retrait des sources maps, compression des images, ...)

