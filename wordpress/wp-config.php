<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'a9431445_wp');

/** MySQL database username */
define('DB_USER', 'a9431445_wp');

/** MySQL database password */
define('DB_PASSWORD', 'mario004');

/** MySQL hostname */
define('DB_HOST', 'mysql10.000webhost.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ME0wB)Rqf1BK39TcK-JP,a>)FytT)gj8JcBni!)bTkzCgR44z2|p+rqE4XIL`q*]');
define('SECURE_AUTH_KEY',  'fqz|O4[w`/fm<KK2V{8R FtM&3M?).D*^LB3i@AT>N|Q$,}q+~KB_!=<}s+Rc?/B');
define('LOGGED_IN_KEY',    'F{[KAIO%/4Ub  -?w+it.bLH}gfw<SDm)sC|,_Xq3M||L9Qs;.mB[m(;S3jn) o:');
define('NONCE_KEY',        'M%qqRB&4`+K9$*w+:LyWb7psB0W+BJY}HG8^Pctb3TiJ)-ChAwo/5m6aT6{<(s[q');
define('AUTH_SALT',        'Z4,e`zi)!d(yJ_E||JH~<jQ}rCP;Wsh[!j?B|~qR=4|@_7JgjvSKdXx`il&He>,u');
define('SECURE_AUTH_SALT', 'FKMZ{Nsy&^kr`})Cd?^[Gm3-s~MrGmC*xHSj/I3Q4Dh<ip+f0KuyD%L<*>,->U-V');
define('LOGGED_IN_SALT',   '-mYp$>|Q#o>`Xi_X%M[skxB~0IA1WSc+|TNiWFR[fgO7Tc-%&0L*Oz6ibma_[kY;');
define('NONCE_SALT',       'b/[/-/@pDB_&opYcVz0+p[pRO^v]Ukm%gPg<>U?jwYP.??,0KXGULI.S$89pgf,%');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
