<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'PGPI' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jtn/Jzp)FAO$#4,Zp-(%N0&kes1JhM`x#Pc(+ E}~ZG.J$qq:g|,Tq%l~,epv+-{' );
define( 'SECURE_AUTH_KEY',  '`ET&)~Ua!VjDnz?8t923Ji[sM?crzsmr<xfL_f$y$PeATuG?tROAs;Iv[0:bU: p' );
define( 'LOGGED_IN_KEY',    '.xQRasI7!LS}B5RY7SUx$_)#D{Z=V)L|}jul^6cT{xNvv6>RM1lUl%UJ1seEZw=E' );
define( 'NONCE_KEY',        'JOJ(bd-zi@tB6Gk|sILUhR;K}d5:S]A_i slD%Vn7#8D*s:`{~4jpB]i7T:0lcr[' );
define( 'AUTH_SALT',        '!/_Ae/Y7BC$d)T](EcpH[:97bo^I8p)H;oZ15K&d8q*k_>|adRx7%C0e3:tQ m}=' );
define( 'SECURE_AUTH_SALT', 'Z&V5Vsib2;)]u9tq2*8j|qW}.UM,;nzEe4y&tzk xcor$.P^D1!n3=YS8T;#Up#(' );
define( 'LOGGED_IN_SALT',   'jsdn,BlNzH7hOCuFe%(jrKPgt}uAp>H3e5TjMm.o+,EuIrQJjPUXLlNL!0`qW[nS' );
define( 'NONCE_SALT',       'MlE?Rz*&,`Ryr1#64=zXY6FTn(sJ=+#lSF1obx;*;V7Yp%d(;U2_uQey5sN!ynj7' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
