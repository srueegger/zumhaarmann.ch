# CLAUDE.md

Dieses Dokument richtet sich an Claude Code (oder andere KI-Assistenten), die in diesem Repo arbeiten. Es fasst die Architektur-Entscheidungen, die Konventionen und die offenen Punkte zusammen, damit Folge-Sessions sofort produktiv sind.

---

## Projekt in einem Satz

WordPress-Site (Full-Site-Editing) für den Zürcher Barbershop "Zum Haarmann's" — One-Pager mit dunklem Look, Roman-Serif-Headlines und beige/gold Akzent. Geliefert wird ein eigenständiges Theme `haarmann`; Inhalte werden über den Site-Editor / die WordPress-Admin gepflegt.

## Architektur — was committed ist und was nicht

Das Repo trackt **nur** Custom-Code, nicht den WordPress-Core:

| Pfad | Versioniert? |
|------|--------------|
| `.ddev/config.yaml` | ja |
| `.gitignore` | ja |
| `README.md`, `CLAUDE.md` | ja |
| `public_html/wp-content/themes/haarmann/` | ja |
| `public_html/wp-content/plugins/haarmann-blocks/` | ja (sobald angelegt) |
| Alles andere unter `public_html/` | **nein** |

Wenn du ein neues Theme-File anlegst, achte darauf dass es in einen versionierten Pfad fällt — `git status` zeigt es sonst nicht.

## Stack & Versionen

- **WordPress** 6.9.x (FSE Pflicht — keine `header.php`/`footer.php` mehr im Theme!)
- **PHP** 8.1+
- **DDEV** mit MariaDB 10.11
- **Block-Editor** ausschliesslich; keine Klassik-Editor-Fallbacks

## Setup-Annahmen

- DDEV-Projektname: `zumhaarmann`
- DDEV-URL: <https://zumhaarmann.ddev.site>
- DB-Credentials in DDEV: `db / db / db` (Standard)
- WP-Admin: `admin / admin` (lokal — niemals so deployen)

## Theme-Konventionen

### Architektur: Page-Content first, Template = Shell

**Die Inhalte gehören in den Page-Content, nicht ins Template.** Der Kunde
muss die Startseite über `WP-Admin → Seiten → Home` (oder den Site-Editor)
ganz normal als Block-Liste bearbeiten können.

Konkret:

- `templates/front-page.html` ist eine **dünne Hülle** — nur Header,
  ein `<main>`-Wrapper mit `<!-- wp:post-content /-->`, und Footer.
  Keine `<!-- wp:pattern -->`-Refs, keine festverdrahteten Sektionen.
- Die **Home-Page** (`page_on_front`) hat alle Sektionen direkt im
  `post_content` als Block-Markup. Jede Sektion ist eine Group mit
  `align:full` und einer aussagekräftigen `metadata.name` (z. B.
  "Willkommen", "Termin vereinbaren") — die erscheint dann auch im
  List-View des Editors.
- Patterns unter `patterns/*.php` sind **Vorlagen für den Inserter**.
  Sie tauchen unter "Patterns → Haarmann" auf und können vom Kunden
  beliebig oft eingefügt werden, falls eine neue Sektion nötig ist.

Wenn der Kunde eine Sektion im Editor löscht / ändert / hinzufügt,
ändert sich nur die Page — Theme-Code bleibt unverändert.

### Initiales Seeding der Home-Page

Sobald die Patterns aktualisiert wurden oder die Datenbank frisch ist,
kann die Home-Page mit allen Sektionen neu befüllt werden:

```bash
ddev wp eval-file tools/seed-home-content.php
```

Das Script rendert alle sieben Patterns einmal und schreibt das Resultat
in den `post_content` der Home-Page (ID aus `page_on_front`-Option).
Idempotent — beim zweiten Aufruf wird der Inhalt überschrieben.

**Achtung:** Wenn der Kunde Inhalte editiert hat, würde das Script die
Änderungen platt machen. Vor produktivem Einsatz also nur als
Setup-Tool nutzen, nicht im laufenden Betrieb.

### Pattern-First (für neue Sektionen)

**Standard-Gutenberg-Blocks reichen für alles, was bisher gebaut ist.**
Eine neue Sektion → neuer Pattern-File unter `patterns/<slug>.php`.
Sobald die Pattern-Datei existiert, ist sie automatisch im Inserter
verfügbar.

Wenn ein Pattern editor-seitig schwer zu pflegen ist (z. B. weil die
Block-Struktur zu fragil ist und beim Editieren leicht kaputt geht)
→ Custom Block (siehe unten).

### Wann Custom Blocks?

Aktuell **nicht aktiv** umgesetzt. Kandidaten falls die Editor-UX leiden sollte:

- **Price Item / Price Group** — die `services.php` rendert Server-side ein PHP-Loop, aber sobald sie als Pattern eingefügt wird, sind alle Rows einzelne Group-Blocks. Edit-able, aber Add/Remove ist klobig. Ein Custom Block mit `InnerBlocks` wäre angenehmer.
- Wenn du Custom Blocks anlegst: Plugin `public_html/wp-content/plugins/haarmann-blocks/` mit `block.json`-First-Approach; `wp-scripts` für Build.

### theme.json ist die Quelle der Wahrheit

Farben, Fonts, Spacings, Block-Defaults gehen **immer** zuerst in `theme.json`. CSS in `assets/css/main.css` ist nur für das, was sich nicht über Tokens regeln lässt (Sticky Header, Hover-Animationen, BEM-Tweaks).

Pattern-CSS-Klassen folgen BEM-light:
- Section-Wrapper: `.section-<name>` (z. B. `.section-services`)
- Komponenten: `.price-list`, `.price-list__row`

### Schriften

**Asul** (Headlines) und **Urbanist** (Body) — beide Google Fonts, aber
**lokal gebundlet** über die WordPress Font-API (`fontFace` in `theme.json`,
seit WP 6.5). Kein `wp_enqueue_style` für Google-Fonts-CSS, kein Preconnect
auf `fonts.gstatic.com`, kein DSGVO-Thema.

Files:

- `assets/fonts/asul/asul-400.woff2` (~13 KB, Latin)
- `assets/fonts/asul/asul-700.woff2` (~13 KB, Latin) — **alle Headlines**
- `assets/fonts/urbanist/urbanist-latin.woff2` (~28 KB, variable 100–900)
- `assets/fonts/urbanist/urbanist-latin-ext.woff2` (~17 KB, variable 100–900, mit `unicodeRange`)

WordPress generiert daraus automatisch die `@font-face`-Regeln in
`global-styles-inline-css`. Wenn du eine zusätzliche Schrift brauchst:

1. woff2 nach `assets/fonts/<family>/` legen
2. neuen Eintrag unter `settings.typography.fontFamilies` in `theme.json`
   anlegen mit `fontFace`-Array (`src: [ "file:./assets/fonts/..." ]`)
3. Cache leeren (`ddev wp transient delete --all`) — das war's

Die Fonts sind alle als ein Variable-File pro Sprache (Urbanist) oder zwei
Static-Cuts (Asul Regular + Bold) eingebunden. Wenn weitere Cuts gebraucht
werden: über die Google-Fonts-CSS-API mit modernem User-Agent ziehen
(`curl -A "Mozilla/5.0 ... Chrome/120 ..."`), URLs aus dem CSS extrahieren.

### Bilder

**Logo:** `assets/images/logo.svg` ist das finale Brand-Logo (Quelle in `design/Haarmann.svg`). Wird über die Media-Library als Site-Logo gesetzt — die Theme-Datei ist Quelle der Wahrheit, der Upload eine Kopie. Bei Logo-Update: `design/Haarmann.svg` ersetzen, in `assets/images/` kopieren, dann erneut ins Media-Library importieren und Site-Logo neu setzen.

**Fotos** sind aktuell **Platzhalter** (mit Pillow generierte warme Verläufe) unter `assets/images/`:
- `hero.jpg` — Stand-in für Barbershop-Foto
- `about.jpg`, `gallery-1..3.jpg` — Verlaufs-Platzhalter

Sobald echtes Bildmaterial da ist:
- Hero ≥ 1920×1080, optimiert (max ~250 KB), kein hartes Subjekt am Rand (Mobile-Crop)
- About-Foto ~800×1000 hochkant
- Galerie-Bilder quadratisch ~1200×1200

### Google Maps

`patterns/map.php` bettet einen vollbreiten Google-Maps-iframe für die Studio-Adresse ein. Verwendet die **Maps Embed API** (kostenfrei, ohne Limit pro Site), kein JavaScript-SDK.

API-Key + Adresse werden **nicht im Code** gespeichert, sondern entweder:

1. Konstante `HAARMANN_GMAPS_API_KEY` in `wp-config.php` (empfohlen für Produktiv)
2. wp_options-Eintrag `haarmann_gmaps_api_key` (lokal/staging via WP-CLI)

Setzen via:

```bash
ddev wp option update haarmann_gmaps_api_key "AIza..."
ddev wp option update haarmann_gmaps_address "Im Eisernen Zeit 1, 8057 Zürich"
```

Wichtig in der **Google Cloud Console**: Key auf erlaubte Domains restricten (HTTP referrers `*.zumhaarmann.ch/*`, `localhost/*`, `*.ddev.site/*`), sonst kann er von beliebigen Sites missbraucht werden. Maps Embed API + Maps JavaScript API müssen aktiviert sein.

Resolver in [`functions.php`](public_html/wp-content/themes/haarmann/functions.php): `haarmann_get_gmaps_api_key()` und `haarmann_get_gmaps_address()`. Falls kein Key gesetzt ist, fällt das Pattern auf einen normalen Google-Maps-Link zurück (kein kaputter iframe).

### SVG-Uploads

`functions.php` registriert MIME-Support für SVG, aber **nur für Admin-User** (`current_user_can('manage_options')`). Damit kann das Logo direkt im WP-Admin / Site-Editor getauscht werden, ohne dass Editor-Rollen Schadcode hochladen können.

Für Produktiv-Betrieb mit nicht-Admin-Editoren idealerweise das Plugin **Safe SVG** nachziehen, das Inhalte beim Upload sanitisiert.

## Inhalte / WP-Konfiguration

Per WP-CLI angelegt — werden **nicht** versioniert (sind in der DB):

- Page "Home" → als Startseite gesetzt (`page_on_front`)
- Page "Impressum"
- Hauptmenü mit Anchor-Links zu den Front-Page-Sektionen, an Location `primary` zugewiesen
- Site-Logo: `assets/images/logo.png` (Media-ID 7)
- Permalink-Struktur: `/%postname%/`

Wenn die DB neu aufgesetzt wird, müssen diese Schritte wiederholt werden — siehe README.md "Initiale Inhalte".

## Multilingual (DE/EN)

Im Design ist ein "DE"-Sprachschalter sichtbar — **noch nicht funktional implementiert**.

**Stack-Entscheidung: WPML.** Der Maintainer hat eine Lifetime-Lizenz und langjährige Erfahrung; Polylang oder Eigenbau sind explizit **nicht** im Scope.

Wenn das Thema umgesetzt wird:

1. WPML + WPML String Translation + WPML Translation Management installieren
2. Sprachen DE (Default) und EN anlegen, URL-Format: language as directory (`/en/`)
3. Alle Patterns auf translatable strings prüfen — bereits via `esc_html_e( '...', 'haarmann' )` vorbereitet, aber WPML String Translation registriert die zusätzlich on-the-fly
4. Front-Page klonen → englische Version aufbauen, Pattern-Inhalte über WPML übersetzen
5. Im Header das `[wpml_language_switcher]` (oder Block-Variante) statt des statischen "DE"-Paragraphen einbauen
6. Menus pro Sprache pflegen (WPML-spezifischer Menü-Sync)

## Bekannte offene Punkte

- [ ] Echte Fotos statt Platzhalter (Hero, About, Galerie)
- [ ] Buchungs-Buttons: korrekte Booksy-/Treatwell-URL und Telefonnummer eintragen
- [ ] Sprachschalter funktional machen (WPML)
- [ ] Hosting-/Deployment-Pipeline aufsetzen
- [ ] Cookie-Banner falls Tracking-Tools dazukommen
- [ ] Performance-Audit (Lighthouse, WebPageTest) vor Launch
- [ ] Newsletter-Anbindung (falls gewünscht)

## Häufige Fallstricke beim Arbeiten

1. **Cache nach `theme.json`-Änderungen** — Site-Editor zeigt manchmal alte Werte. Lösung: `ddev wp transient delete --all` oder Browser-Hard-Reload.
2. **Home-Page im Editor leer** — wenn `templates/front-page.html` Sektionen direkt enthält statt `<!-- wp:post-content /-->`, sieht der Kunde im Page-Editor nichts. Immer: Sektionen in den Page-Content, Template = Shell.
3. **Block-Markup im Pattern muss valide sein** — wenn das Markup kaputt ist, schluckt WP den ganzen Block lautlos. Im Zweifel den Pattern in einer leeren Page einfügen und den HTML-Output mit `view-source:` prüfen.
4. **Pattern-PHP wird beim Rendern ausgeführt** — `<?php ... ?>`-Blöcke und `esc_html_e()` funktionieren wie in normalen Templates. Beim Einfügen via Inserter wird das PHP einmalig aufgelöst und das Ergebnis als statisches Block-Markup in den Page-Content geschrieben.
5. **Datenbank-State nicht im Repo** — beim Klonen muss der Empfänger die Pages und das Menü selbst anlegen (oder einen DB-Dump importieren). Für die Home-Page hilft `tools/seed-home-content.php`.

## Hilfreiche Befehle

```bash
# Schnell-Check ob die Front-Page rendert
curl -sk https://zumhaarmann.ddev.site/ | grep -c "section-"   # sollte 6 sein

# Theme-Cache leeren
ddev wp transient delete --all && ddev wp cache flush

# Alle Patterns auflisten
ddev wp eval 'foreach (WP_Block_Patterns_Registry::get_instance()->get_all_registered() as $p) { echo $p["name"]."\n"; }' | grep haarmann

# Mit dem Browser ein Mobile-Viewport simulieren (z. B. Firefox Responsive Mode)
# DevTools > Responsive Design Mode > 375×812
```

## Stil für KI-Assistenten

- **Antworte auf Deutsch** — der Maintainer arbeitet auf Deutsch (Schweizerdeutsch / Hochdeutsch).
- **Standard-Blocks bevorzugen.** Custom Blocks nur wenn sie Editor-UX-Wert bringen.
- **theme.json-Tokens vor Inline-Styles.** Kein hardcoded `#1A1612` im Pattern; immer `var(--wp--preset--color--dark)`.
- **Keine Build-Tooling-Komplexität ohne Anlass.** Aktuell läuft alles ohne Node-Build — wenn ein Custom Block dazukommt, JA `wp-scripts` einsetzen.
- **Commits klein und beschreibend** — eine Sektion oder ein Feature pro Commit.
