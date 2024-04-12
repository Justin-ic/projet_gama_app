___________Read me Justin 04-04-2024___________

1) On installe Laravel v9.*
	composer create-project laravel/laravel:^9.* projet_gama_app

2) cd projet_gama_app

3) Création de la commade: php artisan make:command InitProject

4) Je remplace le contenu du fichier InitProject.php notre code.
   "ERROR  There are no commands defined in the "project" namespace." signifie qu'il 
   n'a pas encore compris que le contenu de project à été modifier.
   Le plus rapide, c'est de remplacer le contenu du fichier au lieu de changer le fichier lui même.

5) Je fais la configuration du .env

6) Téléchargement de voyager: composer require tcg/voyager -W

7) Démarrer (Xamp, Wamp…) car project:init va créer des tables

8) Lancement de la commande: php artisan project:init

9) créer un utilisateur à la demande.

10) BRAVEAU !!!!!!!

11) php artisan serv

12) http://127.0.0.1:8000/ dans un navigateur affiche "Bienvenu sur Woody Builder"

13) Félicitation !!! Tout a été bien configuré !!!!