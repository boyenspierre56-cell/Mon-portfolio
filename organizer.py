#!/usr/bin/env python3
"""Range les fichiers d'un dossier dans des sous-dossiers selon leur type."""
import argparse
import shutil
from pathlib import Path

CATEGORIES = {
    "Images": {".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg"},
    "Documents": {".pdf", ".doc", ".docx", ".txt", ".odt", ".pptx", ".xlsx", ".csv"},
    "Videos": {".mp4", ".mkv", ".avi", ".mov"},
    "Audio": {".mp3", ".wav", ".ogg", ".m4a"},
    "Archives": {".zip", ".rar", ".7z", ".tar", ".gz"},
    "Code": {".py", ".php", ".js", ".html", ".css", ".dart", ".json"},
}


def category_for(path: Path) -> str:
    ext = path.suffix.lower()
    for name, extensions in CATEGORIES.items():
        if ext in extensions:
            return name
    return "Autres"


def unique_target(target: Path) -> Path:
    """Évite d'écraser un fichier existant en ajoutant _1, _2, ..."""
    counter = 1
    candidate = target
    while candidate.exists():
        candidate = target.with_name(f"{target.stem}_{counter}{target.suffix}")
        counter += 1
    return candidate


def organize(folder: Path, dry_run: bool = False) -> int:
    moved = 0
    for item in folder.iterdir():
        if not item.is_file() or item.name.startswith("."):
            continue
        dest_dir = folder / category_for(item)
        dest = unique_target(dest_dir / item.name)
        print(f"{'[simulation] ' if dry_run else ''}{item.name} -> {dest_dir.name}/")
        if not dry_run:
            dest_dir.mkdir(exist_ok=True)
            shutil.move(str(item), str(dest))
        moved += 1
    return moved


def main() -> None:
    parser = argparse.ArgumentParser(description="Organise un dossier par type de fichier.")
    parser.add_argument("folder", type=Path, help="Dossier à organiser")
    parser.add_argument("--dry-run", action="store_true", help="Affiche les actions sans rien déplacer")
    args = parser.parse_args()

    if not args.folder.is_dir():
        parser.error(f"'{args.folder}' n'est pas un dossier valide.")
    count = organize(args.folder, args.dry_run)
    print(f"\n{count} fichier(s) {'à déplacer' if args.dry_run else 'déplacé(s)'}.")


if __name__ == "__main__":
    main()
