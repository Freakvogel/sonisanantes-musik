<?php
/**
 * SONISANANTES ENERGETIC TOOLBOX – WordPress / PMPro Integration
 *
 * Diese Datei gehört NICHT auf den Server.
 * Sie zeigt den Code-Schnipsel, den du in WordPress einfügst.
 *
 * ─────────────────────────────────────────────────────────────────
 * SCHRITT 1: Toolbox-Dateien hochladen
 * ─────────────────────────────────────────────────────────────────
 * Lade den Ordner /toolbox/ per FTP/SFTP auf deinen All-Inkl-Server,
 * sodass die App unter https://sonisanantes.de/toolbox/app.html erreichbar ist.
 * (Den genauen Pfad kannst du frei wählen, dann URL unten anpassen.)
 *
 * ─────────────────────────────────────────────────────────────────
 * SCHRITT 2: WordPress-Seite anlegen
 * ─────────────────────────────────────────────────────────────────
 * 1. Neue Seite anlegen: „Energetic Toolbox"
 * 2. Template: „Vollbreite" oder „Blank Canvas" (ohne Sidebar)
 * 3. PMPro: Mitgliedschaftsebene(n) zuweisen, die Zugang erhalten
 * 4. Im Seiteninhalt den Shortcode einfügen (→ Schritt 3)
 *
 * ─────────────────────────────────────────────────────────────────
 * SCHRITT 3: Shortcode für den Seiteninhalt
 * ─────────────────────────────────────────────────────────────────
 * Füge in der WP-Seite einen „Custom HTML"-Block ein mit:
 *
 *   [energetic_toolbox]
 *
 * Der Shortcode wird durch die Funktion unten erzeugt.
 * Diese Funktion gehört in dein Child-Theme (functions.php) oder ein
 * kleines Plugin (z. B. via „Code Snippets"-Plugin).
 */

// ── In functions.php / Code Snippets einfügen ──────────────────────

add_shortcode( 'energetic_toolbox', function() {
    if ( ! is_user_logged_in() ) {
        return '<p>Bitte <a href="' . wp_login_url( get_permalink() ) . '">melde dich an</a>, um auf die Energetic Toolbox zuzugreifen.</p>';
    }

    $user      = wp_get_current_user();
    $firstname = esc_attr( $user->first_name ?: $user->display_name );
    $email     = esc_attr( $user->user_email );

    // URL zur Toolbox-App (anpassen falls anderer Pfad)
    $app_url = home_url( '/toolbox/app.html' )
        . '?name=' . rawurlencode( $firstname )
        . '&email=' . rawurlencode( $email )
        . '&nonce=' . wp_create_nonce( 'toolbox_access' );

    ob_start();
    ?>
    <style>
      .soni-toolbox-wrap {
        position: relative;
        width: 100%;
        /* Vollbild minus WP-Header */
        height: calc(100vh - var(--wp-admin--admin-bar--height, 0px) - 60px);
        min-height: 600px;
        overflow: hidden;
        border-radius: 0;
      }
      .soni-toolbox-wrap iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
      }
    </style>
    <div class="soni-toolbox-wrap">
      <iframe
        src="<?php echo $app_url; ?>"
        title="Energetic Toolbox"
        allow="autoplay; fullscreen"
        loading="lazy">
      </iframe>
    </div>
    <?php
    return ob_get_clean();
} );

/**
 * ─────────────────────────────────────────────────────────────────
 * SCHRITT 4: Menü / "Apps & Tools"-Seite
 * ─────────────────────────────────────────────────────────────────
 * Auf der Übersichtsseite (wo Engelszahlen, Tierboten etc. stehen)
 * eine neue Karte / einen neuen Link zur Energetic Toolbox hinzufügen.
 *
 * Das genaue HTML hängt von deinem Theme ab.
 * Beispiel für einen Link-Block:
 *
 *   <a href="/energetic-toolbox/">
 *     <div class="app-card">
 *       <div class="app-icon">🧰</div>
 *       <div class="app-title">Energetic Toolbox</div>
 *       <div class="app-desc">7 Techniken · Chakra-Werkzeuge · Geführte Übungen</div>
 *     </div>
 *   </a>
 *
 * ─────────────────────────────────────────────────────────────────
 * SCHRITT 5: Logout-Nonce (optional, für sauberes Abmelden)
 * ─────────────────────────────────────────────────────────────────
 * Damit der Abmelden-Button in der Toolbox funktioniert,
 * die Nonce per inline-Script an die Seite übergeben:
 */

add_action( 'wp_footer', function() {
    if ( ! is_user_logged_in() ) return;
    $nonce = wp_create_nonce( 'log-out' );
    echo '<script>window._wpLogoutNonce = ' . json_encode( $nonce ) . ';</script>';
} );
