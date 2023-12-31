# Formulaire PHP Sécurisé avec Stockage en Base de Données

Ce projet consiste en un formulaire en PHP intégré à une page HTML. Les données soumises via le formulaire sont stockées de manière sécurisée dans une base de données MySQL. Ce README vous guide à travers la mise en place du projet.

## Configuration du Serveur

- **Serveur Web (Apache, Nginx, etc.) :** Assurez-vous d'avoir un serveur web configuré et en cours d'exécution sur votre machine.

- **PHP :** Installez PHP sur votre serveur. Vous pouvez utiliser la version PHP 7 ou supérieure.

- **Base de Données MySQL :** Configurez un serveur MySQL et créez une base de données pour stocker les informations du formulaire.

## Configuration de la Base de Données

- **Importer la Structure de la Table :** Utilisez le fichier SQL `structure.sql` pour créer la table nécessaire dans votre base de données.

    ```bash
    mysql -u votre_nom_utilisateur -p votre_mot_de_passe votre_base_de_donnees < structure.sql
    ```

- **Configuration de la Connexion à la Base de Données :** Modifiez les informations de connexion dans le fichier PHP `index.php` :

    ```php
    $servername = "localhost";
    $username = "votre_nom_utilisateur";
    $password = "votre_mot_de_passe";
    $dbname = "votre_base_de_donnees";
    ```

## Utilisation du Formulaire

- **Accéder au Formulaire :** Ouvrez votre navigateur et accédez au formulaire en utilisant l'URL appropriée (ex: http://localhost/chemin/vers/index.php).

- **Soumettre le Formulaire :** Remplissez les champs requis du formulaire et soumettez-le.

- **Vérification des Données Soumises :** Les données soumises avec succès seront affichées sous le formulaire.

## Sécurité

- **Validation des Entrées :** Les entrées du formulaire sont validées et échappées pour prévenir les attaques XSS et par injection.

- **Mot de Passe :** Le mot de passe doit contenir au moins 5 caractères pour des raisons de démonstration, mais vous pouvez ajuster cette exigence.

- **Validation de l'Email :** L'adresse email est validée à l'aide de FILTER_VALIDATE_EMAIL.

## Avertissement

Ce projet est fourni à des fins éducatives et de démonstration. Avant de déployer une application en production, assurez-vous de mettre en œuvre des mesures de sécurité appropriées et de suivre les meilleures pratiques de développement sécurisé.




## Tache à faire :

1) validation des données pas php (vérifier que les champs sont pas vide, et que les données de soit pas corrompus). Utiliser filtervar (voir comment ça fonctionne). 

2) Créer une base de donnée appelé Php_Secure_Paul sécurisation, créer une table formulaire_data qui comportera tout les champs du formulaire en respectant les contraintes (3-20 caractères), 

3) créer la connexion PDO, créer la requête (préparée !) d'insertion de données

MySQLi :

- API orientée objet et procédurale.
- Spécifique à MySQL.
- Gestion des transactions spécifique à MySQLi.
- Plusieurs méthodes pour le "bind parameter" avec des types de données spécifiques.
- Fonctions spécifiques pour récupérer le nombre de lignes affectées.
- API spécifique à MySQL avec des fonctionnalités propres à MySQL.


PDO :

- API exclusivement orientée objet.
- Générique, prend en charge différentes bases de données.
- Interface générique pour la gestion des transactions.
- Un moyen unique de lier les paramètres, gestion automatique des types de données.
- Méthode rowCount() pour récupérer le nombre de lignes affectées.
- Interface commune pour travailler avec différentes bases de données.
- Offre plus de flexibilité pour la gestion des erreurs personnalisée.

Points Communs :

    Les deux offrent des fonctionnalités de sécurité avec des requêtes préparées.
    Les deux peuvent être utilisés pour interagir avec des bases de données relationnelles.
    Ils sont intégrés dans PHP et utilisent des fonctionnalités de gestion des erreurs.


4) obtimiser le code

Fichier obtimiseTaleauPaul.php