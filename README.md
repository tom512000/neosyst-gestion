# Neosyst Gestion - Application de Gestion
**Neosyst Gestion** est une application web développée pour répondre aux besoins spécifiques de l'entreprise Neosyst située à Epernay. Cette solution permet une gestion efficace des articles, des clients et des SAV (Service Après-Vente) via une interface intuitive propulsée par Symfony et EasyAdmin.

## Fonctionnalités
### Gestion des Articles
- Créer, modifier et supprimer des articles.
- Consulter les listes d'articles paginées avec des filtres de recherche.
- Ajout de champs personnalisés comme la date d'édition des articles.

### Gestion des Clients
- Ajouter et gérer des informations sur les clients.
- Champs personnalisés pour numéros de téléphone, adresses, etc.
- Intégration de filtres avancés pour une recherche rapide.

### Gestion des SAV
- Création et suivi des demandes SAV.
- Association automatique des SAV avec les clients.
- Gestion des dates (création, fin, etc.) avec conversion depuis Excel.

## Installation
1. **Tout d'abord, clonez le projet :**
    ```shell
    git clone https://github.com/tom512000/neosyst-gestion.git
    ```
2. **Placez-vous dans celui-ci :**
   ```shell
   cd neosyst-gestion
   ```
3. **Ensuite, lancez l'installation des dépendances PHP du projet :**
    ```shell
    composer install
    ```
4. **Lancez également l'installation des paquets JavaScript :**
    ```shell
    npm install
    ```

## Lancement du projet
1. **Pour commencer, générez la base de données :**
   ```shell
   composer db
   ```
2. **lancez le serveur local Symfony :**
   ```shell
   composer start
   ```
4. **Utilisez ensuite Babel pour transpiler les fichiers JavaScript :**
   - Si vous êtes en développement :
     ```shell
     npm run dev
     ```
   - Si vous êtes en production :
     ```shell
     npm run build
     ```
