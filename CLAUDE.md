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

### Pattern-First

**Standard-Gutenberg-Blocks reichen für alles, was bisher gebaut ist.** Jede Sektion ist ein Pattern unter `patterns/*.php`. Die Front-Page ist eine schlanke Komposition dieser Patterns:

```html
<!-- wp:pattern {"slug":"haarmann/welcome"} /-->
<!-- wp:pattern {"slug":"haarmann/booking"} /-->
…
```

Wenn du eine neue Sektion brauchst → neuer Pattern-File. Wenn ein Pattern editor-seitig schwer zu pflegen ist → Custom Block (siehe unten).

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

Aktuell via Google Fonts (`fonts.googleapis.com`) geladen — schnell für Dev. **Vor Produktiv-Launch lokalisieren** (DSGVO):

1. Cinzel, Cormorant Garamond, Inter als woff2 herunterladen → `assets/fonts/<family>/*.woff2`
2. `fontFace` in `theme.json` deklarieren (siehe [Block-Editor-Handbook → Fonts](https://developer.wordpress.org/themes/global-settings-and-styles/settings/typography/#fontfamilies))
3. Google-Fonts-Enqueue + `wp_resource_hints`-Filter in `functions.php` entfernen

### Bilder

Im Repo liegen aktuell nur **Platzhalter** (mit Pillow generiert) unter `assets/images/`:
- `hero.jpg` — warmer dunkler Verlauf, Stand-in für Barbershop-Foto
- `about.jpg`, `gallery-1..3.jpg` — Verlaufs-Platzhalter
- `logo.png`, `logo.svg` — provisorisches Logo

Sobald echtes Bildmaterial da ist:
- Hero ≥ 1920×1080, optimiert (max ~250 KB), kein hartes Subjekt am Rand (Mobile-Crop)
- About-Foto ~800×1000 hochkant
- Galerie-Bilder quadratisch ~1200×1200

`assets/images/logo.png` ist als Site-Logo (Media-ID 7) gesetzt — wenn ein neues Logo hochgeladen wird, ist es einfacher es im Site-Editor zu tauschen, statt die Datei zu überschreiben.

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
- [ ] Echtes Logo (PNG aktuell ist eine grobe DejaVu-Skizze)
- [ ] Buchungs-Buttons: korrekte Booksy-/Treatwell-URL und Telefonnummer eintragen
- [ ] Sprachschalter funktional machen (Polylang)
- [ ] Google Fonts → lokal bundlen (DSGVO)
- [ ] Hosting-/Deployment-Pipeline aufsetzen
- [ ] Cookie-Banner falls Tracking-Tools dazukommen
- [ ] Performance-Audit (Lighthouse, WebPageTest) vor Launch
- [ ] Newsletter-Anbindung (falls gewünscht)

## Häufige Fallstricke beim Arbeiten

1. **Cache nach `theme.json`-Änderungen** — Site-Editor zeigt manchmal alte Werte. Lösung: `ddev wp transient delete --all` oder Browser-Hard-Reload.
2. **`<!-- wp:pattern -->` rendert nichts** — wahrscheinlich ist der `slug` falsch. Slug = Wert aus dem Pattern-Header (`Slug: haarmann/<name>`).
3. **Block-Markup im Pattern muss valide sein** — wenn das Markup kaputt ist, schluckt WP den ganzen Block lautlos. Im Zweifel den Pattern in einer leeren Page einfügen und den HTML-Output mit `view-source:` prüfen.
4. **Pattern-PHP wird beim Rendern ausgeführt** — `<?php ... ?>`-Blöcke und `esc_html_e()` funktionieren wie in normalen Templates.
5. **Datenbank-State nicht im Repo** — beim Klonen muss der Empfänger die Pages und das Menü selbst anlegen (oder einen DB-Dump importieren).

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
