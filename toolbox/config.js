// ═══════════════════════════════════════════════════════
//  SONISANANTES TOOLS – KONFIGURATION
//  Trage hier deine Zugangsdaten ein, dann funktioniert alles.
// ═══════════════════════════════════════════════════════

// 1) Supabase  →  supabase.com → Project Settings → API
const SUPABASE_URL  = 'DEINE_SUPABASE_URL_HIER';
const SUPABASE_ANON = 'DEIN_ANON_KEY_HIER';

// 2) Stripe  →  dashboard.stripe.com → Entwickler → API-Schlüssel
const STRIPE_PUBLIC_KEY = 'pk_live_DEIN_STRIPE_PUBLIC_KEY';

// 3) Stripe Preisplan-IDs  →  Stripe Dashboard → Produkte → Preise
const STRIPE_PRICE_MONTHLY = 'price_MONATS_ID_HIER';   // 9,90 € / Monat
const STRIPE_PRICE_YEARLY  = 'price_JAHRES_ID_HIER';   // 79,00 € / Jahr

// 4) Dein Backend-Endpunkt für Checkout-Sessions
//    (Netlify Function / Vercel Serverless / All-Inkl PHP – siehe SETUP.md)
const CHECKOUT_ENDPOINT = '/api/create-checkout';
const PORTAL_ENDPOINT   = '/api/customer-portal';

// ───── Ab hier nichts verändern ─────
const _cfg = { SUPABASE_URL, SUPABASE_ANON, STRIPE_PUBLIC_KEY,
               STRIPE_PRICE_MONTHLY, STRIPE_PRICE_YEARLY,
               CHECKOUT_ENDPOINT, PORTAL_ENDPOINT };
