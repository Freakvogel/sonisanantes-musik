# Sonisanantes Tools – Setup-Anleitung

## Was du bekommst
- `index.html` — Landingpage mit Preiskarten (9,90 €/Monat · 79 €/Jahr)
- `login.html` — Supabase Login/Registrierung + Magic Link
- `dashboard.html` — Geschützter Bereich mit Links zu beiden Apps
- `api/` — Serverless Functions für Stripe Checkout, Webhook, Customer Portal
- `config.js` — Alle Zugangsdaten an einer Stelle

---

## Schritt 1 – Supabase einrichten

1. Gehe zu https://supabase.com → Neues Projekt erstellen (kostenlos)
2. **Project Settings → API** → kopiere:
   - `Project URL` → `SUPABASE_URL` in `config.js`
   - `anon public` → `SUPABASE_ANON` in `config.js`
3. Für den Webhook brauchst du zusätzlich den **Service Role Key** (nicht in config.js, sondern als Serverless-Env-Variable)

---

## Schritt 2 – Stripe einrichten

1. https://dashboard.stripe.com → Konto erstellen
2. **Produkt erstellen:**
   - Name: "Sonisanantes Tools Abo"
   - Preis 1: 9,90 € / Monat → wiederkehrend → ID notieren
   - Preis 2: 79,00 € / Jahr → wiederkehrend → ID notieren
3. **Entwickler → API-Schlüssel:**
   - Öffentlicher Schlüssel → `STRIPE_PUBLIC_KEY` in `config.js`
   - Geheimer Schlüssel → Serverless-Env-Variable `STRIPE_SECRET_KEY`
4. **Stripe Billing Portal aktivieren:**
   - Stripe Dashboard → Settings → Billing → Customer Portal → Aktivieren
5. Beide Preis-IDs in `config.js` eintragen

---

## Schritt 3 – Hosting (Netlify empfohlen)

### Option A: Netlify (einfachste Option)
1. Konto erstellen auf https://netlify.com
2. Ordner `sonisanantes-tools/` auf Netlify hochladen (Drag & Drop)
3. Domain: Netlify gibt dir eine URL wie `amazing-xyz.netlify.app`
4. Optional: tools.sonisanantes.com als Custom Domain einrichten

**Env-Variablen in Netlify setzen** (Site Settings → Environment Variables):
```
STRIPE_SECRET_KEY      =  sk_live_...
STRIPE_PRICE_MONTHLY   =  price_...
STRIPE_PRICE_YEARLY    =  price_...
STRIPE_WEBHOOK_SECRET  =  whsec_...  (nach Schritt 4)
SUPABASE_URL           =  https://xyz.supabase.co
SUPABASE_SERVICE_KEY   =  eyJh...
SITE_URL               =  https://tools.sonisanantes.com
```

**netlify.toml** (erstelle diese Datei im Ordner):
```toml
[build]
  functions = "api"

[[redirects]]
  from = "/api/*"
  to = "/.netlify/functions/:splat"
  status = 200
```

---

## Schritt 4 – Stripe Webhook registrieren

1. Stripe Dashboard → Entwickler → Webhooks → Endpunkt hinzufügen
2. URL: `https://tools.sonisanantes.com/api/webhook` (oder Netlify-URL)
3. Events auswählen:
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
4. Webhook-Secret (whsec_...) in Netlify Env-Variable eintragen

---

## Schritt 5 – Apps verlinken

Lege folgende Dateien in denselben Ordner wie dashboard.html:
- `engelszahlen.html` (bereits vorhanden in Desktop/Claude Code/)
- `tierboten.html` (bereits vorhanden in Desktop/Claude Code/)

Die Apps öffnen als normale Seiten — kein Schutz nötig, da der Dashboard-Link nur für eingeloggte Abonnenten sichtbar ist. Wer die URL direkt kennt, kommt trotzdem rein. Wenn du das verhindern willst, kann ich einen Auth-Check-Header in beide Apps einbauen.

---

## Testen (Entwicklungsmodus)

- Stripe Test-Modus nutzen → Karte 4242 4242 4242 4242 für Testzahlungen
- Supabase: Du kannst manuell `subscribed: true` in der User-Metadata setzen, um das Dashboard zu testen

---

## Dateien-Übersicht

```
sonisanantes-tools/
├── index.html          ← Landingpage
├── login.html          ← Auth
├── dashboard.html      ← Geschützter Bereich
├── config.js           ← Deine Zugangsdaten (einmal ausfüllen)
├── engelszahlen.html   ← Hier hinkopieren
├── tierboten.html      ← Hier hinkopieren
├── SETUP.md            ← Diese Datei
└── api/
    ├── create-checkout.js   ← Stripe Checkout
    ├── webhook.js           ← Stripe → Supabase Sync
    └── customer-portal.js   ← Abo verwalten
```
