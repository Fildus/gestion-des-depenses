# Gestion des dépenses

### installation

##### 1. Télécharger le git vers le dossier de déstination
```bash
git clone git@github.com:Fildus/gestion-des-depenses.git
```
##### 2. Modifer les variables d'environement
dans le ".env"

mysql://<name\>:<pass\>@127.0.0.1:3306/gestion-des-depenses

##### 3. Installer le projet
```bash
cd gestion-des-depenses
composer install
yarn
yarn build
./reload.sh
```

##### 4. Modifier le fichier .htaccess et passwd
1- Remplacer le password via http://www.htaccesstools.com/htpasswd-generator/

2- Modifer le chemin absolu.
