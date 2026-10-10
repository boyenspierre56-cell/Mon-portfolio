# Convertisseur HTG / USD (Flutter)

Application mobile simple pour convertir des gourdes (HTG) en dollars (USD) et inversement,
avec un taux de change modifiable.

## Lancer le projet
Flutter doit être installé (https://docs.flutter.dev/get-started/install).

    flutter create .        # génère les dossiers android/ios (une seule fois)
    flutter pub get
    flutter run

## Points techniques
- Dart / Flutter, Material 3
- StatefulWidget, gestion des TextEditingController
- Validation des entrées (virgule ou point décimal, taux invalide)
