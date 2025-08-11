# 3D Printer Database

ACHTUNG!!! Dies ist eine in der Entwicklung stehendes noch nicht korrekt funktionierendes Experiment.

Dieses Projekt bietet eine webbasierte Verwaltungsoberfläche für 3D-Drucker, Druckprofile und Komponenten. 
Die Datenbankstruktur ist so gestaltet, dass sie universell und portierbar für verschiedene 3D-Druck-Firmwares (z. B. Klipper, Marlin, Repetier) sowie Slicer-Software wie OrcaSlicer, 
PrusaSlicer, Cura und weitere geeignet ist. Ziel ist es, eine einheitliche, flexible Datenbasis zu schaffen, die unabhängig von der eingesetzten Firmware oder Slicer-Software genutzt werden kann.

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
