# Zum Haarmann's Barber — Website

Custom WordPress FSE-Theme für [zumhaarmann.ch](https://zumhaarmann.ch), den Zürcher Barbershop von Matthis Latscha am Schaffhauserplatz.

Dieses Repository enthält:

- ein eigenständiges **Full-Site-Editing-Theme** (`haarmann`) auf Basis von Standard-Gutenberg-Blocks
- die DDEV-Konfiguration für die lokale Entwicklung
- bei Bedarf ein Custom-Block-Plugin (`haarmann-blocks`) für blockspezifische Erweiterungen

WordPress-Core und Drittanbieter-Plugins sind **nicht** Teil des Repos — siehe `.gitignore`.

---

## Voraussetzungen

| Tool | Version |
|------|---------|
| [DDEV](https://ddev.com/) | ≥ 1.24 |
| Docker | aktuelle Version |
| Git | ≥ 2.30 |

Für Theme-/Plugin-Entwicklung optional:

- Node.js ≥ 20 (falls Build-Tools im Plugin hinzukommen)
- Composer ≥ 2 (für PHP-Tooling wie PHP_CodeSniffer)

---

## Setup

### Erstinstallation

```bash
git clone <repo-url> zumhaarmann.ch
cd zumhaarmann.ch

# DDEV starten — installiert WordPress beim ersten Start nicht automatisch
ddev start

# WordPress-Core herunterladen + installieren
ddev wp core download --locale=de_CH
ddev wp core config --dbname=db --dbuser=db --dbpass=db --dbhost=db --skip-check
ddev wp core install \
  --url=https://zumhaarmann.ddev.site \
  --title="Zum Haarmann's Barber" \
  --admin_user=admin \
  --admin_password=admin \
  --admin_email=admin@zumhaarmann.ddev.site \
  --skip-email

# Theme aktivieren
ddev wp theme activate haarmann

# Permalinks auf hübsche URLs
ddev wp rewrite structure '/%postname%/'
```

Anschliessend ist die Seite unter <https://zumhaarmann.ddev.site> erreichbar.
WP-Admin: <https://zumhaarmann.ddev.site/wp-admin> (`admin` / `admin`).

### Initiale Inhalte (optional)

```bash
# Home- und Impressums-Seite anlegen
ddev wp post create --post_type=page --post_title='Home' --post_status=publish --post_name=home
ddev wp post create --post_type=page --post_title='Impressum' --post_status=publish --post_name=impressum

# Home als Startseite setzen
ddev wp option update show_on_front 'page'
ddev wp option update page_on_front $(ddev wp post list --post_type=page --name=home --field=ID --posts_per_page=1)

# Home-Page mit allen Sektionen befüllen (Hero, Willkommen, Termin,
# Services, Über mich, Anreise, Galerie als editierbare Block-Liste)
ddev wp eval-file tools/seed-home-content.php
```

---

## Repo-Struktur

```
zumhaarmann.ch/
├── .ddev/                          # DDEV-Konfig (versioniert)
├── design/screenshots/             # Referenz-Screenshots aus Figma
├── public_html/                    # Web-Root (DDEV docroot)
│   └── wp-content/
│       ├── themes/haarmann/        # ← versioniert
│       └── plugins/haarmann-blocks/ # ← versioniert (sobald angelegt)
├── tools/                          # WP-CLI / Setup-Helper
│   └── seed-home-content.php       # Home-Page mit allen Sektionen befüllen
├── .gitignore
├── CLAUDE.md                       # Hinweise für Claude Code
└── README.md
```

---

## Theme `haarmann`

Komplett **Full-Site-Editing**. Layouts, Farben, Typografie und Spacings sind über `theme.json` definiert. Templates und Parts sind reine HTML-Dateien mit Block-Markup, jede Sektion ist als wiederverwendbares **Pattern** angelegt.

### Verzeichnisstruktur

```
haarmann/
├── theme.json                      # Design-Tokens (Farben, Fonts, Spacings)
├── style.css                       # Theme-Header
├── functions.php                   # Bootstrap, Asset-Enqueue, Pattern-Kategorie
├── templates/
│   ├── front-page.html             # One-Pager Startseite
│   ├── page.html
│   ├── page-blank.html
│   ├── index.html                  # Blog-Fallback
│   └── 404.html
├── parts/
│   ├── header.html                 # Sticky Header mit Logo + DE + Burger
│   └── footer.html                 # Impressum + Social Icons
├── patterns/                       # Wiederverwendbare Sektionen
│   ├── hero.php
│   ├── welcome.php
│   ├── booking.php
│   ├── services.php                # Preisliste mit drei Gruppen
│   ├── about.php
│   ├── anreise.php
│   └── gallery.php
└── assets/
    ├── css/main.css                # Front-end- & Editor-Styles
    └── images/                     # Logo + Platzhalter
```

### Designsystem

- **Farben:** `dark` (#1A1612), `beige` (#B59572), `gold` (#C9A876), `cream` (#E8DDC8), `white`, `black`
- **Schriften:** zwei Familien, Brand-Fonts via lokale woff2 + WordPress Font-API
  - `display` — **Asul Bold** (Regular + Bold) — alle Headlines, uppercase + Letter-Spacing 0.06em
  - `body` — **Urbanist** (Variable Font 100–900) — Fliesstext, UI, Navigation
- **Spacings:** fluide Tokens `10`–`70`, alle mit `clamp(...)` für lineares Skalieren von Mobile zu Desktop
- **Schriftgrössen:** alle ab `medium` mit `fluid: true`

Schriften werden über `fontFace`-Einträge in `theme.json` aus `assets/fonts/` geladen — keine Drittanbieter-CDN, keine DSGVO-Hürde. Siehe [`CLAUDE.md`](CLAUDE.md) wie weitere Cuts hinzugefügt werden.

### Patterns

Jede Sektion ist ein eigenes Pattern (`patterns/*.php`) und kann via Site-Editor in jeder Page eingefügt werden. Die Front-Page ruft alle Patterns nacheinander auf.

### Responsive

- Mobile-First mit fluiden Tokens — kein expliziter Breakpoint-Set in der Standardansicht nötig
- Zusätzliche Breakpoints in [`assets/css/main.css`](public_html/wp-content/themes/haarmann/assets/css/main.css):
  - `≥ 600px` → Buchungs-Buttons nebeneinander
  - `≥ 900px` → Logo grösser

---

## Entwicklung

### Häufige Befehle

```bash
ddev start                          # Container hochfahren
ddev stop                           # Container stoppen
ddev describe                       # URLs, DB-Zugang, etc.
ddev launch                         # Site im Browser öffnen
ddev launch -p                      # phpMyAdmin öffnen
ddev wp <command>                   # WP-CLI ausführen
ddev ssh                            # in den Web-Container

# Cache & Theme-Cache leeren nach Änderungen
ddev wp cache flush
ddev wp transient delete --all
```

### Theme-Änderungen

Templates/Parts/Patterns sind reine HTML/PHP-Dateien — Änderungen sind sofort sichtbar (kein Build-Step). `theme.json`-Änderungen werden im Site-Editor manchmal gecached; im Zweifel:

```bash
ddev wp transient delete --all
```

### Code-Style

- PHP: WordPress Coding Standards (Tabs für Einrückung, snake_case für Funktionen, `haarmann_` Prefix)
- HTML in Templates: Tabs, Block-Markup formatiert wie vom Block-Editor erzeugt
- CSS: BEM-ähnlich (`.section-*`, `.price-list__row`), Custom Properties via `--wp--preset--*`

---

## Deployment

> **TODO** — wird ergänzt sobald die Hosting-Umgebung feststeht.

Aktuell ist nur die lokale Entwicklung mit DDEV eingerichtet.

---

## Mitwirken

1. Neue Branch von `main` ziehen
2. Änderungen am Theme/Plugin commiten (kleine, beschreibende Commits)
3. Pull-Request öffnen — Reviews und Tests folgen lokal via DDEV

---

## Lizenz

Code: GPL-2.0-or-later (kompatibel zu WordPress).
Inhalte (Texte, Bilder, Branding): © Matthis Latscha / Zum Haarmann's Barber — alle Rechte vorbehalten.
