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
define('DB_NAME', 'bidding');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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

define('AUTH_KEY',         '(m.=Ymj $c.KnQR5weIqM<~*SUS8iwGaf{qFt+OgT>ruW.a)n)lC}Ml*%W54<N62');
define('SECURE_AUTH_KEY',  'D?V|2Ld5 =IU/ItCWt_zsF<wR18!>@O*jUbg2v&>#STVTMVR-MO{g4=Mbq@ecR=L');
define('LOGGED_IN_KEY',    '_Jn!dslz74, .}NBUq3TpTAEb~7|+VebYx^*AcP<6qmeUS@ZTnBH0?s;O@x gOBd');
define('NONCE_KEY',        '5*|sE&9mF4v-.#mlj9|IUf/F^L}uAm9fL;l#_.($yU`(|!Cx$$1Ae:UtMXgf6Hw%');
define('AUTH_SALT',        '&I6%k *)a9pvRG-Ro&Ld~Gperd&GF*K`9=+jSEE^1$SI4Q/f|lx*++e}&$D/FSwD');
define('SECURE_AUTH_SALT', 'Ocjah.zMSgVs9i-B7G_*5u5v@7[LF6v|ElGjV?G}]Xz|*@Z+; e+?F73eRmuhg8r');
define('LOGGED_IN_SALT',   '|To{aEigr+<wf3XJet*F4?w<GFX{!?n`39!3v>hl@25}/h=6qlpy<+]wkUkT4D*s');
define('NONCE_SALT',       '.7RVE?iU1vazCw-3a72L. vkU`fY74pu2Q!)][J+s;i[q:F$uM4x#+&RGL2%dCFP');

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
