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
-   role modifiable lors de la modification.

### Implémentation de nouvelles fonctionnalités

-   gestion des utilisateurs UNIQUEMENT par ROLE_ADMIN ;
-   une tâche ne peut être supprimée que par son auteur ou un admin ;
-   tâche "anonyme" peut être modifiée/supprimée que par un admin.

### Implémentation de tests automatisés

-   doivent être implémentés avec PHPUnit ;
-   prévoir des données de tests ;

### Documentation technique

-   expliquer l'implémentation de l'authentification ;
-   expliquer quels fichiers sont modifiable et pourquoi ;
-   comment s'opère l'authentification ;
-   où sont stockés les utilisateurs.

Ajouter aussi un document expliquant comment doivent procéder les développeurs
souhaitant apporter des modifications au projet et détailler le processus de
qualité à utiliser ainsi que les règles à respecter.

### Audit de qualité du code & performance de l'application

Audit de code sur les deux axes suivants (avant & après modifications):

```
cf. documentation
```

## Installation

Cloner le repository :

```
https://github.com/F-Jean/projet8-TodoList.git
cd projet8-TodoList
```

Mettre à jour les dépendances :

```
composer update
```

## Configuration

Créer un fichier `.env.local` :

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

phpstan : analyseur statique pour PHP (identifie les erreures sans avoir
besoin d'exécuter le code).

```
vendor/bin/phpstan analyse -c phpstan.neon
```

phpunit : permet de tester les tests de régression implémentés en vérifiant que
les exécutions correspondent aux assertions prédéfinies.

```
php bin/phpunit
```

php code sniffer : détecte les violations définies par le standard PSR-12.

```
vendor/bin/phpcs --standard=PSR12 src
```

php code standards fixer : corrige le code pour suivre les standards PSR.

```
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

php mess detector : scan le code source PHP à la recherche de potentiel erreures
telles que :

-   de possibles bugs ;
-   du code mort ;
-   code mal optimisé ;
-   expressions trop compliqués.

```
vendor/bin/phpmd src text .phpmd.xml
```
