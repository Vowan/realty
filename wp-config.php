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
define('DB_NAME', 'WP-Realty-3');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'nbuser');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'i}/USn5`o(Xz.>yb#G!u#:WNjO~qz;?!q.1BN!TZK{OmKq{&x)mtwP>UQ:x,7uAF');
define('SECURE_AUTH_KEY',  'z  C{_R Ymg<NQy{jgm[jg(aZPX_DU|rtuswl^Z23.2hR5v3yX:|N]jhtHFeLleE');
define('LOGGED_IN_KEY',    'J1[|J6}+xaju9&Qst+#:XIK_s@s5y~X&QM6h6ERZ^=0($>iwv73&RjS@F^SHEPFh');
define('NONCE_KEY',        '>-5ihSsJ3V<<fm?P?5v{]&){GPin^]$+JrEESG|5QD32#K6[kk-fMQ!e7Q=8jP,Y');
define('AUTH_SALT',        'Z@sG,lkqzthlkW-5y}|A=]HS`2D*4r%4*(iqYg3d(s4,gyB{ZF`x:Yo)Bh+T a}C');
define('SECURE_AUTH_SALT', ')Tg K7;aqIJ6OUV]<aJTjLQJUNs*%65QyHu3(WZC]nA&!0^D@F<hjr.xoa9JRK4$');
define('LOGGED_IN_SALT',   'e#<4 C^QjBajC9@APD!+V6yzf0#<]]AMY2<.gP)}e{$# rBZ$xYG(fvnRL9KN8gO');
define('NONCE_SALT',       'sdFg}4XW%l8pF00ijhFXz?-YIl*O@u+K/ZA`g<Jheo@XT2FC|j<(8.GG)k@t6y]7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
