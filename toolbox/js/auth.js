// ═══════════════════════════════════════════════════════
//  SONISANANTES TOOLBOX – AUTH HELPER
//  Stellt requireAuth() und authSignOut() bereit.
//  Wird von app.html geladen – nicht verändern.
// ═══════════════════════════════════════════════════════

let _sbClient = null;

function _getSB() {
  if (!_sbClient) {
    _sbClient = supabase.createClient(SUPABASE_URL, SUPABASE_ANON);
  }
  return _sbClient;
}

// Prüft ob eine gültige Session besteht.
// Leitet bei fehlendem Login auf login.html weiter.
// Gibt die Session zurück, wenn eingeloggt.
async function requireAuth() {
  const sb = _getSB();
  const { data: { session } } = await sb.auth.getSession();
  if (!session) {
    window.location.href = 'login.html';
    return null;
  }
  return session;
}

// Meldet den Nutzer ab und leitet auf login.html weiter.
async function authSignOut() {
  const sb = _getSB();
  await sb.auth.signOut();
  window.location.href = 'login.html';
}

// Gibt den aktuellen Supabase-Client zurück (für erweiterte Nutzung).
function getSupabaseClient() {
  return _getSB();
}
