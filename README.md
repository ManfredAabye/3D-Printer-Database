# 3D Printer Database

Dieses Projekt stellt eine universelle, hersteller- und softwareübergreifende Datenbanklösung für die gesamte 3D-Druckerwelt bereit. Ziel ist es, eine gemeinsame, offene Datenbasis für Drucker, Profile und Komponenten zu schaffen, die unabhängig von Firmware (z. B. Klipper, Marlin, Repetier), Slicer-Software (wie OrcaSlicer, PrusaSlicer, Cura etc.) oder Hersteller eingesetzt werden kann. Die Software ermöglicht es, alle relevanten Druckerdaten zentral zu verwalten, auszutauschen und in verschiedenste Systeme zu integrieren.

## Features

- Übersicht und Verwaltung von 3D-Druckern
- Verwaltung von Druckprofilen und Komponenten
- Unterstützung für verschiedene Firmware- und Kinematik-Typen
- Datenbank-Setup und automatische Migration fehlender Tabellen
- Backup- und Restore-Funktion
- Einfache Weboberfläche (PHP, Bootstrap)

## Installation

1. Repository klonen und auf einen Webserver mit PHP kopieren.
2. Datenbankzugang in `includes/config.php` anpassen.
3. Im Browser `install.php` aufrufen und die Datenbank einrichten.
4. Die Anwendung startet automatisch mit `index.php` (Weiterleitung zu `viewer.php`).

## Verzeichnisstruktur

- `includes/` – Konfiguration und Layout
- `functions/` – PHP-Funktionen für Datenbank und Logik
- `assets/` – CSS und JavaScript
- `viewer.php` – Übersicht und Details der Drucker
- `editor.php` – Administration und Bearbeitung
- `install.php` – Datenbankinstallation und Migration

## Lizenz

MIT
