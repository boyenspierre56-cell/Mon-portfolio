# Gestionnaire de tâches (PHP + SQLite)

Petite application web pour ajouter, terminer et supprimer des tâches.

## Technologies
PHP 8, PDO, SQLite, HTML/CSS

## Lancer le projet
Dans ce dossier :

    php -S localhost:8000

Puis ouvrir http://localhost:8000 dans le navigateur.
(Extension PHP requise : `pdo_sqlite`, activée par défaut dans la plupart des installations.)

## Ce que démontre ce projet
- Requêtes préparées (protection contre l'injection SQL)
- Échappement des sorties (protection XSS)
- Pattern Post/Redirect/Get
