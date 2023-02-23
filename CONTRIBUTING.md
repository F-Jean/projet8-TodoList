# Contribution

==========

Merci de lire ce document afin de comprendre le fonctionnement du système de contribution.
Le document regroupe les sections suivantes :

-   [Introduction aux procédures pour les développeurs souhaitant apporter des modifications au projet](#introduction-aux-procédure-pour-les-développeurs-souhaitant-apporter-des-modifications-au-projet)
-   [La procédure en détails / Workflow](#la-procédure-en-détails--workflow)
    -   [Issues](#issues)
    -   [Rapport de bug](#rapport-de-bug)
    -   [Nouvelle fonctionnalité](#nouvelle-fonctionnalité)
    -   [Branches](#branches)
    -   [Tests](#tests)
    -   [Pull request](#pull-request-pr)
    -   [Et ensuite](#et-ensuite)
-   [Processus de qualité à utiliser et règles à respecter](#processus-de-qualité-à-utiliser-et-règles-à-respecter)
-   [Tests mis en place](#tests-mis-en-place)
    -   [Exemple de workflow](#exemple-de-workflow)
-   [Performances](#performances)
    -   [Problématique performance VS lisibilité/compréhension du code](#problématique-performance-vs-lisibilitécompréhension-du-code)

## Introduction aux procédure pour les développeurs souhaitant apporter des modifications au projet

Afin d’assurer une bonne collaboration sur le projet, il a été choisi d’utiliser la plateforme [Github](https://github.com/) pour **partager le code de l’application**.

![Github main page](https://drive.google.com/file/d/18l4p7iu4ejt6AiL6q0ZgBK9KcEXHKAaO/view?usp=share_link)

Plus précisément il s'agit d'un site web basé sur le cloud qui héberge des **dépôts Git**, qui sont des espaces de stockage pour les fichiers source, les documents et les données de configuration. Les développeurs peuvent télécharger et partager des fichiers, travailler sur des projets en collaboration, tester du code, signaler des problèmes et proposer des modifications à d'autres développeurs.

Les futures développeurs qui souhaitent apporter leur collaboration devront utilisr ces outils en respectant **les différentes procédures** nécessaires pour **partager correctement leur code**.

Pour cela il faut commencer par **récupérer le projet** dans son état actuel depuis github en faisant un **fork** puis un **clone**.

![Fork Github](https://drive.google.com/file/d/1cGfR_1Wc97OGY7Mbc50UIANivwX1ZA-C/view?usp=share_link)

Forker un projet signifie créer une copie sous son propre compte GitHub. Cela permet d'expérimenter librement et de apporter des modifications au projet sans affecter le projet original.

![Clone du projet](https://drive.google.com/file/d/111Zj-12enM6XepZjoL05I-RkD6xgoaJi/view?usp=share_link)

Il reste ensuite à **suivre les directives** indiquées dans le [README](https://github.com/F-Jean/projet8-TodoList/blob/master/README.md) pour finaliser l’installation et avoir accès à une version locale sur laquelle on peut commencer les modifications.

## La procédure en détails / Workflow

### Issues

Les issues sont un moyen de **signaler des problèmes, des bugs, des demandes de fonctionnalités** ou des questions spécifiques. Voyez les comme des tickets de suivi qui permettent de communiquer avec les développeurs et les autres membres de la communauté qui travaillent sur le projet.

Note : Si vous avez fork un projet il ne vous sera pas possible d'écrire vos issues dans votre [repository](https://github.com/F-Jean/projet8-TodoList).

![Github issues](https://drive.google.com/file/d/1TPYwEagEImux-h9BJCkU3FeXdq7nxzwq/view?usp=share_link)

Certaines dispositions à respecter s'imposent lors de l'écriture d'une issue :

-   ne pas hésiter à bien détaillé, inclure des captures d'écran et/ou des exemples de code, etc ;
-   classifier selon les étiquettes (labels) disponibles pour la rendre facilement identifiable ;
-   commenter pour donner leur avis, poser des questions ou proposer des solutions ET SURTOUT **faire preuve de respect et de politesse** ;
-   ne pas relancer tant que/si l'issue n'a pas été validée.

### Rapport de bug

Un bug est un défaut de fonctionnement de l'application causé par le code, cela comprend tout comportement non désiré ou erreur qui peut entraîner un dysfonctionnement de l'application.

**Vérifier qu'une demande similaire n'est pas déjà en court**, évitons les doublons.

### Nouvelle fonctionnalité

Il est possible et bien vu de proposer de nouvelles fonctionnalités. Néanmoins, réflechissez si elle répond aux attentes du projet.

Voici quelques pistes :

-   Fonctionnalité : Elle doit répondre à un besoin spécifique de l'utilisateur ou du projet. Elle doit être conçue pour être facile à utiliser et à comprendre.
-   Sécurité : Elle ne doit pas poser de risques de sécurité pour le système ou les utilisateurs. Elle doit être conçue pour éviter les failles de sécurité potentielles.
-   Performance : Elle ne doit pas ralentir l'application ou entraîner des temps de réponse lents.
-   Compatibilité : Elle doit être compatible avec les autres composants du système, tels que les versions précédentes du logiciel, les navigateurs web et les dispositifs mobiles.
-   Évolutivité : La nouvelle fonctionnalité doit être conçue pour être facilement évolutive, afin de permettre l'ajout de nouvelles fonctionnalités et l'adaptation aux besoins futurs.

### Branches

Chaque branche est une copie de la branche principale (souvent appelée “**main**” ici toujours anciennement “master”) qui peut être modifiée sans affecter les autres branches. On peut travailler sur une branche pour ajouter de nouvelles fonctionnalités ou corriger des bugs sans affecter la branche principale.

Créer une **nouvelle branche** :

```
git branch <branch-name>
```

![Git branches](https://drive.google.com/file/d/1f-nrvuMV8kw4qbcTf6GKb7BiFl66jZ5m/view?usp=share_link)

Elle contiendra tout le code ajouté et on peut y réalisés des [commits](https://github.com/F-Jean/projet8-TodoList/commits/master) à chaque avancée mineure/majeure :

```
git commit -m  "message"
```

![Git commits](https://drive.google.com/file/d/1zzShC-RzxWfY5Af9vQpxOx0QvkExshoQ/view?usp=share_link)

Les commits sont utilisés pour **enregistrer les modifications de code** effectuées dans un projet. Ils permettent entre autres :

-   d’avoir accès à un **historique des modifications** : Chaque commit enregistre une modification de code spécifique et fournit un message de commit décrivant les changements effectués. En conséquence, les commits permettent de suivre l'historique des modifications apportées, y compris qui a effectué la modification et quand.

-   la **réversibilité** : Ils permettent également de revenir en arrière dans l'historique des modifications et de restaurer une version précédente du code si nécessaire. Cela peut être très utile en cas de problèmes ou de bugs, car les commits peuvent être annulés sans affecter les autres parties du code.

Il est important que les **commits contiennent des avancées liées à la fonctionnalité développé** afin de garder un code cohérent.

### Tests

Une fois la fonctionnalité terminée, il faut alors **pousser le code** sur github (appelé **push**).

```
git push origin <branch-name>
```

Ceci ajoutera la nouvelle branche ainsi que tous ses commits, on peut alors faire une **pull request** (ou PR).

![Github branches](https://drive.google.com/file/d/1GwmCmYjZs0eknsAB4E0Ze5URIMi9J3SV/view?usp=share_link)

Cependant, pensez **toujours à faire une dernière vérification des tests et analyses du code avant de push** (cf. section [Processus de qualité à utiliser et règles à respecter](#processus-de-qualité-à-utiliser-et-règles-à-respecter).

### Pull request (PR)

La PR est une demande de **vérification et de validation** de nos ajouts, afin que celle-ci soit ensuite ajoutée à la branche principale. L'action de fusion d'une branche est appelé un **merge**.

Il est aussi important d'être le plus **clair et précis possible** lors de la rédaction du titre et de la description.

![Github PR](https://drive.google.com/file/d/135ijZk47dYgeH2Rj5NKm5ZjNraW1cxK8/view?usp=share_link)

### Et ensuite

Si la PR est validée puis merge et qu'on décide de continuer de travailler sur le projet, il ne faut pas oublier dans son environnement local de retourner sur la branche “main” afin d’aller chercher les nouvelles modifications ajoutées à la branche principale sur Github (ce qu’on appelle un **pull**).

```
git pull origin main
```

## Processus de qualité à utiliser et règles à respecter

Afin d'obtenir une bonne qualité de code avant de le partager, veuillez utiliser les outils suivant :

-   PHP Mess Detector : analyse statique qui a pour objectif d'identifier les erreurs potentielles dans le code, les violations des bonnes pratiques de programmation, les pratiques dangereuses et les incohérences dans le style du code.
    Il identifie entre autres les problèmes de code tels que les classes trop complexes, les fonctions trop longues, les dépendances excessives, les variables inutilisées, les boucles infinies, les expressions complexes, les violations de conventions de nommage, et bien plus encore.

Exemple d'utilisation :

```
vendor/bin/phpmd src text .phpmd.xml
```

-   PHP CodeSniffer : outil de vérification de la conformité du code source à un ensemble de standards de codage prédéfinis. Il détecte automatiquement les problèmes de code qui ne respectent pas les normes de codage telles que PSR-1, PSR-2, PSR-12, etc. Suivre ces standards permet d’améliorer la lisibilité et la compréhension du code par tous ceux qui l'utilisent et permet d’éviter de nombreux bugs.

Exemple d'utilisation :

```
vendor/bin/phpcs --standard=PSR12 src
```

Voici plusieurs raisons d’utiliser cet outil :

-   **Standardisation du code** : permet d'appliquer des standards de codage pour uniformiser le style de code dans un projet. Les développeurs peuvent définir les standards de codage à appliquer en fonction de leurs besoins spécifiques.

-   **Détection des erreurs de code** : permet de détecter les erreurs de codage dans un projet, telles que les erreurs de syntaxe, les problèmes de formatage et de style de code, les problèmes de sécurité et de performances, etc.

-   **Optimisation de la qualité de code** : permet d'améliorer la qualité de code en détectant et en corrigeant les problèmes de code dès le début du processus de développement. Cela peut éviter des erreurs coûteuses et faciliter la maintenance du code à long terme.

-   PHP Coding standards fixer : outil qui permet d'appliquer des standards de codage à un projet PHP. Il peut être utilisé pour détecter et corriger automatiquement les problèmes de formatage et de style de code, tels que l'indentation, les espaces, les retours à la ligne, la casse, les commentaires, etc.

Exemple d'utilisation :

```
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

Voici plusieurs raisons d’utiliser cet outil :

-   **Uniformisation du code** : permet de normaliser le style de code dans un projet en appliquant les standards de codage définis par la communauté PHP ou personnalisés par l'utilisateur.

-   **Économie de temps** : permet de gagner du temps en détectant et en corrigeant automatiquement les problèmes de formatage et de style de code, ce qui peut éviter des erreurs humaines et des corrections manuelles fastidieuses.

-   **Cohérence du code** : permet de maintenir la cohérence du code dans un projet, ce qui facilite la compréhension et la maintenance du code par l'équipe de développement.

Notes :

PHP Coding Standards Fixer et PHP CodeSniffer sont deux outils différents mais complémentaires qui sont utilisés pour améliorer la qualité de code en PHP.
L'objectif principal de PHP Coding Standards Fixer est de **corriger automatiquement les erreurs** de code en appliquant les règles de codage définies dans les normes de codage telles que PSR-1, PSR-2, PSR-12, etc. D'un autre côté, PHP CodeSniffer est principalement utilisé pour **détecter les erreurs de code et pour fournir des rapports détaillés** sur les violations des normes de codage.

-   PHPStan : analyseur statique pour PHP qui permet de détecter les erreurs de typage telles que des erreurs de type de données, des erreurs de paramètres de fonction, des erreurs de propriété de classe, des erreurs de méthode et des erreurs de retour de fonction, les incohérences de données elles que des variables non initialisées, des variables non utilisées et des expressions qui peuvent être simplifiées et autres erreurs potentielles.

Exemple d'utilisation :

```
vendor/bin/phpstan analyse -c phpstan.neon
```

PHP Copy/Paste Detector : outil qui permet de détecter les codes dupliqués dans un projet PHP. Le but de l'outil est d'aider à identifier les parties du code qui peuvent être regroupées et factorisées pour améliorer l'efficacité et la maintenabilité du projet.

Exemple d'utilisation :

```
phpcpd src
```

-   Codacy : 'analyse de code en ligne qui permet de détecter automatiquement les erreurs de code, les problèmes de sécurité et les mauvaises pratiques de développement et permet d'avoir un rendu graphique à partager des résultats obtenu.

## Tests mis en place

En plus de l'utilisation des ces outils il est demander de rédiger des tests lors de l'ajout d'une nouvelle fonctionnalité pour plusieurs raisons :

1. Vérifier le bon fonctionnement de la nouvelle fonctionnalité : Les tests permettent de s'assurer que la nouvelle fonctionnalité a été implémentée correctement et que le comportement de l'application n'a pas été altéré.
2. Faciliter la maintenance : Les tests servent également à garantir que les fonctionnalités existantes ne sont pas affectées par les modifications apportées. Cela facilite la maintenance de l'application à long terme.
3. Réduire les risques de régression : Les tests automatisés réduisent les risques de régression en signalant les erreurs dès qu'elles se produisent. Cela permet de détecter les problèmes avant qu'ils ne soient trop importants et plus difficiles à corriger.

### Exemple de workflow :

On souhaite ajouter la fonctionnalité de création d'une tâche à notre projet. On va donc créer le fichier [CreateTest.php](https://github.com/F-Jean/projet8-TodoList/blob/master/tests/Task/CreateTest.php) dans un dossier Task qui contiendra tout les tests liés à cette nouvelle fonctionnalité.

On sait qu'une tâche devra avoir un titre et une description, et qu'elle devra être afficher sur la page de liste des tâches.
On écrit un test pour chacun des cas, on test :

-   la soumission et l'affichage d'une tâche correctement renseigné ;
-   puis la soumission d'une tâche avec un titre non conforme et l'affichage d'un message d'erreur ;
-   un test pour une description non conforme eet l'affichage d'un message d'erreur;
-   un test pour un titre déjà existant et l'affichage d'un message d'erreur.

Une fois les tests écrit, on développe la fonctionnalité. On se sert des outils de vérification de qualité du code vu précédemment puis on relance les tests jusqu'à qu'ils soient tous correct.

## Performances

Pour la performance plusieurs choix sont possibles, soit la debug barre fournie par Symfony soit un autre outil comme [Blackfire](https://blackfire.io/docs/introduction).

Blackfire permet de profiler les scripts PHP, de détecter et d'analyser les goulets d'étranglement dans le code et les requêtes SQL, afin d'identifier les améliorations possibles pour optimiser les performances. Il génère un rapport sur les performances des différentes méthodes.

Il fonctionne en générant des profils de performances en temps réel pour chaque requête ou exécution de code, ce qui permet de comprendre exactement ce qui se passe dans l'application à un niveau très précis. Les profils de performance générés fournissent des informations détaillées sur la consommation de ressources du code, y compris la consommation de CPU, de mémoire et d'E/S, ainsi que les temps de réponse pour chaque appel de méthode, fonction ou requête SQL.

Il faut néanmoins faire la différence entre les temps “excluded” et les “included”.

-   Les **excluded** prennent en compte que le code spécifique à la fonction spécifié. **Le temps d’une autre fonction qui serait aussi appelé n’est pas pris en compte**.

-   Les **included**, eux, **prennent en compte tout le code d’une fonction avec celles des autres fonctions auxquelles elle fait appelle**.

C’est important car il faut comprendre qu’une fonction n’est pas forcément mal optimisée dès qu’on observe une baisse de performance, **le problème peut venir plus bas** d’une fonction auquelle on fait déjà appelle, qui elle peut être améliorer.

### Problématique performance VS lisibilité/compréhension du code

Si vous en venez à vous posez la question sur certaines parties de votre code, voici cune approche possible de la situation. A part si le gain de performance et vraiment très signifiant toujours préférer la compréhension du code.

Le projet est collaboratif et pour que l'application continue de fonctionner dans le temps, version après version, il est essentiel de faciliter sa maintenance à long terme. Il est donc important que les autres personnes qui travaillent sur le projet comprennent ce qui a été fait sous peine de les démoraliser et de les voirs abandonner.
On préfèrera une applcation "plus lente" mais fonctionnelle, qu'une application "très rapide" qu'on ne peut pas faire évoluée.
