# Energetic Toolbox – Upload auf All-Inkl (WordPress)

Die Toolbox läuft als eigenständige Mini-App in einem Unterordner deiner
WordPress-Website, z.B.:  https://deinedomain.de/toolbox/

WordPress wird dadurch nicht verändert. Die beiden Seiten laufen
komplett unabhängig nebeneinander.

---

## Was du brauchst

- Zugang zu deinem All-Inkl KAS (Kunden-Administrations-System)
- Ein FTP-Programm – empfohlen: FileZilla (kostenlos, https://filezilla-project.org)
- Deine FTP-Zugangsdaten (stehen in All-Inkl unter KAS → FTP-Konten)

---

## Schritt 1 – FTP-Zugangsdaten heraussuchen

1. Logge dich ein auf: https://kas.all-inkl.com
2. Gehe zu: **Webspace** → **FTP-Konten**
3. Notiere dir:
   - FTP-Server (z.B. `ssh.all-inkl.com` oder `ftp.deinedomain.de`)
   - Benutzername
   - Passwort
   - Port: `21`

---

## Schritt 2 – FileZilla einrichten & verbinden

1. Öffne FileZilla
2. Oben in die Leiste eintragen:
   - **Server:** dein FTP-Server aus Schritt 1
   - **Benutzername:** dein FTP-Benutzername
   - **Passwort:** dein FTP-Passwort
   - **Port:** `21`
3. Klicke auf **Verbinden**
4. Bestätige ggf. das Sicherheitszertifikat mit „OK"

---

## Schritt 3 – Den richtigen Ordner auf dem Server finden

Im rechten Bereich (Server-Seite) siehst du die Ordnerstruktur.

Navigiere zu:
```
/www/  oder  /html/  oder  /htdocs/
```
(der Ordner, in dem deine WordPress-Dateien liegen – du erkennst ihn
an Dateien wie `wp-config.php` und dem Ordner `wp-content/`)

---

## Schritt 4 – Neuen Ordner anlegen

1. Rechtsklick im rechten Bereich (Serverseite)
2. „Verzeichnis erstellen"
3. Name: **`toolbox`** (genau so, klein geschrieben)

Damit ist die Toolbox später erreichbar unter:
`https://deinedomain.de/toolbox/`

---

## Schritt 5 – Dateien hochladen

1. Im linken Bereich (dein Computer) navigiere zum Ordner:
   `Desktop → Claude Code → energetic-toolbox`

2. Wähle ALLE folgenden Dateien und Ordner aus:
   - `index.html`
   - `login.html`
   - `app.html`
   - `js/` (ganzer Ordner mit supabase-config.js und auth.js)

3. Ziehe sie per Drag & Drop in den `toolbox/`-Ordner auf dem Server

4. Warte bis alle Dateien übertragen sind (Fortschrittsanzeige unten)

---

## Schritt 6 – Supabase konfigurieren

Damit Login und Registrierung funktionieren:

1. Öffne: https://supabase.com → dein Projekt
2. Gehe zu: **Authentication** → **URL Configuration**
3. Trage ein:
   - **Site URL:** `https://deinedomain.de`
   - **Redirect URLs:** `https://deinedomain.de/toolbox/app.html`
4. Speichern

5. Öffne jetzt die Datei `js/supabase-config.js` auf deinem Computer
6. Trage deine Supabase-Zugangsdaten ein (laut SETUP.md)
7. Lade die Datei erneut hoch (überschreibe die alte Version)

---

## Schritt 7 – Testen

Öffne im Browser:
```
https://deinedomain.de/toolbox/
```

Du solltest jetzt die Landingpage sehen.

Klicke auf „Jetzt starten" → Login-Seite erscheint → Demo starten → App öffnet sich.

---

## Häufige Probleme

**Die Seite zeigt eine WordPress-Fehlerseite**
→ Stelle sicher, dass der Ordner wirklich `toolbox` heißt (nicht `Toolbox`)
→ Prüfe, ob die `index.html` direkt im `toolbox/`-Ordner liegt

**Login funktioniert nicht**
→ Supabase noch nicht eingerichtet? → Siehe SETUP.md
→ Die Redirect-URL in Supabase nicht eingetragen? → Schritt 6 wiederholen

**Dateien werden nicht angezeigt / 403-Fehler**
→ Rechtsklick auf den `toolbox/`-Ordner → Zugriffsrechte → `755` setzen

---

## Ergebnis

| Adresse | Inhalt |
|---|---|
| deinedomain.de | Deine WordPress-Website (unverändert) |
| deinedomain.de/toolbox/ | Energetic Toolbox Landingpage |
| deinedomain.de/toolbox/login.html | Login & Registrierung |
| deinedomain.de/toolbox/app.html | Die App (nur für Mitglieder) |
