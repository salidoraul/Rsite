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
//define('DB_NAME', 'RMPwordpress');
//
///** MySQL database username */
//define('DB_USER', 'RMPwordpress');
//
///** MySQL database password */
//define('DB_PASSWORD', 'db4Rmp@WP12##');
//
///** MySQL hostname */
//define('DB_HOST', '10.6.175.48');
//
///** Database Charset to use in creating database tables. */
//define('DB_CHARSET', 'utf8');
//
///** The Database Collate type. Don't change this if in doubt. */
//define('DB_COLLATE', '');

/* LOCAL */
define('DB_NAME', 'rsitedb');
define('DB_USER', 'rsitedb');
define('DB_PASSWORD', 'a##test4RMP12');
define('DB_HOST', '10.6.175.54');
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         ';97p;b^0pv0qib]VX1QPDD|3w`11c#LnCwi_he?S!C4$hTT6j_2s]]~RjBh*+JQs');
define('SECURE_AUTH_KEY',  'dr-6o+F8wPv~ $yUrl[.G|p<X/>Tq*,>:K*Y9N13]SPeZcb)tUH=h%$N)`7i oC!');
define('LOGGED_IN_KEY',    'h>WL_@ H1&>AbWK&*:Y_7%]E0T;*-;$NC.~$u-&P1L AIw8oV-E-MWaLm-wvQWUe');
define('NONCE_KEY',        '4FGj5H->NvuO8-__3)gH|!l@2-l9`(:F}H<ZSd&5;.X3FX|aH5r*cUcq,`V5F?d8');
define('AUTH_SALT',        'fMo|<qQC7dB|78oxtS35M.CkS;|A!nO7LX#=#LPSC1d^qV24#T} NII}9x5f||qM');
define('SECURE_AUTH_SALT', '{&x#qC4voe^X^ln@4jC MY$l5JR9V3;n6Y)eG]E_JX)}@(`~*tHChBPSaAbrx>q ');
define('LOGGED_IN_SALT',   'uu#R3mk-C3tqUAL2a5G)Qt6Qi.vWm{p2=KV~rn6.%Co/+]/j<(k33|@!Qkf^tb5H');
define('NONCE_SALT',       'tPE+!7Ue]8+6||uCbRtn`u4H<];0m(@~5_hIj>CX$*#G/rOfjFfyz]]>Gxf+EXwU');

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
