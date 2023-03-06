[![Codacy Badge](https://app.codacy.com/project/badge/Grade/3722681d50c4405784bf78cf83c7585a)](https://www.codacy.com/gh/F-Jean/projet8-TodoList/dashboard?utm_source=github.com&utm_medium=referral&utm_content=F-Jean/projet8-TodoList&utm_campaign=Badge_Grade)

# ToDoList

==========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

## But

Améliorer la qualité de l'application, en charge des tâches suivantes :

-   l'implémentation de nouvelles fonctionnalités ;
-   la correction de quelques anomalies ;
-   et l'implémentation de tests automatisés ;
-   analyse du projet à l'aide d'outils;
-   si possible réduire la dette technique de l'application.

### Correction d'anomalies

Une tâche doit être attachée à un utilisateur :

-   lors de la création ;
-   auteur non modifiable lors d'une modification ;
-   auteur "anonyme" pour tâches déjà existantes.

Rôle des utilisateur :

-   choix entre ROLE_USER & ROLE_ADMIN lors de la création d'un utilisateur ;
-   rôle modifiable lors de la modification.

### Implémentation de nouvelles fonctionnalités

-   gestion des utilisateurs UNIQUEMENT par ROLE_ADMIN ;
-   une tâche ne peut être supprimée que par son auteur ou un admin ;
-   tâche "anonyme" peut être modifiée/supprimée que par un admin.

### Implémentation de tests automatisés

-   implémentés avec PHPUnit ;
-   prévoir des données de tests ;

### Documentation technique

-   expliquer l'implémentation de l'authentification ;
-   expliquer quels fichiers sont modifiable et pourquoi ;
-   comment s'opère l'authentification ;
-   où sont stockés les utilisateurs.

### CONTRIBUTING.md

Document expliquant comment doivent procéder les développeurs
souhaitant apporter des modifications au projet et détailler le processus de
qualité à utiliser ainsi que les règles à respecter.

### Audit de qualité du code & performance de l'application

Audit de code sur les deux axes suivants (avant & après modifications):

```
cf. document "Courtot_Jean_3_rapport_audit_082022"
```

## Installation

**Récupérer le projet** dans son état actuel depuis github en faisant un **fork**.
Cela va créer une copie sous votre propre compte GitHub. Cela permet d'expérimenter librement et d'apporter des modifications au projet sans affecter le projet original.

Placez-vous dans le dossier dans lequel vous voulez cloner le repository.

Cloner le repository (Copier bien celui de votre repository avec VOTRE username Github):

```
git clone https://github.com/VOTREUSERNAMEGITHUB/projet8-TodoList.git
cd projet8-TodoList
```

Ouvrer le dans votre éditeur.

Mettre à jour les dépendances :

```
composer update
```

## Configuration

Créer un fichier `.env.local` (Remplacer root & password par **VOS identifiants**):

```
DATABASE_URL=mysql://root:password@127.0.0.1/todolist_v1
```

Créer la base de données :

```
php bin/console doctrine:database:create
```

Installer les fixtures et mettre à jour la base de données :

```
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Démarer le serveur et aller sur le site

```
symfony serve -d
https://127.0.0.1:8000
```

Pour que webpack encore fonctionne correctement (créations des node_modules + public/build) :

```
npm install
npm run watch
```

## Environnement de test

Créer un fichier `.env.test.local` :

```
DATABASE_URL=mysql://root:password@127.0.0.1/todolist_v1_test
```

Créer la base de données, installer les fixtures et mettre à jour la base de
données de test :

```
composer database-test
```

### Lancer les tests

#### phpstan

Analyseur statique pour PHP (identifie les erreures sans avoir besoin d'exécuter
le code).

```
vendor/bin/phpstan analyse -c phpstan.neon
```

#### phpunit

Permet de tester les tests de régression implémentés en vérifiant que les exécutions
correspondent aux assertions prédéfinies.

```
php bin/phpunit
```

#### php code sniffer

Détecte les violations définies par le standard PSR-12.

```
vendor/bin/phpcs --standard=PSR12 src
```

#### php code standards fixer

Corrige le code pour suivre les standards PSR.

```
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

#### php mess detector

Scan le code source PHP à la recherche de potentiel erreures telles que :

-   de possibles bugs ;
-   du code mort ;
-   code mal optimisé ;
-   expressions trop compliqués.

```
vendor/bin/phpmd src text .phpmd.xml
```

#### PHPCPD

Permet de détecter les codes dupliqués dans le projet

```
phpcpd src
```
