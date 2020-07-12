<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define( 'DB_NAME', 'emmnow_emmnow1' );

define( 'DB_NAME', 'emmnow_afldev' );

/** MySQL database username */
define( 'DB_USER', 'emmnow_emmnow' );

/** MySQL database password */
define( 'DB_PASSWORD', '04;AT{}(D},^' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ']:~Rj6D[UCS6k2 /;acO]]`)D(=Y9I:gM*2-=VLfvYEcyCmRDZfD,6$#q4_K:YIA' );
define( 'SECURE_AUTH_KEY',  '_W01N(Galmm&|6HN8u,C<ydpSNsI$g8pjvm;GO7V)7G:%?7r[u~HJiA%-b-NxjyQ' );
define( 'LOGGED_IN_KEY',    '7=&A5FA^Z&;|$D.^:Ktdd=$:t7QeXhpzA#W9&=Gl89<>t&-:y&P[{Hp/R$Y!2nW+' );
define( 'NONCE_KEY',        'Ek]_>D1UY>1Sfgb@Y6SwWuYI6a.CsToOh|Mwtm90M>|hO%czfH-*ZYBe:kL+%TjB' );
define( 'AUTH_SALT',        '9$_:>N!}+Dk7cR[poC#;ej0TFExa;puYK.HK u</K;ZOU}K4u<!+VlPUD>M=<GWd' );
define( 'SECURE_AUTH_SALT', 'r#@kYen_IVfGQ/k-V6had[Y>qhC7*Cl9 *`*)_DcI)R?l(rFX@KoK+=1Tu(B%^8c' );
define( 'LOGGED_IN_SALT',   '1@ C#?D*9-h_NC%S2Fo#03pf>HF%@Ct>@B]h~LelX}x4ZA6a#|Kv=?~dLHp)Z/E4' );
define( 'NONCE_SALT',       'dPd0b()Z{LcdP@o!8tkw+cp<f;]CzO(C3{YkwfUqh-~@M1C@j~ZJ)ij[~|!]Q^#j' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
