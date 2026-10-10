# Organisateur de fichiers (Python)

Script en ligne de commande qui range les fichiers d'un dossier (par exemple « Téléchargements »)
dans des sous-dossiers : Images, Documents, Videos, Audio, Archives, Code, Autres.

## Utilisation
Simulation (ne déplace rien) :

    python organizer.py ~/Downloads --dry-run

Exécution réelle :

    python organizer.py ~/Downloads

## Points techniques
- Python 3.8+, bibliothèque standard uniquement (aucune dépendance)
- `argparse`, `pathlib`, `shutil`
- Protection contre l'écrasement de fichiers (renommage automatique)
